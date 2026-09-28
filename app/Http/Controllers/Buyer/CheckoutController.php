<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Helper untuk mendapatkan identifikasi keranjang pengguna (User ID atau Session ID).
     */
    private function getCartIdentifier()
    {
        return Auth::check() ? ['user_id' => Auth::id()] : ['session_id' => session()->getId()];
    }

    /**
     * [FITUR CHECKOUT] Tampil Halaman Checkout Pesanan
     * Menghitung subtotal belanja, pajak/biaya penanganan, dan total yang harus dibayar.
     */
    public function index()
    {
        $cartItems = Cart::with('product')->where($this->getCartIdentifier())->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('pembeli.keranjang')->with('error', 'Keranjang belanja Anda kosong.');
        }

        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        $shippingCost = round($subtotal * 0.13); // 13% (8% Pajak + 5% Layanan)
        $total = $subtotal + $shippingCost;

        return view('pembeli.checkout', compact('cartItems', 'subtotal', 'shippingCost', 'total'));
    }

    /**
     * [FITUR CHECKOUT] Proses Simpan Pesanan ke Database
     * Mengisi nomor meja, membuat nomor order unik, menyimpan item pesanan, dan mengosongkan keranjang.
     */
    public function process(Request $request)
    {
        $request->validate([
            'recipient_name' => 'required|string|max:255',
            'table_number' => 'required|string|max:10',
            'email' => 'required|email|max:255',
            'payment_method' => 'required|in:kasir,qris',
            'shipping_notes' => 'nullable|string'
        ]);

        $cartItems = Cart::with('product')->where($this->getCartIdentifier())->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('pembeli.keranjang')->with('error', 'Keranjang belanja Anda kosong.');
        }

        \Illuminate\Support\Facades\DB::beginTransaction();

        try {
            $subtotal = 0;
            
            // Verifikasi stok sebelum membuat order
            foreach ($cartItems as $item) {
                if (!$item->product || $item->product->stock < $item->quantity) {
                    \Illuminate\Support\Facades\DB::rollBack();
                    $productName = $item->product ? $item->product->name : 'Produk tidak ditemukan';
                    return redirect()->route('pembeli.keranjang')->with('error', 'Maaf, stok tidak mencukupi untuk ' . $productName);
                }
                $subtotal += $item->product->price * $item->quantity;
            }

            $shippingCost = round($subtotal * 0.13); // Pajak 8% & Layanan 5%
            $totalAmount = $subtotal + $shippingCost;

            $count = Order::whereDate('created_at', now()->toDateString())->count() + 1;
            $seq = str_pad($count, 2, '0', STR_PAD_LEFT);
            $orderNumber = 'ORD' . now()->format('ymd') . $seq;

            // Buat Record Order Baru
            $order = new Order();
            $order->order_number = $orderNumber;
            $order->order_type = 'dine_in';
            $order->status = 'menunggu_pembayaran';
            $order->payment_method = $request->payment_method;
            $order->payment_status = 'belum_dibayar';
            $order->subtotal = $subtotal;
            $order->shipping_cost = $shippingCost;
            $order->total_amount = $totalAmount;
            $order->recipient_name = $request->recipient_name;
            $order->table_number = $request->table_number;
            $order->email = $request->email ?? (Auth::check() ? Auth::user()->email : null);
            $order->shipping_notes = $request->shipping_notes;
            $order->estimated_time = now()->addMinutes(15);
            
            if (Auth::check()) {
                $order->user_id = Auth::id();
            } else {
                $order->session_id = session()->getId();
            }
            
            $order->save();

            // Pindahkan Roti dari Keranjang ke Order Items
            foreach ($cartItems as $item) {
                $product = $item->product;
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $product->price
                ]);

                // Kurangi stok produk secara real-time dan update rating
                if ($product) {
                    $product->decrement('stock', $item->quantity);
                    if (method_exists($product, 'recalculateRating')) {
                        $product->recalculateRating();
                    }
                }
            }

            // Kosongkan Keranjang Belanja setelah Checkout
            Cart::where($this->getCartIdentifier())->delete();

            \Illuminate\Support\Facades\DB::commit();

            // Redirect ke Halaman Instruksi Pembayaran (Kasir / QRIS)
            if ($request->payment_method === 'kasir') {
                return redirect()->route('pembeli.pembayaran.kasir', $order->order_number);
            } else {
                return redirect()->route('pembeli.pembayaran.qris', $order->order_number);
            }
            
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return redirect()->route('pembeli.keranjang')->with('error', 'Terjadi kesalahan sistem saat memproses pesanan Anda. Silakan coba lagi.');
        }
    }
}
