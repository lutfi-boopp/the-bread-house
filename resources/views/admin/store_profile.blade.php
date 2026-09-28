{{-- ========================================================================================= --}}
{{-- [FITUR ADMIN] PENGATURAN PROFIL TOKO                                                      --}}
{{-- Fungsi: Memperbarui nama toko, nomor telepon, alamat, dan jam buka toko                   --}}
{{-- ========================================================================================= --}}
@extends('layouts.admin')

@section('content')
<div class="w-full max-w-4xl mx-auto">
    <!-- Header -->
    <div class="mb-10">
        <h2 class="font-heading text-4xl font-bold text-[#693e1b] mb-2">Profil Toko</h2>
        <p class="text-sm text-[#8c7a6b]">Kelola informasi operasional toko yang ditampilkan kepada pelanggan.</p>
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

    <div class="bg-white rounded-3xl p-8 lg:p-10 shadow-sm border border-[#ece3d4]">
        <div class="flex items-center mb-8 pb-6 border-b border-[#f5f0e6]">
            <div class="w-12 h-12 rounded-xl bg-[#f9f5f0] flex items-center justify-center mr-4">
                <i data-lucide="store" class="w-6 h-6 text-[#693e1b]"></i>
            </div>
            <div>
                <h3 class="font-heading text-xl font-bold text-[#2d251d]">Informasi Toko</h3>
                <p class="text-xs text-[#8c7a6b] mt-1">Perbarui detail kontak dan jadwal buka/tutup toko.</p>
            </div>
        </div>

        <form action="{{ route('admin.store-profile.update') }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="space-y-6 mb-8">
                <!-- Nama Toko -->
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-[#8c7a6b] uppercase tracking-wider ml-1">Nama Toko</label>
                    <input type="text" name="store_name" value="{{ old('store_name', $profile->store_name ?? 'The Bread House') }}" required class="w-full px-5 py-3.5 rounded-xl border border-[#ece3d4] text-sm text-[#2d251d] focus:ring-2 focus:ring-[#693e1b] focus:border-transparent bg-[#faf9f6] hover:bg-white transition-all outline-none">
                </div>

                <!-- Nomor Telepon -->
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-[#8c7a6b] uppercase tracking-wider ml-1">Nomor Telepon (WhatsApp)</label>
                    <input type="text" name="phone" value="{{ old('phone', $profile->phone ?? '') }}" placeholder="Contoh: 08123456789" class="w-full md:w-1/2 px-5 py-3.5 rounded-xl border border-[#ece3d4] text-sm text-[#2d251d] focus:ring-2 focus:ring-[#693e1b] focus:border-transparent bg-[#faf9f6] hover:bg-white transition-all outline-none">
                </div>

                <!-- Alamat -->
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-[#8c7a6b] uppercase tracking-wider ml-1">Alamat Lengkap</label>
                    <textarea name="address" rows="3" class="w-full px-5 py-3.5 rounded-xl border border-[#ece3d4] text-sm text-[#2d251d] focus:ring-2 focus:ring-[#693e1b] focus:border-transparent bg-[#faf9f6] hover:bg-white transition-all outline-none">{{ old('address', $profile->address ?? '') }}</textarea>
                </div>

                <!-- Jam Operasional -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-[#f5f0e6]">
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-[#8c7a6b] uppercase tracking-wider ml-1">Jam Buka (Senin - Jumat)</label>
                        <input type="text" name="weekday_hours" value="{{ old('weekday_hours', $profile->weekday_hours ?? '08:00 - 20:00') }}" placeholder="Contoh: 08:00 - 20:00" class="w-full px-5 py-3.5 rounded-xl border border-[#ece3d4] text-sm text-[#2d251d] focus:ring-2 focus:ring-[#693e1b] focus:border-transparent bg-[#faf9f6] hover:bg-white transition-all outline-none">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-[#8c7a6b] uppercase tracking-wider ml-1">Jam Buka (Sabtu - Minggu)</label>
                        <input type="text" name="weekend_hours" value="{{ old('weekend_hours', $profile->weekend_hours ?? '07:00 - 21:00') }}" placeholder="Contoh: 07:00 - 21:00" class="w-full px-5 py-3.5 rounded-xl border border-[#ece3d4] text-sm text-[#2d251d] focus:ring-2 focus:ring-[#693e1b] focus:border-transparent bg-[#faf9f6] hover:bg-white transition-all outline-none">
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-4 border-t border-[#f5f0e6]">
                <button type="submit" class="bg-[#693e1b] hover:bg-[#522d12] text-white px-8 py-3.5 rounded-xl text-sm font-bold transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5 flex items-center">
                    <i data-lucide="save" class="w-4 h-4 mr-2"></i> Simpan Profil Toko
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
