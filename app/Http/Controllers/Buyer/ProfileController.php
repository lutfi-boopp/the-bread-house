<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * [FITUR PROFIL] Tampil Halaman Profil Pembeli
     * Menampilkan data diri pembeli (jika admin/kasir membuka halaman ini, akan di-redirect ke dashboard masing-masing).
     */
    public function index()
    {
        $user = Auth::user();
        return view('pembeli.profil', compact('user'));
    }

    /**
     * [FITUR PROFIL] Update Biodata Pembeli
     * Memperbarui nama, alamat email, dan nomor telepon pembeli.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * [FITUR PROFIL] Update Kata Sandi Akun Pembeli
     * Memverifikasi kata sandi lama lalu melakukan hashing kata sandi baru.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('status', 'password-updated');
    }
}
