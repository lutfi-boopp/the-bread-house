<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\StoreProfile;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * [FITUR ADMIN] Dashboard Statistik Utama Admin
     * Menghitung total pendapatan hari ini, pesanan masuk, stok menipis, dan pelanggan baru.
     */
    public function dashboard()
    {
        $today = Carbon::today();
        
        // 1. Total Pendapatan Hari Ini
        $totalRevenue = Order::whereDate('created_at', $today)
                            ->where('status', 'selesai')
                            ->sum('total_amount');
                            
        // 2. Pesanan Masuk Hari Ini
        $totalOrders = Order::whereDate('created_at', $today)
                            ->whereNotIn('status', ['dibatalkan'])
                            ->count();
                            
        // 3. Stok Menipis (Threshold: 15)
        $lowStockCount = Product::where('stock', '<', 15)->count();
        
        // 4. Pelanggan Baru (Pembeli terdaftar bulan ini)
        $newCustomers = User::where('role', 'pembeli')
                            ->whereMonth('created_at', Carbon::now()->month)
                            ->whereYear('created_at', Carbon::now()->year)
                            ->count();
                            
        // 5. Pesanan Terbaru
        $recentOrders = Order::with(['user', 'orderItems.product'])
                            ->orderBy('created_at', 'desc')
                            ->take(6)
                            ->get();
                            
        // 6. Stok Roti
        $products = Product::orderBy('stock', 'asc')->get();

        return view('admin.dashboard', compact(
            'totalRevenue',
            'totalOrders',
            'lowStockCount',
            'newCustomers',
            'recentOrders',
            'products'
        ));
    }

    /**
     * [FITUR ADMIN] Halaman Kelola Stok Produk Roti
     * Menampilkan daftar semua produk roti dan jumlah stok saat ini.
     */
    public function stok()
    {
        $products = Product::orderBy('name', 'asc')->get();
        return view('admin.stok', compact('products'));
    }

    /**
     * [FITUR ADMIN] Update Jumlah Stok Roti
     * Memperbarui jumlah stok fisik roti di inventaris.
     */
    public function updateStok(Request $request, $id)
    {
        $request->validate([
            'stock' => 'required|integer|min:0'
        ]);

        $product = Product::findOrFail($id);
        $product->stock = $request->stock;
        $product->save();

        return redirect()->back()->with('success', 'Stok ' . $product->name . ' berhasil diperbarui!');
    }

    /**
     * [FITUR ADMIN] Halaman Manajemen Menu Roti
     * Menampilkan daftar katalog menu roti dan opsi tambah/edit/hapus.
     */
    public function menu()
    {
        $products = Product::with('category')->orderBy('name', 'asc')->get();
        $categories = \App\Models\Category::all();
        
        return view('admin.menu', compact('products', 'categories'));
    }

    /**
     * [FITUR ADMIN] Tambah Produk Roti Baru
     * Menyimpan data produk roti baru beserta unggah foto produk.
     */
    public function storeMenu(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|integer',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->except('image');
        $data['slug'] = \Illuminate\Support\Str::slug($request->name);
        
        if ($request->filled('image_url')) {
            try {
                $response = \Illuminate\Support\Facades\Http::get($request->image_url);
                if ($response->successful()) {
                    $name = 'products/' . uniqid() . '.jpg';
                    \Illuminate\Support\Facades\Storage::disk('public')->put($name, $response->body());
                    $data['image'] = $name;
                }
            } catch (\Exception $e) {
                // Ignore error
            }
        } elseif ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * [FITUR ADMIN] Update Data & Foto Produk Roti
     * Memperbarui informasi nama, kategori, harga, stok, atau gambar roti.
     */
    public function updateMenu(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|integer',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $product = Product::findOrFail($id);
        $data = $request->except('image');
        $data['slug'] = \Illuminate\Support\Str::slug($request->name);

        if ($request->filled('image_url')) {
            try {
                $response = \Illuminate\Support\Facades\Http::get($request->image_url);
                if ($response->successful()) {
                    if ($product->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($product->image)) {
                        \Illuminate\Support\Facades\Storage::disk('public')->delete($product->image);
                    }
                    $name = 'products/' . uniqid() . '.jpg';
                    \Illuminate\Support\Facades\Storage::disk('public')->put($name, $response->body());
                    $data['image'] = $name;
                }
            } catch (\Exception $e) {
                // Ignore error and fall back to existing image
            }
        } elseif ($request->hasFile('image')) {
            if ($product->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($product->image)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->back()->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * [FITUR ADMIN] Hapus Produk Roti
     * Menghapus data roti dan berkas fotonya dari penyimpanan server.
     */
    public function destroyMenu($id)
    {
        $product = Product::findOrFail($id);
        
        if ($product->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($product->image)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($product->image);
        }
        
        $product->delete();

        return redirect()->back()->with('success', 'Produk berhasil dihapus!');
    }

    /**
     * [FITUR ADMIN] Laporan Penjualan & Data Grafik (Chart.js)
     * Menghitung total pendapatan, rata-rata pesanan, roti terlaris, dan tren 6 bulan terakhir.
     */
    public function laporan(Request $request)
    {
        $now = Carbon::now();

        // Rentang waktu: Bulan ini
        $startDate = $now->copy()->startOfMonth();
        $endDate = $now->copy()->endOfMonth();

        // Rentang waktu: Bulan lalu (untuk perbandingan)
        $previousStartDate = $now->copy()->subMonth()->startOfMonth();
        $previousEndDate = $now->copy()->subMonth()->endOfMonth();

        // Query pesanan bulan ini (hanya yang selesai)
        $currentOrders = Order::where('status', 'selesai')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        // Query pesanan bulan lalu (untuk perbandingan persentase)
        $previousOrders = Order::where('status', 'selesai')
            ->whereBetween('created_at', [$previousStartDate, $previousEndDate])
            ->get();

        $totalPendapatan = $currentOrders->sum('total_amount');
        $previousPendapatan = $previousOrders->sum('total_amount');

        $jumlahPesanan = $currentOrders->count();
        $rataRataPesanan = $jumlahPesanan > 0 ? $totalPendapatan / $jumlahPesanan : 0;

        // Hitung persentase kenaikan/penurunan pendapatan dibanding bulan lalu
        $persentasePendapatan = 0;
        if ($previousPendapatan > 0) {
            $persentasePendapatan = (($totalPendapatan - $previousPendapatan) / $previousPendapatan) * 100;
        } elseif ($totalPendapatan > 0) {
            $persentasePendapatan = 100;
        }

        // Cari Roti Paling Laku Bulan Ini
        $produkTerlaris = \App\Models\OrderItem::selectRaw('product_id, SUM(quantity) as total_sold')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'selesai')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->groupBy('product_id')
            ->orderBy('total_sold', 'desc')
            ->first();

        if ($produkTerlaris) {
            $produkTerlaris->product = Product::find($produkTerlaris->product_id);
        }

        // Siapkan data grafik (6 Bulan Terakhir)
        $chartLabels = [];
        $chartData = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = $now->copy()->subMonths($i);
            $chartLabels[] = $date->translatedFormat('M Y');
            $chartData[] = Order::where('status', 'selesai')
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->sum('total_amount');
        }

        return view('admin.laporan', compact(
            'totalPendapatan', 
            'rataRataPesanan', 
            'persentasePendapatan',
            'produkTerlaris',
            'chartLabels',
            'chartData'
        ));
    }

    /**
     * [FITUR ADMIN] Halaman Kelola Akun Pengguna
     * Menampilkan daftar akun Admin & Kasir yang terdaftar.
     */
    public function akun()
    {
        $users = User::whereIn('role', ['admin', 'kasir'])->orderBy('created_at', 'desc')->get();
        $totalAdmin = $users->where('role', 'admin')->count();
        $totalKasir = $users->where('role', 'kasir')->count();

        return view('admin.akun', compact('users', 'totalAdmin', 'totalKasir'));
    }

    /**
     * [FITUR ADMIN] Tambah Akun Pengguna Baru
     * Membuat akun petugas Admin atau Kasir baru dengan password terenkripsi.
     */
    public function storeAkun(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,kasir',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->back()->with('success', 'Akun berhasil ditambahkan!');
    }

    /**
     * [FITUR ADMIN] Edit / Update Data Akun Pengguna
     * Memperbarui nama, email, role, atau kata sandi akun petugas.
     */
    public function updateAkun(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'role' => 'required|in:admin,kasir',
            'password' => 'nullable|string|min:8',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->back()->with('success', 'Informasi akun berhasil diperbarui!');
    }

    /**
     * [FITUR ADMIN] Hapus Akun Pengguna
     * Menghapus akun petugas (dengan pencegahan tidak bisa menghapus akun sendiri).
     */
    public function destroyAkun($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === \Illuminate\Support\Facades\Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri!');
        }

        $user->delete();

        return redirect()->back()->with('success', 'Akun berhasil dihapus!');
    }

    /**
     * [FITUR ADMIN] Halaman Pengaturan Profil Admin
     * Menampilkan profil admin yang sedang login.
     */
    public function pengaturan()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        return view('admin.pengaturan', compact('user'));
    }

    /**
     * [FITUR ADMIN] Update Profil Admin
     * Memperbarui nama dan email admin yang sedang aktif.
     */
    public function updateProfil(Request $request)
    {
        $user = \Illuminate\Support\Facades\Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * [FITUR ADMIN] Update Kata Sandi Admin
     * Memverifikasi kata sandi lama lalu memperbarui ke kata sandi baru.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = \Illuminate\Support\Facades\Auth::user();

        if (!\Illuminate\Support\Facades\Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error', 'Kata sandi saat ini tidak cocok!');
        }

        $user->update([
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', 'Kata sandi berhasil diperbarui!');
    }

    /**
     * [FITUR ADMIN] Halaman Kelola Profil Toko
     * Menampilkan profil toko.
     */
    public function storeProfile()
    {
        $profile = StoreProfile::first();
        return view('admin.store_profile', compact('profile'));
    }

    /**
     * [FITUR ADMIN] Update Profil Toko
     * Menyimpan profil toko.
     */
    public function updateStoreProfile(Request $request)
    {
        $request->validate([
            'store_name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'address' => 'required|string',
            'weekday_hours' => 'required|string|max:255',
            'weekend_hours' => 'required|string|max:255',
        ], [
            'store_name.required' => 'Nama toko wajib diisi.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'address.required' => 'Alamat lengkap wajib diisi.',
            'weekday_hours.required' => 'Jam operasional hari biasa wajib diisi.',
            'weekend_hours.required' => 'Jam operasional akhir pekan wajib diisi.',
        ]);

        $profile = StoreProfile::first();
        
        if ($profile) {
            $profile->update($request->all());
        } else {
            StoreProfile::create($request->all());
        }

        return redirect()->back()->with('success', 'Profil toko berhasil diperbarui!');
    }

    /**
     * [FITUR ADMIN] Halaman Kelola Kategori
     * Menampilkan daftar kategori menu roti.
     */
    public function kategori()
    {
        $categories = \App\Models\Category::withCount('products')->orderBy('name', 'asc')->get();
        return view('admin.kategori', compact('categories'));
    }

    /**
     * [FITUR ADMIN] Tambah Kategori Baru
     */
    public function storeKategori(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        \App\Models\Category::create([
            'name' => $request->name,
            'slug' => \Illuminate\Support\Str::slug($request->name),
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan!');
    }

    /**
     * [FITUR ADMIN] Update Kategori
     */
    public function updateKategori(Request $request, $id)
    {
        $category = \App\Models\Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => \Illuminate\Support\Str::slug($request->name),
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil diperbarui!');
    }

    /**
     * [FITUR ADMIN] Hapus Kategori
     */
    public function destroyKategori($id)
    {
        $category = \App\Models\Category::findOrFail($id);

        // Cek apakah ada produk yang masih menggunakan kategori ini
        if ($category->products()->count() > 0) {
            return redirect()->back()->with('error', 'Gagal dihapus! Kategori ini masih digunakan oleh produk roti.');
        }

        $category->delete();

        return redirect()->back()->with('success', 'Kategori berhasil dihapus!');
    }
}
