{{-- ========================================================================================= --}}
{{-- [FITUR ADMIN] PENGATURAN PROFIL & PASSWORD ADMIN                                         --}}
{{-- Fungsi: Memperbarui nama, alamat email, dan kata sandi akun admin yang aktif             --}}
{{-- ========================================================================================= --}}
@extends('layouts.admin')

@section('content')
<div class="w-full max-w-6xl mx-auto">
    <!-- Header -->
    <div class="mb-10">
        <h2 class="font-heading text-4xl font-bold text-[#693e1b] mb-2">Pengaturan Akun</h2>
        <p class="text-sm text-[#8c7a6b]">Kelola informasi profil pribadi dan keamanan akun Anda.</p>
    </div>

    @if($errors->any())
        <div class="bg-[#fadada] text-[#c94040] px-5 py-4 rounded-2xl mb-8 shadow-sm border border-[#f5c6c6]">
            <div class="flex items-center mb-2">
                <i data-lucide="alert-triangle" class="w-5 h-5 mr-3"></i>
                <span class="font-bold text-sm">Terdapat beberapa kesalahan:</span>
            </div>
            <ul class="list-disc pl-10 text-xs font-medium space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Main Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Left Column: Profile Summary -->
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-[#ece3d4] sticky top-8">
                <div class="flex flex-col items-center text-center mb-8">
                    <div class="w-24 h-24 rounded-full bg-gradient-to-br from-[#8c5a35] to-[#693e1b] text-white flex items-center justify-center font-bold text-4xl shadow-md mb-4 ring-4 ring-[#f9f5f0]">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <h3 class="font-heading text-2xl font-bold text-[#2d251d] mb-1">{{ $user->name }}</h3>
                    <div class="inline-flex items-center bg-[#f9f5f0] text-[#8c7a6b] text-xs font-bold px-3 py-1.5 rounded-lg">
                        <i data-lucide="shield" class="w-3.5 h-3.5 mr-1.5"></i> Hak Akses: {{ ucfirst($user->role) }}
                    </div>
                </div>

                <div class="space-y-5 text-sm pt-6 border-t border-[#f5f0e6]">
                    <div class="flex justify-between items-center">
                        <span class="text-[#8c7a6b] font-medium">Terdaftar Sejak</span>
                        <span class="font-bold text-[#2d251d]">{{ $user->created_at->translatedFormat('d F Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-[#8c7a6b] font-medium">Status Akun</span>
                        <span class="bg-[#e6f4ea] text-[#1e7e34] px-3 py-1 rounded-full text-[10px] font-bold tracking-wider uppercase">Aktif</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Settings Forms -->
        <div class="lg:col-span-8 space-y-8">
            
            <!-- Profil Admin -->
            <div class="bg-white rounded-3xl p-8 lg:p-10 shadow-sm border border-[#ece3d4]">
                <div class="flex items-center mb-8 pb-6 border-b border-[#f5f0e6]">
                    <div class="w-12 h-12 rounded-xl bg-[#f9f5f0] flex items-center justify-center mr-4">
                        <i data-lucide="user" class="w-6 h-6 text-[#693e1b]"></i>
                    </div>
                    <div>
                        <h3 class="font-heading text-xl font-bold text-[#2d251d]">Informasi Pribadi</h3>
                        <p class="text-xs text-[#8c7a6b] mt-1">Perbarui data diri dan alamat email Anda.</p>
                    </div>
                </div>

                <form action="{{ route('admin.pengaturan.profil') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-[#8c7a6b] uppercase tracking-wider ml-1">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-5 py-3.5 rounded-xl border border-[#ece3d4] text-sm text-[#2d251d] focus:ring-2 focus:ring-[#693e1b] focus:border-transparent bg-[#faf9f6] hover:bg-white transition-all outline-none">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-[#8c7a6b] uppercase tracking-wider ml-1">Alamat Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-5 py-3.5 rounded-xl border border-[#ece3d4] text-sm text-[#2d251d] focus:ring-2 focus:ring-[#693e1b] focus:border-transparent bg-[#faf9f6] hover:bg-white transition-all outline-none">
                        </div>
                    </div>

                    <div class="flex justify-end pt-2">
                        <button type="submit" class="bg-[#693e1b] hover:bg-[#522d12] text-white px-8 py-3.5 rounded-xl text-sm font-bold transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5 flex items-center">
                            <i data-lucide="save" class="w-4 h-4 mr-2"></i> Simpan Profil
                        </button>
                    </div>
                </form>
            </div>

            <!-- Keamanan -->
            <div class="bg-white rounded-3xl p-8 lg:p-10 shadow-sm border border-[#ece3d4]">
                <div class="flex items-center mb-8 pb-6 border-b border-[#f5f0e6]">
                    <div class="w-12 h-12 rounded-xl bg-[#fef0f0] flex items-center justify-center mr-4">
                        <i data-lucide="shield-check" class="w-6 h-6 text-[#c42b2b]"></i>
                    </div>
                    <div>
                        <h3 class="font-heading text-xl font-bold text-[#2d251d]">Keamanan Akun</h3>
                        <p class="text-xs text-[#8c7a6b] mt-1">Ubah kata sandi secara berkala untuk menjaga keamanan.</p>
                    </div>
                </div>

                <form action="{{ route('admin.pengaturan.password') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-2 mb-6">
                        <label class="block text-xs font-bold text-[#8c7a6b] uppercase tracking-wider ml-1">Kata Sandi Saat Ini</label>
                        <input type="password" name="current_password" required class="w-full md:w-1/2 px-5 py-3.5 rounded-xl border border-[#ece3d4] text-sm text-[#2d251d] focus:ring-2 focus:ring-[#c42b2b] focus:border-transparent bg-[#faf9f6] hover:bg-white transition-all outline-none">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-[#8c7a6b] uppercase tracking-wider ml-1">Kata Sandi Baru</label>
                            <input type="password" name="password" required placeholder="Minimal 8 karakter" class="w-full px-5 py-3.5 rounded-xl border border-[#ece3d4] text-sm text-[#2d251d] focus:ring-2 focus:ring-[#c42b2b] focus:border-transparent bg-[#faf9f6] hover:bg-white transition-all outline-none placeholder-gray-400">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-[#8c7a6b] uppercase tracking-wider ml-1">Konfirmasi Kata Sandi</label>
                            <input type="password" name="password_confirmation" required class="w-full px-5 py-3.5 rounded-xl border border-[#ece3d4] text-sm text-[#2d251d] focus:ring-2 focus:ring-[#c42b2b] focus:border-transparent bg-[#faf9f6] hover:bg-white transition-all outline-none">
                        </div>
                    </div>

                    <div class="flex justify-end pt-2">
                        <button type="submit" class="bg-[#2d251d] hover:bg-[#1a1510] text-white px-8 py-3.5 rounded-xl text-sm font-bold transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5 flex items-center">
                            <i data-lucide="key" class="w-4 h-4 mr-2"></i> Perbarui Sandi
                        </button>
                    </div>
                </form>
            </div>

            <!-- Metode Pembayaran & Preferensi Toko -->
            <div class="bg-white rounded-3xl p-8 lg:p-10 shadow-sm border border-[#ece3d4]">
                <div class="flex items-center mb-8 pb-6 border-b border-[#f5f0e6]">
                    <div class="w-12 h-12 rounded-xl bg-[#e6f4ea] flex items-center justify-center mr-4">
                        <i data-lucide="store" class="w-6 h-6 text-[#1d8a43]"></i>
                    </div>
                    <div>
                        <h3 class="font-heading text-xl font-bold text-[#2d251d]">Preferensi Toko</h3>
                        <p class="text-xs text-[#8c7a6b] mt-1">Pengaturan operasional dan metode pembayaran kasir.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="flex items-start p-5 rounded-2xl border-2 border-[#1d8a43] bg-[#f2fbf5] cursor-pointer transition-colors relative overflow-hidden group">
                        <div class="absolute top-0 right-0 w-16 h-16 bg-[#1d8a43] opacity-10 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                        <i data-lucide="banknote" class="w-6 h-6 text-[#1d8a43] mr-4 mt-0.5"></i>
                        <div class="flex-1">
                            <div class="text-sm font-bold text-[#2d251d]">Pembayaran Tunai (Kasir)</div>
                            <div class="text-xs text-[#8c7a6b] mt-1">Diterima di semua cabang.</div>
                        </div>
                        <i data-lucide="check-circle-2" class="w-5 h-5 text-[#1d8a43]"></i>
                    </div>

                    <div class="flex items-start p-5 rounded-2xl border-2 border-[#1d8a43] bg-[#f2fbf5] cursor-pointer transition-colors relative overflow-hidden group">
                        <div class="absolute top-0 right-0 w-16 h-16 bg-[#1d8a43] opacity-10 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                        <i data-lucide="qr-code" class="w-6 h-6 text-[#1d8a43] mr-4 mt-0.5"></i>
                        <div class="flex-1">
                            <div class="text-sm font-bold text-[#2d251d]">QRIS Terintegrasi</div>
                            <div class="text-xs text-[#8c7a6b] mt-1">Aktif dan otomatis validasi.</div>
                        </div>
                        <i data-lucide="check-circle-2" class="w-5 h-5 text-[#1d8a43]"></i>
                    </div>
                </div>

                <button type="button" onclick="alert('Fitur tambah metode pembayaran akan segera hadir!')" class="w-full bg-[#f9f5f0] hover:bg-[#f0e8dc] text-[#693e1b] py-4 rounded-2xl text-sm font-bold transition-all border border-dashed border-[#d4c5b0] hover:border-[#693e1b] flex justify-center items-center group">
                    <i data-lucide="plus" class="w-5 h-5 mr-2 text-[#8c7a6b] group-hover:text-[#693e1b] transition-colors"></i> 
                    Tambah Metode Pembayaran Baru
                </button>
            </div>

        </div>
    </div>
</div>
@endsection
