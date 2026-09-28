<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Helper untuk mendapatkan identifikasi keranjang (berdasarkan User ID atau Session ID Guest).
     */
    private function getCartIdentifier()
    {
        return Auth::check() ? ['user_id' => Auth::id()] : ['session_id' => session()->getId()];
    }

    /**
     * [FITUR KERANJANG] Tampil Daftar Roti di Keranjang Belanja
     * Menampilkan semua produk roti yang telah dimasukkan ke keranjang oleh pembeli/guest.
     */
    public function index()
    {
        $cartItems = Cart::with('product')->where($this->getCartIdentifier())->get();
        return view('pembeli.keranjang', compact('cartItems'));
    }

    /**
     * [FITUR KERANJANG] Tambah Roti ke Keranjang
     * Menyimpan produk roti ke dalam keranjang (apabila produk sudah ada, kuantitas akan ditambah).
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);

        // Cek apakah item sudah ada di keranjang
        $cartItem = Cart::where($this->getCartIdentifier())
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            // Update quantity
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            // Buat item baru
            $cartData = [
                'product_id' => $product->id,
                'quantity' => $request->quantity
            ];
            
            if (Auth::check()) {
                $cartData['user_id'] = Auth::id();
            } else {
                $cartData['session_id'] = session()->getId();
            }
            
            Cart::create($cartData);
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    /**
     * [FITUR KERANJANG] Update Kuantitas Roti di Keranjang
     * Memperbarui jumlah porsi/bungkus roti yang ingin dibeli.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cartItem = Cart::where($this->getCartIdentifier())->findOrFail($id);
        $cartItem->update(['quantity' => $request->quantity]);

        return redirect()->back()->with('success', 'Keranjang berhasil diperbarui!');
    }

    /**
     * [FITUR KERANJANG] Hapus Roti dari Keranjang
     * Menghapus item roti tertentu dari daftar keranjang belanja.
     */
    public function destroy($id)
    {
        $cartItem = Cart::where($this->getCartIdentifier())->findOrFail($id);
        $cartItem->delete();

        return redirect()->back()->with('success', 'Produk dihapus dari keranjang!');
    }
}
