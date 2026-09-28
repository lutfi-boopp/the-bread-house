@extends('layouts.pembeli')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="text-center mb-12">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-[#f9f5f0] mb-4 shadow-inner">
            <i data-lucide="help-circle" class="w-8 h-8 text-[#693e1b]"></i>
        </div>
        <h1 class="font-heading text-4xl font-bold text-[#332115] mb-4">Pusat Bantuan (FAQ)</h1>
        <p class="text-[#8c7a6b] max-w-xl mx-auto text-lg">
            Ada pertanyaan tentang roti kami? Temukan jawabannya di bawah ini.
        </p>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-[#ece3d4] p-8 md:p-10">
        <div class="space-y-6">
            
            <div class="group border border-[#ece3d4] rounded-2xl p-6 hover:border-[#b37a54] transition-all duration-300 hover:shadow-md cursor-default bg-[#faf9f6]">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full bg-[#fdf5eb] text-[#d97706] flex items-center justify-center flex-shrink-0 mt-1">
                        <i data-lucide="clock" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-[#332115] text-xl mb-3 pt-1.5">Apakah roti The Bread House tahan berapa lama?</h3>
                        <p class="text-[#7a6a5f] leading-relaxed">
                            Roti Sourdough kami dapat bertahan 3-4 hari di suhu ruang dalam wadah kedap udara atau kantong kertas.
                            Jika disimpan di dalam lemari es (chiller) bisa tahan hingga 1 minggu, dan di freezer hingga 1 bulan. 
                            Pastikan dihangatkan kembali sebelum dikonsumsi agar keraknya kembali renyah.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="group border border-[#ece3d4] rounded-2xl p-6 hover:border-[#b37a54] transition-all duration-300 hover:shadow-md cursor-default bg-[#faf9f6]">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full bg-[#fdf5eb] text-[#d97706] flex items-center justify-center flex-shrink-0 mt-1">
                        <i data-lucide="info" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-[#332115] text-xl mb-3 pt-1.5">Apakah roti ini vegan dan tanpa pengawet?</h3>
                        <p class="text-[#7a6a5f] leading-relaxed">
                            Ya, hampir semua roti artisan (sourdough dan baguette) kami 100% vegan karena hanya menggunakan tepung, air, ragi alami, dan garam.
                            Tentu saja, tidak ada bahan pengawet atau pelembut buatan. Khusus untuk Croissant dan Pastry, kami menggunakan mentega susu sapi asli.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection