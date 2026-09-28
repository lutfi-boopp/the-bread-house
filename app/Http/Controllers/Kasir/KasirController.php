<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class KasirController extends Controller
{
    /**
     * [FITUR KASIR] Dashboard Ringkasan Kasir
     * Menampilkan statistik pendapatan hari ini, jumlah transaksi, pelanggan aktif, dan item terpopuler.
     */
    public function dashboard()
    {
        $today = Carbon::today();

        $ordersToday = Order::whereDate('created_at', $today)
            ->whereNotIn('status', ['dibatalkan'])
            ->get();

        $revenueToday = $ordersToday->where('payment_status', 'sudah_dibayar')->sum('total_amount');
        $totalTransactions = $ordersToday->count();
        $activeCustomers = $ordersToday->pluck('user_id')->filter()->unique()->count();
        $pendingOrders = Order::where('status', 'menunggu_pembayaran')->count();

        $popularItems = OrderItem::select('order_items.product_id', 'products.name as product_name', DB::raw('SUM(order_items.quantity) as total_sold'), 'order_items.price')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->whereDate('orders.created_at', $today)
            ->whereNotIn('orders.status', ['dibatalkan'])
            ->groupBy('order_items.product_id', 'products.name', 'order_items.price')
            ->orderByDesc('total_sold')
            ->take(3)
            ->get();

        return view('kasir.dashboard', compact(
            'revenueToday',
            'totalTransactions',
            'activeCustomers',
            'pendingOrders',
            'popularItems'
        ));
    }

    /**
     * [FITUR KASIR] Antarmuka Point of Sale (POS) Toko
     * Menampilkan daftar roti yang siap dijual langsung di kasir toko.
     */
    public function pos()
    {
        $products = Product::where('is_active', true)->get();
        return view('kasir.pos', compact('products'));
    }

    /**
     * [FITUR KASIR] Proses Checkout POS Kasir
     * Memproses pesanan langsung di toko, memotong stok roti, dan menghitung uang kembalian tunai.
     */
    public function posCheckout(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'customer_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'amount_paid' => 'required|numeric|min:0'
        ]);

        DB::beginTransaction();

        try {
            $totalAmount = 0;
            $orderItems = [];

            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['id']);
                if ($product->stock < $item['quantity']) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Stok tidak mencukupi untuk ' . $product->name
                    ], 400);
                }

                $subtotal = $product->price * $item['quantity'];
                $totalAmount += $subtotal;

                $orderItems[] = [
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                ];

                $product->decrement('stock', $item['quantity']);
            }

            if ($request->amount_paid < $totalAmount) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Uang yang dibayarkan kurang dari total pesanan.'
                ], 400);
            }

            $count = Order::whereDate('created_at', Carbon::today())->count() + 1;
            $seq = str_pad($count, 2, '0', STR_PAD_LEFT);
            $orderNumber = 'ORD' . Carbon::now()->format('ymd') . $seq;

            $order = new Order();
            $order->user_id = null; // Guest or Walk-in
            $order->order_number = $orderNumber;
            $order->order_type = 'takeaway';
            $order->status = 'diproses';
            $order->payment_method = 'kasir';
            $order->payment_status = 'sudah_dibayar';
            
            $pajak = $totalAmount * 0.08;
            $layanan = $totalAmount * 0.05;
            $grandTotal = $totalAmount + $pajak + $layanan;
            
            $order->subtotal = $totalAmount;
            $order->shipping_cost = $pajak + $layanan; // using shipping_cost field for total extra fees
            $order->total_amount = $grandTotal;
            $order->recipient_name = $request->customer_name ?? 'Pelanggan Kasir';
            $order->email = $request->email;
            $order->save();

            foreach ($orderItems as $itemData) {
                $order->orderItems()->create($itemData);
            }

            DB::commit();

            if (!empty($order->email)) {
                try {
                    \Illuminate\Support\Facades\Mail::to($order->email)->send(new \App\Mail\OrderReceipt($order));
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Gagal mengirim email struk: ' . $e->getMessage());
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil dibuat!',
                'order_number' => $order->order_number,
                'change' => $request->amount_paid - $grandTotal
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * [FITUR KASIR] Daftar Pesanan Online Masuk
     * Menampilkan daftar pesanan dari pembeli yang menunggu konfirmasi pembayaran kasir.
     */
    public function orders()
    {
        $orders = Order::with('orderItems')
            ->whereIn('status', ['menunggu_pembayaran', 'diproses'])
            ->orderBy('created_at', 'asc')
            ->get();

        return view('kasir.orders', compact('orders'));
    }

    /**
     * [FITUR KASIR] Update Status Pesanan Online
     * Memperbarui status pesanan (misal dari 'menunggu_pembayaran' menjadi 'selesai' / 'dibatalkan').
     */
    public function updateOrderStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'status' => 'required|in:menunggu_pembayaran,diproses,selesai,dibatalkan'
        ]);

        // Mencegah kasir menyelesaikan pesanan QRIS yang belum di-scan (belum dibayar)
        if ($request->status === 'selesai' && $order->payment_method === 'qris' && $order->payment_status === 'belum_dibayar') {
            return redirect()->back()->with('error', 'Pesanan QRIS ini belum dibayar/discan oleh pembeli! Tunggu hingga statusnya Diproses.');
        }

        // Kembalikan stok jika pesanan dibatalkan
        if ($request->status === 'dibatalkan' && $order->status !== 'dibatalkan') {
            foreach ($order->orderItems as $item) {
                if ($item->product) {
                    $item->product->increment('stock', $item->quantity);
                }
            }
        }

        $order->status = $request->status;
        if ($request->status == 'selesai') {
            $order->payment_status = 'sudah_dibayar';
        }
        $order->save();

        if ($order->status == 'selesai' && !empty($order->email)) {
            try {
                \Illuminate\Support\Facades\Mail::to($order->email)->send(new \App\Mail\OrderReceipt($order));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Gagal mengirim email struk: ' . $e->getMessage());
            }
        }

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    /**
     * [FITUR KASIR] Halaman Scan QR Code
     * Menampilkan antarmuka pemindai QR Code nota pesanan pembeli.
     */
    public function scanQr()
    {
        return view('kasir.scan-qr');
    }

    /**
     * [FITUR KASIR] Proses Hasil Scan QR Code
     * Memvalidasi nomor pesanan hasil scan QR dan mengubah statusnya menjadi selesai & lunas.
     */
    public function processQr(Request $request)
    {
        $request->validate([
            'order_number' => 'required|string'
        ]);

        $order = Order::where('order_number', $request->order_number)->first();

        if (!$order) {
            return redirect()->back()->with('error', 'Pesanan tidak ditemukan.');
        }

        if ($order->status == 'selesai') {
            return redirect()->back()->with('info', 'Pesanan ini sudah selesai.');
        }

        if ($order->status == 'dibatalkan') {
            return redirect()->back()->with('error', 'Pesanan ini sudah dibatalkan.');
        }

        $order->update([
            'status' => 'selesai',
            'payment_status' => 'sudah_dibayar'
        ]);

        if (!empty($order->email)) {
            try {
                \Illuminate\Support\Facades\Mail::to($order->email)->send(new \App\Mail\OrderReceipt($order));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Gagal mengirim email struk: ' . $e->getMessage());
            }
        }

        return redirect()->back()->with('success', 'Pembayaran pesanan ' . $order->order_number . ' berhasil diproses.');
    }

    /**
     * [FITUR KASIR] Halaman Riwayat Transaksi Kasir
     * Menampilkan daftar semua riwayat transaksi kasir lengkap dengan ringkasan omzet hari ini.
     */
    public function history()
    {
        $today = Carbon::today();

        $ordersToday = Order::whereDate('created_at', $today)
            ->where('status', 'selesai')
            ->get();

        $revenueToday = $ordersToday->sum('total_amount');
        $totalTransactionsToday = $ordersToday->count();
        $averageTransactionToday = $totalTransactionsToday > 0 ? $revenueToday / $totalTransactionsToday : 0;

        $orders = Order::with('orderItems')
            ->whereIn('status', ['selesai', 'dibatalkan'])
            ->orderBy('updated_at', 'desc')
            ->paginate(15);

        return view('kasir.history', compact('orders', 'revenueToday', 'totalTransactionsToday', 'averageTransactionToday'));
    }

    /**
     * [FITUR KASIR] Cetak Struk Belanja Kasir
     * Menampilkan format cetak struk belanja khusus printer termal kasir (window.print()).
     */
    public function printReceipt($id)
    {
        $order = Order::with('orderItems.product')->findOrFail($id);

        if ($order->status !== 'selesai') {
            return redirect()->back()->with('error', 'Hanya pesanan yang sudah selesai yang dapat dicetak struknya.');
        }

        return view('kasir.struk', compact('order'));
    }
}
