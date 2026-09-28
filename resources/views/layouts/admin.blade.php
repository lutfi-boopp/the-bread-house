{{-- ========================================================================================= --}}
{{-- [LAYOUT ADMIN] TEMPLATE UTAMA PANEL ADMIN --}}
{{-- Fungsi: Navigasi sidebar admin, header profil, notifikasi SweetAlert2, & impor Lucide JS --}}
{{-- ========================================================================================= --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'The Bread House') }} - Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|playfair-display:700,800&display=swap"
        rel="stylesheet" />

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .font-heading {
            font-family: 'Playfair Display', serif;
        }

        .font-sans {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-white text-[#472c1b] font-sans antialiased flex min-h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-[#f9f5f0] flex flex-col fixed h-full border-r border-[#ece3d4]">
        <div class="p-6">
            <h1 class="font-heading text-2xl font-bold text-[#693e1b]">The Bread House</h1>
        </div>

        <div class="px-6 mb-6">
            <div class="flex items-center bg-[#f0e8dc] p-3 rounded-xl">
                <img src="https://ui-avatars.com/api/?name=Admin+Bakery&background=693e1b&color=fff" alt="Admin"
                    class="w-10 h-10 rounded-full mr-3">
                <div>
                    <div class="text-sm font-bold text-[#472c1b]">Admin Bakery</div>
                    <div class="text-[11px] font-medium text-[#8c7a6b]">Pemilik Toko</div>
                </div>
            </div>
        </div>

        <nav class="flex-1 px-4 space-y-2">
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center px-4 py-3 {{ request()->routeIs('admin.dashboard') ? 'bg-[#fdf0dc] text-[#693e1b]' : 'text-[#7a6a5f] hover:bg-[#f0e8dc]' }} rounded-xl font-medium text-sm transition-colors">
                <i data-lucide="layout-dashboard" class="w-5 h-5 mr-3"></i>
                Dasbor
            </a>
            <a href="{{ route('admin.stok') }}"
                class="flex items-center px-4 py-3 {{ request()->routeIs('admin.stok') ? 'bg-[#fdf0dc] text-[#693e1b]' : 'text-[#7a6a5f] hover:bg-[#f0e8dc]' }} rounded-xl font-medium text-sm transition-colors">
                <i data-lucide="package" class="w-5 h-5 mr-3"></i>
                Kelola Stok
            </a>
            <a href="{{ route('admin.menu') }}"
                class="flex items-center px-4 py-3 {{ request()->routeIs('admin.menu') ? 'bg-[#fdf0dc] text-[#693e1b]' : 'text-[#7a6a5f] hover:bg-[#f0e8dc]' }} rounded-xl font-medium text-sm transition-colors">
                <i data-lucide="croissant" class="w-5 h-5 mr-3"></i>
                Menu Roti
            </a>
            <a href="{{ route('admin.kategori') }}"
                class="flex items-center px-4 py-3 {{ request()->routeIs('admin.kategori') ? 'bg-[#fdf0dc] text-[#693e1b]' : 'text-[#7a6a5f] hover:bg-[#f0e8dc]' }} rounded-xl font-medium text-sm transition-colors">
                <i data-lucide="tags" class="w-5 h-5 mr-3"></i>
                Kategori Menu
            </a>
            <a href="{{ route('admin.laporan') }}"
                class="flex items-center px-4 py-3 {{ request()->routeIs('admin.laporan') ? 'bg-[#fdf0dc] text-[#693e1b]' : 'text-[#7a6a5f] hover:bg-[#f0e8dc]' }} rounded-xl font-medium text-sm transition-colors">
                <i data-lucide="bar-chart-2" class="w-5 h-5 mr-3"></i>
                Laporan Penjualan
            </a>
            <a href="{{ route('admin.akun') }}"
                class="flex items-center px-4 py-3 {{ request()->routeIs('admin.akun') ? 'bg-[#fdf0dc] text-[#693e1b]' : 'text-[#7a6a5f] hover:bg-[#f0e8dc]' }} rounded-xl font-medium text-sm transition-colors">
                <i data-lucide="users" class="w-5 h-5 mr-3"></i>
                Kelola Akun
            </a>
            <a href="{{ route('admin.pengaturan') }}"
                class="flex items-center px-4 py-3 {{ request()->routeIs('admin.pengaturan') ? 'bg-[#fdf0dc] text-[#693e1b]' : 'text-[#7a6a5f] hover:bg-[#f0e8dc]' }} rounded-xl font-medium text-sm transition-colors">
                <i data-lucide="settings" class="w-5 h-5 mr-3"></i>
                Pengaturan
            </a>
            <a href="{{ route('admin.store-profile') }}"
                class="flex items-center px-4 py-3 {{ request()->routeIs('admin.store-profile') ? 'bg-[#fdf0dc] text-[#693e1b]' : 'text-[#7a6a5f] hover:bg-[#f0e8dc]' }} rounded-xl font-medium text-sm transition-colors">
                <i data-lucide="store" class="w-5 h-5 mr-3"></i>
                Profil Toko
            </a>
        </nav>

        <div class="p-4 border-t border-[#ece3d4]">
            <form method="POST" action="/logout">
                @csrf
                <button type="submit"
                    class="flex items-center px-4 py-2 text-[#7a6a5f] hover:text-[#c94040] w-full text-sm font-medium transition-colors rounded-xl hover:bg-[#fadada]">
                    <i data-lucide="log-out" class="w-5 h-5 mr-3"></i>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 ml-64 p-10">
        @yield('content')
    </main>

    <!-- Initialize Lucide Icons -->
    <script>
        lucide.createIcons();
    </script>

    <!-- Global SweetAlert Flash Messages -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#693e1b',
                    confirmButtonText: 'Tutup',
                    customClass: {
                        popup: 'rounded-3xl'
                    }
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#c94040',
                    confirmButtonText: 'Tutup',
                    customClass: {
                        popup: 'rounded-3xl'
                    }
                });
            @endif
        });
    </script>
</body>

</html>