@extends('layouts.pembeli')

@section('content')
<!-- Hero Section -->
<div class="bg-[#fbf9f4] border-b border-[#e6dace] py-16 lg:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="font-heading text-4xl lg:text-5xl font-bold text-[#332115] mb-6">Mari Berbincang</h1>
        <p class="text-[#7a6a5f] text-lg max-w-2xl mx-auto leading-relaxed">Kami selalu senang mendengar dari Anda. Baik itu tentang pesanan, acara spesial, atau sekadar membagikan kecintaan Anda pada roti sourdough buatan tangan.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-16 items-start">
        <!-- Contact Info (Spans 2 cols) -->
        <div class="lg:col-span-2 space-y-10">
            <div>
                <h3 class="font-heading text-2xl font-bold text-[#332115] mb-8">Informasi Kontak</h3>
                
                <div class="space-y-8">
                    <!-- Address -->
                    <div class="flex items-start group">
                        <div class="w-14 h-14 bg-[#f5efe6] rounded-2xl flex items-center justify-center text-[#6b3e1c] shrink-0 mr-5 transition-colors group-hover:bg-[#6b3e1c] group-hover:text-white">
                            <i data-lucide="map-pin" class="w-6 h-6"></i>
                        </div>
                        <div class="pt-1">
                            <h4 class="font-bold text-[#332115] text-lg mb-1">Kunjungi Toko Kami</h4>
                            <p class="text-[#7a6a5f] leading-relaxed">Jl. Jend. Sudirman No. 271<br>(Samping Polres Ciamis)<br>Sindangrasa, Kec. Ciamis<br>Kab. Ciamis, Jawa Barat 46215</p>
                        </div>
                    </div>
                    
                    <!-- Phone -->
                    <div class="flex items-start group">
                        <div class="w-14 h-14 bg-[#f5efe6] rounded-2xl flex items-center justify-center text-[#6b3e1c] shrink-0 mr-5 transition-colors group-hover:bg-[#6b3e1c] group-hover:text-white">
                            <i data-lucide="phone-call" class="w-6 h-6"></i>
                        </div>
                        <div class="pt-1">
                            <h4 class="font-bold text-[#332115] text-lg mb-1">Telepon & WhatsApp</h4>
                            <p class="text-[#7a6a5f] leading-relaxed">+62 812-3456-7890<br><span class="text-sm">Buka Setiap Hari: 07.00 - 21.00</span></p>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="flex items-start group">
                        <div class="w-14 h-14 bg-[#f5efe6] rounded-2xl flex items-center justify-center text-[#6b3e1c] shrink-0 mr-5 transition-colors group-hover:bg-[#6b3e1c] group-hover:text-white">
                            <i data-lucide="mail" class="w-6 h-6"></i>
                        </div>
                        <div class="pt-1">
                            <h4 class="font-bold text-[#332115] text-lg mb-1">Kirim Email</h4>
                            <p class="text-[#7a6a5f] leading-relaxed">hello@thebreadhouse.com<br><span class="text-sm">Kami akan membalas dalam 24 jam</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Form (Spans 3 cols) -->
        <div class="lg:col-span-3">
            <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-[#f0e6d5] p-8 md:p-12 relative overflow-hidden">
                <!-- Decorative element -->
                <div class="absolute top-0 right-0 w-32 h-32 bg-[#fbf9f4] rounded-bl-[100px] -z-10"></div>
                
                <h3 class="font-heading text-2xl font-bold text-[#332115] mb-2">Tinggalkan Pesan</h3>
                <p class="text-[#7a6a5f] mb-8">Isi formulir di bawah ini dan tim kami akan segera merespons Anda.</p>
                
                <form action="#" method="GET" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-[#332115]">Nama Lengkap</label>
                            <input type="text" class="w-full border-0 bg-[#fbf9f4] rounded-xl px-4 py-3.5 focus:ring-2 focus:ring-[#6b3e1c] transition-shadow text-[#332115]" placeholder="Cth: Andi Pratama">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-[#332115]">Alamat Email</label>
                            <input type="email" class="w-full border-0 bg-[#fbf9f4] rounded-xl px-4 py-3.5 focus:ring-2 focus:ring-[#6b3e1c] transition-shadow text-[#332115]" placeholder="hello@domain.com">
                        </div>
                    </div>
                    
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-[#332115]">Nomor Telepon (Opsional)</label>
                        <input type="tel" class="w-full border-0 bg-[#fbf9f4] rounded-xl px-4 py-3.5 focus:ring-2 focus:ring-[#6b3e1c] transition-shadow text-[#332115]" placeholder="08xx xxxx xxxx">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-[#332115]">Pesan Anda</label>
                        <textarea rows="5" class="w-full border-0 bg-[#fbf9f4] rounded-xl px-4 py-3.5 focus:ring-2 focus:ring-[#6b3e1c] transition-shadow text-[#332115] resize-none" placeholder="Tuliskan detail pesanan atau pertanyaan Anda di sini..."></textarea>
                    </div>
                    
                    <button type="button" onclick="alert('Terima kasih! Pesan Anda telah terkirim.')" class="w-full bg-[#6b3e1c] text-white py-4 rounded-xl font-bold tracking-wide hover:bg-[#5a3315] hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                        Kirim Pesan Sekarang
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
