@extends('layouts.pembeli')

@section('content')
    <!-- Hero Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8">
        <div class="relative w-full h-[400px] lg:h-[500px] overflow-hidden rounded-2xl shadow-md">
            <img src="https://www.hadirr.com/blog/wp-content/uploads/2023/02/Modal-untuk-Membuka-Usaha-Bakery-Roti.jpg"
                alt="Bakery Interior" class="absolute inset-0 w-full h-full object-cover">
            <div class="absolute inset-0 bg-black/40"></div>
            <div class="absolute inset-0 flex items-center p-6 sm:p-8 lg:p-14">
                <div class="bg-white/90 backdrop-blur-sm p-8 lg:p-12 rounded-xl max-w-2xl shadow-lg border border-white/50">
                    <h1 class="font-heading text-4xl lg:text-5xl font-bold text-[#6b3e1c] mb-4 leading-tight">Cerita di
                        Balik Setiap Kerak yang Sempurna</h1>
                    <p class="text-[#7a6a5f] text-lg">Sebuah perjalanan rasa, tekstur, dan dedikasi pada tradisi pembuatan
                        roti yang sejati.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Kisah Kami Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">
            <div>
                <h2 class="font-heading text-3xl lg:text-4xl font-bold text-[#332115] mb-6">Kisah Kami</h2>
                <div class="space-y-4 text-[#7a6a5f] leading-relaxed">
                    <p>Semuanya dimulai dari kecintaan yang mendalam pada sebongkah roti sourdough tradisional. Kami percaya
                        bahwa roti bukan sekadar makanan, melainkan medium penghubung antar manusia, alam, dan waktu.
                        The Bread House lahir dari dapur kecil, berbekal ragi liar (sourdough starter) yang kami pelihara dengan
                        cermat, dan tepung lokal terbaik.</p>
                    <p>Kami tidak terburu-buru. Setiap adonan melewati proses fermentasi lambat untuk mengembangkan rasa
                        kompleks dan tekstur lunak yang memuaskan. Ini adalah penghormatan kami terhadap seni pembuatan roti
                        artisanal yang otentik.</p>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <img src="https://images.unsplash.com/photo-1517686469429-8bdb88b9f907?q=80&w=800&auto=format&fit=crop"
                    alt="Kneading dough" class="rounded-xl object-cover h-[350px] w-full col-span-1 row-span-2 shadow-sm">
                <img src="https://images.immediate.co.uk/production/volatile/sites/30/2020/03/SourdoughStarter-45b0f9a.jpg?resize=1200%2C630"
                    alt="Sourdough Starter" class="rounded-xl object-cover h-[167px] w-full col-span-1 shadow-sm">
                <div class="bg-[#f5efe6] rounded-xl p-6 flex items-center justify-center text-center col-span-1 shadow-sm">
                    <h3 class="font-heading text-xl font-bold text-[#6b3e1c]">"Waktu adalah bahan rahasia kami."</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Nilai & Misi Section -->
    <div class="bg-[#fbf9f4] py-20 lg:py-24 border-y border-[#e6dace]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-14">
                <h2 class="font-heading text-3xl lg:text-4xl font-bold text-[#332115] mb-4">Nilai & Misi</h2>
                <p class="text-[#7a6a5f]">Komitmen tak tergoyahkan kami terhadap apa yang ada di dalam dan di luar roti
                    kami.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div
                    class="bg-white p-8 rounded-xl border border-[#f0e6d5] shadow-sm text-center transition-all duration-300 hover:-translate-y-2 hover:shadow-xl group">
                    <div
                        class="w-14 h-14 bg-[#f5efe6] rounded-full flex items-center justify-center mx-auto mb-6 text-[#6b3e1c] group-hover:bg-[#6b3e1c] group-hover:text-white transition-colors duration-300">
                        <i data-lucide="award" class="w-7 h-7"></i>
                    </div>
                    <h3 class="font-heading text-xl font-bold text-[#332115] mb-3">Keaslian</h3>
                    <p class="text-[#7a6a5f] text-sm leading-relaxed">Mempertahankan metode tradisional. Tanpa jalan pintas,
                        tanpa kompromi pada rasa dan tekstur sejati.</p>
                </div>
                <div
                    class="bg-white p-8 rounded-xl border border-[#f0e6d5] shadow-sm text-center transition-all duration-300 hover:-translate-y-2 hover:shadow-xl group">
                    <div
                        class="w-14 h-14 bg-[#f5efe6] rounded-full flex items-center justify-center mx-auto mb-6 text-[#6b3e1c] group-hover:bg-[#6b3e1c] group-hover:text-white transition-colors duration-300">
                        <i data-lucide="leaf" class="w-7 h-7"></i>
                    </div>
                    <h3 class="font-heading text-xl font-bold text-[#332115] mb-3">Bahan Murni</h3>
                    <p class="text-[#7a6a5f] text-sm leading-relaxed">Hanya menggunakan bahan alami berkualitas tinggi. 100%
                        bebas pengawet dan aditif buatan.</p>
                </div>
                <div
                    class="bg-white p-8 rounded-xl border border-[#f0e6d5] shadow-sm text-center transition-all duration-300 hover:-translate-y-2 hover:shadow-xl group">
                    <div
                        class="w-14 h-14 bg-[#f5efe6] rounded-full flex items-center justify-center mx-auto mb-6 text-[#6b3e1c] group-hover:bg-[#6b3e1c] group-hover:text-white transition-colors duration-300">
                        <i data-lucide="users" class="w-7 h-7"></i>
                    </div>
                    <h3 class="font-heading text-xl font-bold text-[#332115] mb-3">Pemberdayaan Lokal</h3>
                    <p class="text-[#7a6a5f] text-sm leading-relaxed">Bermitra langsung dengan petani gandum lokal dan
                        produsen garam laut untuk mendukung komunitas sekitar.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Proses Pembuatan -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28">
        <div class="text-center mb-12">
            <h2 class="font-heading text-3xl lg:text-4xl font-bold text-[#332115]">Proses Pembuatan</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Step 1 -->
            <div class="group relative rounded-xl overflow-hidden h-[320px] shadow-sm">
                <img src="https://images.unsplash.com/photo-1556910103-1c02745aae4d?q=80&w=600&auto=format&fit=crop"
                    alt="Pencampuran"
                    class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                <div class="absolute bottom-0 left-0 p-6 w-full">
                    <span class="text-white/80 text-xs font-semibold uppercase tracking-wider mb-1 block">Langkah 01</span>
                    <h3 class="font-heading text-white text-xl font-bold">Pencampuran & Autolisis</h3>
                </div>
            </div>
            <!-- Step 2 -->
            <div class="group relative rounded-xl overflow-hidden h-[320px] shadow-sm lg:mt-8">
                <img src="https://image.made-in-china.com/202f0j00ePNkhLHqCaoW/High-Quality-Bread-Proofer-French-Bakery-Equipment-Fermenting-Machine-for-Bread-Making.webp"
                    alt="Fermentasi"
                    class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                <div class="absolute bottom-0 left-0 p-6 w-full">
                    <span class="text-white/80 text-xs font-semibold uppercase tracking-wider mb-1 block">Langkah 02</span>
                    <h3 class="font-heading text-white text-xl font-bold">Fermentasi Panjang</h3>
                </div>
            </div>
            <!-- Step 3 -->
            <div class="group relative rounded-xl overflow-hidden h-[320px] shadow-sm">
                <img src="https://media.istockphoto.com/id/1459470189/photo/baker-scoring-loaves-of-bread-before-baking-them-in-an-oven.jpg?s=612x612&w=0&k=20&c=1Y_i1bY3Yd_42mnVeErIt8Q5tM5W0fFP1IL8NsWYloA="
                    alt="Scoring"
                    class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                <div class="absolute bottom-0 left-0 p-6 w-full">
                    <span class="text-white/80 text-xs font-semibold uppercase tracking-wider mb-1 block">Langkah 03</span>
                    <h3 class="font-heading text-white text-xl font-bold">Scoring Manual</h3>
                </div>
            </div>
            <!-- Step 4 -->
            <div class="group relative rounded-xl overflow-hidden h-[320px] shadow-sm lg:mt-8">
                <img src="https://images.unsplash.com/photo-1587241321921-91a834d6d191?q=80&w=600&auto=format&fit=crop"
                    alt="Pemanggangan"
                    class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                <div class="absolute bottom-0 left-0 p-6 w-full">
                    <span class="text-white/80 text-xs font-semibold uppercase tracking-wider mb-1 block">Langkah 04</span>
                    <h3 class="font-heading text-white text-xl font-bold">Pemanggangan Uap</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Wajah di Balik Oven -->
    <div class="bg-[#fbf9f4] py-20 lg:py-24 border-t border-[#e6dace]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-12">
                <div class="max-w-2xl">
                    <h2 class="font-heading text-3xl lg:text-4xl font-bold text-[#332115] mb-4">Wajah di Balik Oven</h2>
                    <p class="text-[#7a6a5f]">Tim kecil yang berdedikasi untuk membawa kehangatan roti segar ke meja Anda
                        setiap pagi.</p>
                </div>
                <a href="#" class="text-[#6b3e1c] font-semibold text-sm hover:underline shrink-0 pb-1">
                    Lihat Semua Tim &rarr;
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Team Member 1 -->
                <div
                    class="bg-white rounded-xl overflow-hidden shadow-sm border border-[#f0e6d5] transition-all duration-300 hover:-translate-y-2 hover:shadow-lg group">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQcaYr7CbOnBcG5Y5PD1qryddJS5FEFuqVWA26uhR3XdkvEaXyvmf2BahI&s=10"
                        alt="Budi Santoso" class="w-full h-64 object-cover object-top">
                    <div class="p-6">
                        <h3 class="font-heading text-xl font-bold text-[#332115] mb-1">Budi Santoso</h3>
                        <p class="text-[#6b3e1c] text-xs font-semibold uppercase tracking-wider mb-4">Pendiri & Kepala
                            Pembuat Roti</p>
                        <p class="text-[#7a6a5f] text-sm">Dengan pengalaman lebih dari 15 tahun, Budi membawa filosofi
                            fermentasi lambat dari Eropa ke bahan-bahan lokal.</p>
                    </div>
                </div>
                <!-- Team Member 2 -->
                <div
                    class="bg-white rounded-xl overflow-hidden shadow-sm border border-[#f0e6d5] transition-all duration-300 hover:-translate-y-2 hover:shadow-lg group">
                    <img src="https://cdn.antaranews.com/cache/1200x800/2021/08/08/Photo_MasterchefRenata_LZDINA.jpg"
                        alt="Siti Aminah" class="w-full h-64 object-cover">
                    <div class="p-6">
                        <h3 class="font-heading text-xl font-bold text-[#332115] mb-1">Chef Renata</h3>
                        <p class="text-[#6b3e1c] text-xs font-semibold uppercase tracking-wider mb-4">Spesialis Sourdough
                        </p>
                        <p class="text-[#7a6a5f] text-sm">Ahli dalam merawat ragi alam. Dedikasi Renata menghasilkan
                            croissant teringan dan kerak yang sempurna.</p>
                    </div>
                </div>
                <!-- Team Member 3 -->
                <div
                    class="bg-white rounded-xl overflow-hidden shadow-sm border border-[#f0e6d5] transition-all duration-300 hover:-translate-y-2 hover:shadow-lg group">
                    <img src="https://img.magnific.com/foto-gratis/feliz-joven-cocinero-uniforme-ensalada_171337-5347.jpg?semt=ais_hybrid&w=740&q=80"
                        alt="Andi Pratama" class="w-full h-64 object-cover">
                    <div class="p-6">
                        <h3 class="font-heading text-xl font-bold text-[#332115] mb-1">Chef Junaidi</h3>
                        <p class="text-[#6b3e1c] text-xs font-semibold uppercase tracking-wider mb-4">Asisten Pembuat Roti
                        </p>
                        <p class="text-[#7a6a5f] text-sm">Memastikan setiap pelanggan disambut dengan aroma roti segar dan
                            senyuman yang hangat setiap paginya.</p>
                    </div>
                </div>
            </div>
        </div>
@endsection