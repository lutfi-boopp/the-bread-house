<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class BuyerController extends Controller
{
    /**
     * [FITUR PEMBELI] Dashboard / Katalog Roti Utama
     * Menampilkan katalog roti, filter pencarian & kategori, serta ringkasan keranjang belanja.
     */
    public function dashboard(Request $request)
    {
        $category = $request->query('category');
        $search = $request->query('search');

        $categories = Category::all();

        $productsQuery = Product::where('is_active', true);

        if ($category) {
            $productsQuery->whereHas('category', function ($q) use ($category) {
                $q->where('slug', $category);
            });
        }

        if ($search) {
            $productsQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $products = $productsQuery->get();

        $identifier = Auth::check() ? ['user_id' => Auth::id()] : ['session_id' => session()->getId()];
        $cartItems = Cart::with('product')->where($identifier)->get();
        $cartTotal = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('pembeli.dashboard', compact('products', 'categories', 'category', 'cartItems', 'cartTotal'));
    }

    /**
     * [FITUR PEMBELI] Halaman Informasi Tentang Kami
     * Menampilkan profil toko roti, visi-misi, serta keunggulan produk UPI Bakery.
     */
    public function tentangKami()
    {
        return view('pembeli.tentang-kami');
    }
}
