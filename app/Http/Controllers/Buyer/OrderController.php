<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Helper untuk pencarian order berdasarkan User ID atau Session ID.
     */
    private function getOrderIdentifier()
    {
        return Auth::check() ? ['user_id' => Auth::id()] : ['session_id' => session()->getId()];
    }

    /**
     * [FITUR PESANAN PEMBELI] Riwayat Pesanan Pembeli
     * Menampilkan daftar semua pesanan lampau dan status pesanan saat ini (dengan paginasi).
     */
    public function history(Request $request)
    {
        $status = $request->query('status');
        $query = Order::where($this->getOrderIdentifier());
        
        if ($status) {
            $query->where('status', $status);
        }
        
        $orders = $query->orderBy('created_at', 'desc')->paginate(5);
        $orders->appends(['status' => $status]);
                      
        return view('pembeli.riwayat-pesanan', compact('orders', 'status'));
    }

    /**
     * [FITUR PESANAN PEMBELI] Rincian / Detail Pesanan
     * Menampilkan detail item roti yang dibeli, nomor meja, total harga, dan nomor pesanan.
     */
    public function detail($order_number)
    {
        $order = Order::with('orderItems.product')
                      ->where($this->getOrderIdentifier())
                      ->where('order_number', $order_number)
                      ->firstOrFail();
                      
        return view('pembeli.pesanan-detail', compact('order'));
    }

    /**
     * [FITUR PEMBAYARAN] Halaman Instruksi Pembayaran di Kasir
     * Menampilkan instruksi untuk melakukan pembayaran tunai langsung di kasir toko.
     */
    public function pembayaranKasir($order_number)
    {
        $order = Order::where($this->getOrderIdentifier())
                      ->where('order_number', $order_number)
                      ->firstOrFail();
                      
        if ($order->status !== 'menunggu_pembayaran') {
            return redirect()->route('pembeli.pembayaran.sukses', $order_number);
        }
                      
        return view('pembeli.pembayaran-kasir', compact('order'));
    }

    /**
     * [FITUR PEMBAYARAN] Cek Status Pesanan via AJAX
     * Mengembalikan status pesanan (menunggu_pembayaran / selesai) dalam format JSON untuk timer/polling.
     */
    public function checkStatus($order_number)
    {
        $order = Order::where($this->getOrderIdentifier())
                      ->where('order_number', $order_number)
                      ->first();
                      
        if (!$order) {
            return response()->json(['status' => 'not_found'], 404);
        }
        
        return response()->json(['status' => $order->status]);
    }

    /**
     * [FITUR PEMBAYARAN] Halaman Pembayaran QRIS
     * Menampilkan Kode QRIS dan hitung mundur timer batas waktu pembayaran.
     */
    public function pembayaranQris($order_number)
    {
        $order = Order::where($this->getOrderIdentifier())
                      ->where('order_number', $order_number)
                      ->firstOrFail();
                      
        return view('pembeli.pembayaran-qris', compact('order'));
    }
    /**
     * [FITUR TESTING] Simulasi Scan QRIS
     * Mengubah status pesanan secara instan saat URL diakses (seolah-olah discan).
     */
    public function simulatePayment($order_number)
    {
        $order = Order::where($this->getOrderIdentifier())
                      ->where('order_number', $order_number)
                      ->firstOrFail();
                      
        if ($order->status === 'menunggu_pembayaran') {
            $order->update([
                'status' => 'diproses',
                'payment_status' => 'sudah_dibayar'
            ]);
        }
        
        return "<h1>Pembayaran Berhasil!</h1><p>Sistem otomatis mendeteksi pembayaran. Silakan lihat layar komputer Anda, pesanan akan otomatis terproses.</p>";
    }

    /**
     * [FITUR PEMBAYARAN] Halaman Konfirmasi Pembayaran Sukses
     * Mengubah status pesanan menjadi 'selesai' & 'sudah_dibayar' setelah konfirmasi pembayaran.
     */
    public function pembayaranSukses($order_number)
    {
        $order = Order::where($this->getOrderIdentifier())
                      ->where('order_number', $order_number)
                      ->firstOrFail();
                      
        // Kita tidak update status otomatis disini lagi, karena sudah ditangani simulasi/kasir
        // Namun sebagai fallback/keamanan jika mereka manual ke sini:
        if ($order->status === 'menunggu_pembayaran') {
            // Biarkan saja statusnya menunggu_pembayaran jika belum ada verifikasi
            // ATAU ubah ke diproses jika ingin melonggarkan
        }
                      
        return view('pembeli.pembayaran-sukses', compact('order'));
    }
}
