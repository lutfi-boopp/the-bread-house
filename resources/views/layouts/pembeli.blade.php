{{-- ========================================================================================= --}}
{{-- [LAYOUT PEMBELI] TEMPLATE UTAMA HALAMAN PEMBELI --}}
{{-- Fungsi: Navbar utama, badge counter keranjang belanja, footer, & impor Tailwind CSS v4 --}}
{{-- ========================================================================================= --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'The Bread House') }} - Dashboard</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600|playfair-display:600,700&display=swap"
        rel="stylesheet" />

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .font-heading {
            font-family: 'Playfair Display', serif;
        }

        .font-sans {
            font-family: 'Inter', sans-serif;
        }

        /* Hide scrollbar for category pills */
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body class="bg-[#fbf9f4] text-[#332115] font-sans antialiased flex flex-col min-h-screen">

    <!-- Navbar -->
    <header class="bg-[#fbf9f4] sticky top-0 z-50 border-b border-[#e6dace]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="font-heading text-2xl font-bold text-[#6b3e1c]">
                        The Bread House
                    </a>
                </div>

                <!-- Navigation Links (Desktop) -->
                <nav class="hidden md:flex space-x-8">
                    <a href="{{ route('dashboard') }}"
                        class="{{ request()->routeIs('dashboard') ? 'text-[#332115] border-[#6b3e1c]' : 'text-[#7a6a5f] border-transparent hover:text-[#332115]' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                        Katalog
                    </a>
                    <a href="{{ route('pembeli.riwayat-pesanan') }}"
                        class="{{ request()->routeIs('pembeli.riwayat-pesanan') ? 'text-[#332115] border-[#6b3e1c]' : 'text-[#7a6a5f] border-transparent hover:text-[#332115]' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                        Pesanan Saya
                    </a>
                    <a href="{{ route('pembeli.tentang-kami') }}"
                        class="{{ request()->routeIs('pembeli.tentang-kami') ? 'text-[#332115] border-[#6b3e1c]' : 'text-[#7a6a5f] border-transparent hover:text-[#332115]' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                        Tentang Kami
                    </a>
                </nav>

                <!-- Right Side (Search, Cart, Profile) -->
                <div class="flex items-center space-x-6">
                    <!-- Search Bar -->
                    <div class="relative hidden sm:block">
                        <form action="{{ route('dashboard') }}" method="GET">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i data-lucide="search" class="h-4 w-4 text-gray-400"></i>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}"
                                class="block w-64 pl-10 pr-3 py-2 border border-gray-200 rounded-full leading-5 bg-[#f5efe6] text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-[#6b3e1c] focus:border-[#6b3e1c] sm:text-sm"
                                placeholder="Cari roti favorit...">
                        </form>
                    </div>

                    <!-- Cart -->
                    <a href="{{ route('pembeli.keranjang') }}" id="navbar-cart-link"
                        class="relative text-[#332115] hover:text-[#6b3e1c] transition-colors"
                        title="Keranjang Belanja">
                        <i data-lucide="shopping-cart" class="h-6 w-6"></i>
                        @php
                            if (auth()->check()) {
                                $cartCount = \App\Models\Cart::where('user_id', auth()->id())->sum('quantity');
                            } else {
                                $cartCount = \App\Models\Cart::where('session_id', session()->getId())->sum('quantity');
                            }
                        @endphp
                        @if($cartCount > 0)
                            <span
                                class="absolute -top-1 -right-1 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-white bg-red-600 rounded-full">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>

                    <!-- Profile Button -->
                    <div class="relative">
                        <a href="{{ route('pembeli.profil') }}"
                            class="flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#6b3e1c] bg-[#e6dace] p-1.5 text-[#6b3e1c] hover:bg-[#d5c3b1] transition-colors"
                            title="Profil Pengguna">
                            <span class="sr-only">Buka profil</span>
                            <i data-lucide="user" class="h-5 w-5"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer Premium -->
    <footer class="bg-[#332115] text-[#f5efe6] pt-16 pb-8 mt-16 relative overflow-hidden">
        <!-- Subtle Pattern or Accent -->
        <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-[#6b3e1c] via-[#d5c3b1] to-[#6b3e1c]"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 lg:gap-8 mb-12">

                <!-- 1. Brand Section -->
                <div class="lg:col-span-1">
                    <a href="{{ route('dashboard') }}"
                        class="inline-block font-heading text-3xl font-bold text-white mb-6 tracking-wide">
                        The Bread House<span class="text-[#d5c3b1]">.</span>
                    </a>
                    <p class="text-[#d5c3b1] text-sm leading-relaxed mb-6">
                        Memadukan resep klasik dengan bahan pilihan terbaik, menciptakan kelezatan yang menemani setiap
                        momen hangat Anda bersama orang terkasih.
                    </p>
                    <div class="flex items-center space-x-4">
                        <a href="https://instagram.com/thebreadhouse" target="_blank"
                            class="w-10 h-10 rounded-full bg-[#4a3222] flex items-center justify-center text-[#d5c3b1] hover:bg-[#d5c3b1] hover:text-[#332115] transition-all duration-300 transform hover:-translate-y-1"
                            title="Instagram">
                            <i data-lucide="instagram" class="h-5 w-5"></i>
                        </a>
                        <a href="mailto:hello@thebreadhouse.com"
                            class="w-10 h-10 rounded-full bg-[#4a3222] flex items-center justify-center text-[#d5c3b1] hover:bg-[#d5c3b1] hover:text-[#332115] transition-all duration-300 transform hover:-translate-y-1"
                            title="Email">
                            <i data-lucide="mail" class="h-5 w-5"></i>
                        </a>
                        <a href="https://wa.me/6281234567890" target="_blank"
                            class="w-10 h-10 rounded-full bg-[#4a3222] flex items-center justify-center text-[#d5c3b1] hover:bg-[#d5c3b1] hover:text-[#332115] transition-all duration-300 transform hover:-translate-y-1"
                            title="WhatsApp">
                            <i data-lucide="phone" class="h-5 w-5"></i>
                        </a>
                    </div>
                </div>

                <!-- 2. Menu Cepat -->
                <div>
                    <h3 class="text-white font-semibold tracking-wider uppercase text-sm mb-6 relative inline-block">
                        Menu Utama
                        <span class="absolute -bottom-2 left-0 w-1/2 h-0.5 bg-[#6b3e1c]"></span>
                    </h3>
                    <ul class="space-y-4">
                        <li><a href="{{ route('dashboard') }}"
                                class="text-[#d5c3b1] hover:text-white transition-colors text-sm flex items-center group"><span
                                    class="w-1.5 h-1.5 rounded-full bg-[#6b3e1c] mr-2 opacity-0 group-hover:opacity-100 transition-opacity"></span>
                                Katalog Roti</a></li>
                        <li><a href="{{ route('pembeli.riwayat-pesanan') }}"
                                class="text-[#d5c3b1] hover:text-white transition-colors text-sm flex items-center group"><span
                                    class="w-1.5 h-1.5 rounded-full bg-[#6b3e1c] mr-2 opacity-0 group-hover:opacity-100 transition-opacity"></span>
                                Pesanan Saya</a></li>
                        <li><a href="{{ route('pembeli.keranjang') }}"
                                class="text-[#d5c3b1] hover:text-white transition-colors text-sm flex items-center group"><span
                                    class="w-1.5 h-1.5 rounded-full bg-[#6b3e1c] mr-2 opacity-0 group-hover:opacity-100 transition-opacity"></span>
                                Keranjang Belanja</a></li>
                        <li><a href="{{ route('pembeli.tentang-kami') }}"
                                class="text-[#d5c3b1] hover:text-white transition-colors text-sm flex items-center group"><span
                                    class="w-1.5 h-1.5 rounded-full bg-[#6b3e1c] mr-2 opacity-0 group-hover:opacity-100 transition-opacity"></span>
                                Tentang Kami</a></li>
                    </ul>
                </div>

                <!-- 3. Informasi Layanan -->
                <div>
                    <h3 class="text-white font-semibold tracking-wider uppercase text-sm mb-6 relative inline-block">
                        Layanan Pelanggan
                        <span class="absolute -bottom-2 left-0 w-1/2 h-0.5 bg-[#6b3e1c]"></span>
                    </h3>
                    <ul class="space-y-4">
                        <li><a href="{{ route('pembeli.kontak') }}"
                                class="text-[#d5c3b1] hover:text-white transition-colors text-sm flex items-center group"><span
                                    class="w-1.5 h-1.5 rounded-full bg-[#6b3e1c] mr-2 opacity-0 group-hover:opacity-100 transition-opacity"></span>
                                Hubungi Kami</a></li>
                        <li><a href="{{ route('pembeli.syarat') }}"
                                class="text-[#d5c3b1] hover:text-white transition-colors text-sm flex items-center group"><span
                                    class="w-1.5 h-1.5 rounded-full bg-[#6b3e1c] mr-2 opacity-0 group-hover:opacity-100 transition-opacity"></span>
                                Syarat & Ketentuan</a></li>
                        <li><a href="{{ route('pembeli.privasi') }}"
                                class="text-[#d5c3b1] hover:text-white transition-colors text-sm flex items-center group"><span
                                    class="w-1.5 h-1.5 rounded-full bg-[#6b3e1c] mr-2 opacity-0 group-hover:opacity-100 transition-opacity"></span>
                                Kebijakan Privasi</a></li>
                        <li><a href="{{ route('pembeli.faq') }}"
                                class="text-[#d5c3b1] hover:text-white transition-colors text-sm flex items-center group"><span
                                    class="w-1.5 h-1.5 rounded-full bg-[#6b3e1c] mr-2 opacity-0 group-hover:opacity-100 transition-opacity"></span>
                                FAQ</a></li>
                    </ul>
                </div>

                <!-- 4. Kontak Info -->
                <div>
                    <h3 class="text-white font-semibold tracking-wider uppercase text-sm mb-6 relative inline-block">
                        Info Toko
                        <span class="absolute -bottom-2 left-0 w-1/2 h-0.5 bg-[#6b3e1c]"></span>
                    </h3>
                    <ul class="space-y-4">
                        <li class="flex items-start text-[#d5c3b1] text-sm leading-relaxed">
                            <i data-lucide="map-pin" class="w-5 h-5 mr-3 text-[#6b3e1c] flex-shrink-0 mt-0.5"></i>
                            <span>Jl. Jend. Sudirman No. 271<br>(Samping Polres Ciamis)<br>Sindangrasa, Kec.
                                Ciamis<br>Kab. Ciamis, Jawa Barat 46215</span>
                        </li>
                        <li class="flex items-center text-[#d5c3b1] text-sm leading-relaxed">
                            <i data-lucide="phone-call" class="w-5 h-5 mr-3 text-[#6b3e1c] flex-shrink-0"></i>
                            <span>+62 812-3456-7890</span>
                        </li>
                        <li class="flex items-center text-[#d5c3b1] text-sm leading-relaxed">
                            <i data-lucide="clock" class="w-5 h-5 mr-3 text-[#6b3e1c] flex-shrink-0"></i>
                            <span>Buka Setiap Hari: 07.00 - 21.00</span>
                        </li>
                    </ul>
                </div>

            </div>

            <!-- Bottom Copyright -->
            <div
                class="border-t border-[#4a3222] pt-8 mt-4 flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <p class="text-xs text-[#a38f7e]">
                    &copy; {{ date('Y') }} The Bread House. Dibuat dengan cinta untuk pecinta roti.
                </p>
                <div class="flex space-x-6 text-xs text-[#a38f7e]">
                    <span>Metode Pembayaran: Kasir & QRIS</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Initialize Lucide Icons -->
    <script>
        lucide.createIcons();
    </script>
</body>

</html>