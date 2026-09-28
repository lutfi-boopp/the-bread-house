<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

use App\Http\Controllers\Buyer\BuyerController;
use App\Http\Controllers\Buyer\CartController;
use App\Http\Controllers\Buyer\CheckoutController;
use App\Http\Controllers\Buyer\OrderController;
use App\Http\Controllers\Buyer\ProfileController;
use App\Http\Controllers\Kasir\KasirController;
use App\Http\Controllers\Admin\AdminController;

/*
|--------------------------------------------------------------------------
| 🌐 FITUR UMUM & BERANDA (PUBLIC & DASHBOARD PEMBELI)
|--------------------------------------------------------------------------
*/
// [FITUR] Redirect halaman utama ke dashboard
Route::get('/', function () {
    return redirect('/dashboard');
});

// [FITUR] Halaman Utama / Katalog Roti (Pembeli & Guest)
Route::get('/dashboard', [BuyerController::class, 'dashboard'])->name('dashboard');

// [FITUR] Halaman Informasi Tentang Kami (Profil Toko Roti UPI Bakery)
Route::get('/tentang-kami', [BuyerController::class, 'tentangKami'])->name('pembeli.tentang-kami');

// [FITUR] Halaman Bantuan Tambahan
Route::get('/kontak', function () { return view('pembeli.kontak'); })->name('pembeli.kontak');
Route::get('/faq', function () { return view('pembeli.faq'); })->name('pembeli.faq');
Route::get('/syarat-ketentuan', function () { return view('pembeli.syarat'); })->name('pembeli.syarat');
Route::get('/kebijakan-privasi', function () { return view('pembeli.privasi'); })->name('pembeli.privasi');

/*
|--------------------------------------------------------------------------
| 🛒 FITUR KERANJANG BELANJA (CART)
|--------------------------------------------------------------------------
*/
// [FITUR] Tampil daftar produk di keranjang belanja
Route::get('/keranjang', [CartController::class, 'index'])->name('pembeli.keranjang');

// [FITUR] Tambah produk roti ke keranjang
Route::post('/keranjang', [CartController::class, 'store'])->name('pembeli.keranjang.store');

// [FITUR] Update jumlah/kuantitas roti di keranjang
Route::put('/keranjang/{id}', [CartController::class, 'update'])->name('pembeli.keranjang.update');

// [FITUR] Hapus item roti dari keranjang
Route::delete('/keranjang/{id}', [CartController::class, 'destroy'])->name('pembeli.keranjang.destroy');

/*
|--------------------------------------------------------------------------
| 💳 FITUR CHECKOUT & PEMBAYARAN PEMBELI
|--------------------------------------------------------------------------
*/
// [FITUR] Tampil halaman checkout pesanan
Route::get('/checkout', [CheckoutController::class, 'index'])->name('pembeli.checkout');

// [FITUR] Proses simpan pesanan checkout ke database
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('pembeli.checkout.process');

// [FITUR] Tampil instruksi pembayaran Kasir (Pesan Online, Bayar di Toko)
Route::get('/pembayaran/kasir/{order_number}', [OrderController::class, 'pembayaranKasir'])->name('pembeli.pembayaran.kasir');

// [FITUR] Tampil instruksi & Kode QRIS untuk pembayaran nontunai
Route::get('/pembayaran/qris/{order_number}', [OrderController::class, 'pembayaranQris'])->name('pembeli.pembayaran.qris');

// [FITUR TESTING] Simulasi scan QRIS otomatis sukses
Route::get('/pembayaran/simulate/{order_number}', [OrderController::class, 'simulatePayment'])->name('pembeli.pembayaran.simulate');

// [FITUR] Tampil halaman konfirmasi pembayaran sukses
Route::get('/pembayaran/sukses/{order_number}', [OrderController::class, 'pembayaranSukses'])->name('pembeli.pembayaran.sukses');

/*
|--------------------------------------------------------------------------
| 📦 FITUR MANAJEMEN PESANAN & RIWAYAT PEMBELI
|--------------------------------------------------------------------------
*/
// [FITUR] Lihat rincian/detail pesanan pembeli berdasarkan nomor order
Route::get('/pesanan/{order_number}/detail', [OrderController::class, 'detail'])->name('pembeli.pesanan.detail');

// [FITUR] Cek status pembayaran & status pesanan via AJAX/Fetch
Route::get('/pesanan/{order_number}/status', [OrderController::class, 'checkStatus'])->name('pembeli.pesanan.status');

// [FITUR] Tampil profil pembeli
Route::get('/profil', [ProfileController::class, 'index'])->name('pembeli.profil');

// [FITUR] Tampil riwayat semua pesanan pembeli
Route::get('/riwayat-pesanan', [OrderController::class, 'history'])->name('pembeli.riwayat-pesanan');

/*
|--------------------------------------------------------------------------
| 🔧 UTILITY & MIGRATION HELPER
|--------------------------------------------------------------------------
*/
// [UTILITY] Jalankan migrasi database otomatis dari URL
Route::get('/run-migrate', function () {
    \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
    return redirect()->route('dashboard')->with('success', 'Database berhasil diperbarui! Anda kini bisa belanja sebagai Guest.');
});

// [UTILITY] Pindahkan pesanan guest ke akun default hello@thebreadhouse.com
Route::get('/transfer-guest-orders', function () {
    $user = \App\Models\User::where('email', 'hello@thebreadhouse.com')->first();
    if ($user) {
        \App\Models\Order::where('user_id', null)->update(['user_id' => $user->id]);
        return redirect()->route('dashboard')->with('success', 'Semua riwayat pesanan lama telah dipindahkan ke akun hello@thebreadhouse.com!');
    }
    return 'Akun hello@thebreadhouse.com tidak ditemukan di database.';
});

/*
|--------------------------------------------------------------------------
| 👤 FITUR PROFIL PEMBELI TERPROTEKSI (PROTECTED BUYER ROUTES)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', \App\Http\Middleware\PreventBackHistory::class])->group(function () {
    // [FITUR] Update data nama, email, dan alamat profil pembeli
    Route::put('/profil', [ProfileController::class, 'update'])->name('pembeli.profil.update');
    
    // [FITUR] Update kata sandi/password akun pembeli
    Route::put('/profil/password', [ProfileController::class, 'updatePassword'])->name('pembeli.profil.password');
});

/*
|--------------------------------------------------------------------------
| 👑 FITUR ADMIN (PANEL ADMIN MANAGEMENT)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin', \App\Http\Middleware\PreventBackHistory::class])->group(function () {
    // [FITUR ADMIN] Dashboard Statistik Utama Admin
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // [FITUR ADMIN] Halaman Kelola Stok Produk Roti
    Route::get('/admin/stok', [AdminController::class, 'stok'])->name('admin.stok');

    // [FITUR ADMIN] Proses Simpan Update Jumlah Stok Roti
    Route::post('/admin/stok/{id}/update', [AdminController::class, 'updateStok'])->name('admin.stok.update');

    // [FITUR ADMIN] Halaman Kelola Kategori
    Route::get('/admin/kategori', [AdminController::class, 'kategori'])->name('admin.kategori');
    Route::post('/admin/kategori', [AdminController::class, 'storeKategori'])->name('admin.kategori.store');
    Route::put('/admin/kategori/{id}', [AdminController::class, 'updateKategori'])->name('admin.kategori.update');
    Route::delete('/admin/kategori/{id}', [AdminController::class, 'destroyKategori'])->name('admin.kategori.destroy');

    // [FITUR ADMIN] Halaman Kelola Katalog Menu Roti
    Route::get('/admin/menu', [AdminController::class, 'menu'])->name('admin.menu');

    // [FITUR ADMIN] Tambah Produk Roti Baru
    Route::post('/admin/menu/store', [AdminController::class, 'storeMenu'])->name('admin.menu.store');

    // [FITUR ADMIN] Edit / Update Data Produk Roti
    Route::put('/admin/menu/{id}/update', [AdminController::class, 'updateMenu'])->name('admin.menu.update');

    // [FITUR ADMIN] Hapus Produk Roti dari Katalog
    Route::delete('/admin/menu/{id}/destroy', [AdminController::class, 'destroyMenu'])->name('admin.menu.destroy');

    // [FITUR ADMIN] Halaman Laporan Penjualan & Grafik Analisis (Chart.js)
    Route::get('/admin/laporan', [AdminController::class, 'laporan'])->name('admin.laporan');

    // [FITUR ADMIN] Halaman Kelola Akun Pengguna (Admin & Kasir)
    Route::get('/admin/akun', [AdminController::class, 'akun'])->name('admin.akun');

    // [FITUR ADMIN] Tambah Akun Pengguna Baru (Admin / Kasir)
    Route::post('/admin/akun', [AdminController::class, 'storeAkun'])->name('admin.akun.store');

    // [FITUR ADMIN] Edit Data Akun Pengguna
    Route::put('/admin/akun/{id}', [AdminController::class, 'updateAkun'])->name('admin.akun.update');

    // [FITUR ADMIN] Hapus Akun Pengguna
    Route::delete('/admin/akun/{id}', [AdminController::class, 'destroyAkun'])->name('admin.akun.destroy');

    // [FITUR ADMIN] Halaman Pengaturan Profil & Password Admin
    Route::get('/admin/pengaturan', [AdminController::class, 'pengaturan'])->name('admin.pengaturan');

    // [FITUR ADMIN] Halaman Kelola Profil Toko
    Route::get('/admin/profil-toko', [AdminController::class, 'storeProfile'])->name('admin.store-profile');

    // [FITUR ADMIN] Update Profil Toko
    Route::put('/admin/profil-toko/update', [AdminController::class, 'updateStoreProfile'])->name('admin.store-profile.update');

    Route::put('/admin/pengaturan/profil', [AdminController::class, 'updateProfil'])->name('admin.pengaturan.profil');
    Route::put('/admin/pengaturan/password', [AdminController::class, 'updatePassword'])->name('admin.pengaturan.password');
});

/*
|--------------------------------------------------------------------------
| 💵 FITUR KASIR (POS & TRANSAKSI KASIR)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:kasir', \App\Http\Middleware\PreventBackHistory::class])->prefix('kasir')->name('kasir.')->group(function () {
    // [FITUR KASIR] Dashboard Ringkasan Kasir
    Route::get('/dashboard', [KasirController::class, 'dashboard'])->name('dashboard');

    // [FITUR KASIR] Antarmuka Point of Sale (POS) Transaksi Toko Langsung
    Route::get('/pos', [KasirController::class, 'pos'])->name('pos');

    // [FITUR KASIR] Proses Checkout POS & Hitung Kembalian Uang Tunai
    Route::post('/pos/checkout', [KasirController::class, 'posCheckout'])->name('pos.checkout');

    // [FITUR KASIR] Halaman Scan QR Code Nota Pesanan
    Route::get('/scan-qr', [KasirController::class, 'scanQr'])->name('scan-qr');

    // [FITUR KASIR] Proses Verifikasi Hasil Scan QR Code Pesanan
    Route::post('/process-qr', [KasirController::class, 'processQr'])->name('process-qr');

    // [FITUR KASIR] Halaman Daftar Pesanan Online Masuk
    Route::get('/orders', [KasirController::class, 'orders'])->name('orders');

    // [FITUR KASIR] Update Status Pembayaran/Pesanan (Proses, Selesai, Batalkan)
    Route::put('/orders/{id}/status', [KasirController::class, 'updateOrderStatus'])->name('orders.update-status');

    // [FITUR KASIR] Cetak Struk Belanja Kasir (Print Receipt)
    Route::get('/orders/{id}/print', [KasirController::class, 'printReceipt'])->name('orders.print');

    // [FITUR KASIR] Riwayat Transaksi Kasir
    Route::get('/history', [KasirController::class, 'history'])->name('history');
});

/*
|--------------------------------------------------------------------------
| 🔑 FITUR AUTENTIKASI & KEAMANAN (LOGIN, REGISTER, LOGOUT, RECAPTCHA)
|--------------------------------------------------------------------------
*/
// [FITUR AUTH] Form Login Pengguna
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// [FITUR AUTH] Proses Login + Validasi Google reCAPTCHA
Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
        'g-recaptcha-response' => 'required',
    ], [
        'g-recaptcha-response.required' => 'Mohon centang CAPTCHA terlebih dahulu.',
    ]);

    // Validasi token reCAPTCHA ke Server Google
    $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
        'secret' => env('NOCAPTCHA_SECRET'),
        'response' => $request->input('g-recaptcha-response'),
        'remoteip' => $request->ip(),
    ]);

    if (!$response->json('success')) {
        return back()->withErrors(['g-recaptcha-response' => 'Validasi CAPTCHA gagal. Silakan coba lagi.'])->withInput();
    }

    unset($credentials['g-recaptcha-response']);

    // Autentikasi Pengguna & Redirect Berdasarkan Role (Admin / Kasir / Pembeli)
    if (Auth::attempt($credentials, $request->boolean('remember'))) {
        $request->session()->regenerate();
        $role = Auth::user()->role;
        if ($role === 'admin') {
            return redirect('/admin/dashboard');
        } elseif ($role === 'kasir') {
            return redirect('/kasir/orders');
        }
        return redirect('/dashboard');
    }

    return back()->withErrors([
        'email' => 'Email atau kata sandi salah.',
    ])->onlyInput('email');
});

// [FITUR AUTH] Form Registrasi Akun Pembeli Baru
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// [FITUR AUTH] Proses Registrasi Akun + Validasi Google reCAPTCHA + Hash Password
Route::post('/register', function (Request $request) {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'g-recaptcha-response' => 'required',
    ], [
        'g-recaptcha-response.required' => 'Mohon centang CAPTCHA terlebih dahulu.',
    ]);

    // Validasi token reCAPTCHA ke Server Google
    $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
        'secret' => env('NOCAPTCHA_SECRET'),
        'response' => $request->input('g-recaptcha-response'),
        'remoteip' => $request->ip(),
    ]);

    if (!$response->json('success')) {
        return back()->withErrors(['g-recaptcha-response' => 'Validasi CAPTCHA gagal. Silakan coba lagi.'])->withInput();
    }

    // Simpan Akun Pengguna Baru
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    return redirect('/login');
});

// [FITUR AUTH] Proses Logout & Invalidate Session
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
})->name('logout');

use App\Mail\OrderReceipt;
use Illuminate\Support\Facades\Mail;
Route::get('/test-email', function () {
    $order = \App\Models\Order::orderBy('id', 'desc')->first();
    if (!$order) return "No order";
    
    return view('emails.orders.receipt', ['order' => $order]);
});

