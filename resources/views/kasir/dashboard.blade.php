{{-- ========================================================================================= --}}
{{-- [FITUR KASIR] DASHBOARD RINGKASAN KASIR --}}
{{-- Fungsi: Menampilkan total omzet hari ini, transaksi kasir, & statistik roti terlaris --}}
{{-- ========================================================================================= --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dasbor Kasir - The Bread House</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #faf9f6;
        }

        .font-heading {
            font-family: 'Playfair Display', serif;
        }

        .sidebar {
            background-color: #f1eee8;
        }

        .text-brand-brown {
            color: #6e3a15;
        }

        .bg-brand-brown {
            background-color: #6e3a15;
        }

        .bg-brand-light {
            background-color: #fcecd7;
        }

        .border-brand-brown {
            border-color: #6e3a15;
        }

        .text-danger {
            color: #c94040;
        }

        .bg-danger-light {
            background-color: #fadada;
        }

        .text-success {
            color: #687162;
        }

        .bg-success-light {
            background-color: #e6e5df;
        }
    </style>
</head>

<body class="flex h-screen overflow-hidden text-gray-800">

    <!-- Sidebar -->
    <aside
        class="w-24 lg:w-64 flex-shrink-0 bg-white border-r border-gray-100 flex flex-col justify-between z-20 shadow-[4px_0_24px_rgba(0,0,0,0.02)] transition-all duration-300 relative">
        <!-- Decoration -->
        <div
            class="absolute top-0 left-0 w-full h-32 bg-gradient-to-b from-[#fdf5eb] to-transparent opacity-50 pointer-events-none">
        </div>

        <div>
            <div class="p-6 flex items-center gap-4 justify-center lg:justify-start relative z-10">
                <div
                    class="w-12 h-12 bg-gradient-to-br from-[#6b3e1c] to-[#b37a54] rounded-2xl flex items-center justify-center text-white shrink-0 shadow-lg shadow-[#6b3e1c]/20 transform rotate-3 transition-transform hover:rotate-0">
                    <i data-lucide="store" class="w-6 h-6"></i>
                </div>
                <div class="hidden lg:block">
                    <h1 class="font-heading text-2xl font-bold text-[#332115] leading-tight tracking-tight">The Bread House
                    </h1>
                    <p class="text-[10px] uppercase tracking-widest text-[#b37a54] font-bold mt-0.5">Terminal Kasir</p>
                </div>
            </div>

            <div class="px-4 lg:px-6 mb-8 mt-2">
                <a href="{{ route('kasir.pos') }}"
                    class="w-full bg-[#6b3e1c] hover:bg-[#522e15] text-white py-3 lg:py-3.5 px-0 lg:px-4 rounded-xl flex items-center justify-center gap-2.5 font-bold text-sm transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5 group">
                    <i data-lucide="plus-circle"
                        class="w-5 h-5 group-hover:rotate-90 transition-transform duration-300"></i>
                    <span class="hidden lg:inline">Pesanan Cepat</span>
                </a>
            </div>

            <nav class="px-3 lg:px-4 space-y-1.5 relative z-10">
                <a href="{{ route('kasir.dashboard') }}"
                    class="bg-[#fdf5eb] text-[#6b3e1c] shadow-inner px-3 lg:px-4 py-3 rounded-xl flex items-center justify-center lg:justify-start gap-3 font-semibold text-sm transition-colors group">
                    <i data-lucide="layout-dashboard" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                    <span class="hidden lg:inline">Dasbor Utama</span>
                </a>
                <a href="{{ route('kasir.orders') }}"
                    class="text-gray-500 hover:bg-[#fdf5eb] hover:text-[#6b3e1c] px-3 lg:px-4 py-3 rounded-xl flex items-center justify-center lg:justify-start gap-3 font-semibold text-sm transition-colors group">
                    <i data-lucide="clipboard-list" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                    <span class="hidden lg:inline">Pesanan Masuk</span>
                </a>
                <a href="{{ route('kasir.history') }}"
                    class="text-gray-500 hover:bg-[#fdf5eb] hover:text-[#6b3e1c] px-3 lg:px-4 py-3 rounded-xl flex items-center justify-center lg:justify-start gap-3 font-semibold text-sm transition-colors group">
                    <i data-lucide="history" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                    <span class="hidden lg:inline">Riwayat Transaksi</span>
                </a>
            </nav>
        </div>

        <div class="p-3 lg:p-4 mb-2">
            <div class="bg-gray-50 rounded-2xl p-2 lg:p-3">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full text-red-500 hover:bg-white hover:shadow-sm px-2 py-2.5 rounded-xl flex items-center justify-center lg:justify-start gap-3 font-bold text-sm transition-all group">
                        <div class="bg-red-100 p-1.5 rounded-lg group-hover:bg-red-50 transition-colors">
                            <i data-lucide="log-out" class="w-4 h-4"></i>
                        </div>
                        <span class="hidden lg:inline">Keluar Sesi</span>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto p-8 lg:p-10 bg-[#faf9f6]">
        <!-- Header -->
        <div class="mb-8 flex justify-between items-end">
            <div>
                <h2 class="font-heading text-[2.5rem] font-bold text-[#1a1a1a] mb-1 tracking-tight leading-none">Selamat
                    Datang, Kasir!</h2>
                <p class="text-gray-500 text-[15px]">Ringkasan aktivitas toko hari ini.</p>
            </div>
            <div
                class="bg-[#f5f1eb] px-4 py-2.5 rounded-lg flex items-center gap-2.5 text-sm font-bold text-gray-700 shadow-sm">
                <i data-lucide="calendar" class="w-4 h-4 text-[#7a3b00]"></i>
                <span id="realtime-clock">{{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}</span>
            </div>
        </div>

        <!-- KPI Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <!-- Pendapatan -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex flex-col justify-between">
                <div
                    class="w-11 h-11 bg-green-50 rounded-xl flex items-center justify-center text-green-600 mb-6 shadow-sm">
                    <i data-lucide="trending-up" class="w-5 h-5"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-xs font-bold tracking-wider mb-1 uppercase">Pendapatan Hari Ini</p>
                    <h3 class="font-heading text-2xl font-bold text-gray-800">Rp
                        {{ number_format($revenueToday, 0, ',', '.') }}
                    </h3>
                </div>
            </div>
            <!-- Transaksi -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex flex-col justify-between">
                <div
                    class="w-11 h-11 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600 mb-6 shadow-sm">
                    <i data-lucide="receipt" class="w-5 h-5"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-xs font-bold tracking-wider mb-1 uppercase">Total Transaksi</p>
                    <h3 class="font-heading text-3xl font-bold text-gray-800">{{ $totalTransactions }}</h3>
                </div>
            </div>
            <!-- Pelanggan Baru -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex flex-col justify-between">
                <div
                    class="w-11 h-11 bg-purple-50 rounded-xl flex items-center justify-center text-purple-600 mb-6 shadow-sm">
                    <i data-lucide="users" class="w-5 h-5"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-xs font-bold tracking-wider mb-1 uppercase">Pelanggan Aktif</p>
                    <h3 class="font-heading text-3xl font-bold text-gray-800">{{ $activeCustomers }}</h3>
                </div>
            </div>
            <!-- Pesanan Pending -->
            <div class="bg-[#8c4a1d] rounded-2xl p-6 shadow-md flex flex-col justify-between relative overflow-hidden">
                <div
                    class="w-11 h-11 bg-white/20 rounded-xl flex items-center justify-center text-white mb-6 shadow-sm">
                    <i data-lucide="clock-4" class="w-5 h-5"></i>
                </div>
                <div>
                    <p class="text-white/80 text-xs font-bold tracking-wider mb-1 uppercase">Perlu Diproses</p>
                    <h3 class="font-heading text-3xl font-bold text-white">{{ $pendingOrders }}</h3>
                </div>
            </div>
        </div>

        <div class="mb-8">
            <!-- Popular Items -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="font-heading text-lg font-bold text-gray-800">Menu Terpopuler Hari Ini</h3>
                    <div class="text-sm font-medium text-gray-500">Berdasarkan total porsi terjual</div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($popularItems as $index => $item)
                            <div
                                class="flex items-center gap-4 bg-[#faf9f6] p-4 rounded-xl border border-gray-100 hover:border-[#e8cdb0] transition-colors">
                                <div
                                    class="w-12 h-12 bg-white rounded-lg flex items-center justify-center text-[#7a3b00] font-bold text-lg shadow-sm border border-gray-50">
                                    #{{ $index + 1 }}</div>
                                <div class="flex-1">
                                    <h4 class="font-bold text-gray-800 line-clamp-1">{{ $item->product_name }}</h4>
                                    <p class="text-sm text-gray-500 mt-0.5"><span
                                            class="font-bold text-[#6e3a15]">{{ $item->total_sold }}</span> porsi terjual
                                    </p>
                                </div>
                                <div class="font-bold text-gray-900 bg-white px-3 py-1.5 rounded-lg shadow-sm text-sm">
                                    Rp {{ number_format($item->price, 0, ',', '.') }}
                                </div>
                            </div>
                        @empty
                            <div
                                class="col-span-full text-center text-gray-500 py-8 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                                <i data-lucide="bar-chart" class="w-8 h-8 mx-auto text-gray-400 mb-2"></i>
                                <p>Belum ada data penjualan hari ini.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        lucide.createIcons();
        function updateClock() {
            const now = new Date();
            const options = { day: '2-digit', month: 'long', year: 'numeric' };
            const dateStr = now.toLocaleDateString('id-ID', options);
            const timeStr = now.getHours().toString().padStart(2, '0') + ':' + now.getMinutes().toString().padStart(2, '0') + ':' + now.getSeconds().toString().padStart(2, '0');
            const clockEl = document.getElementById('realtime-clock');
            if (clockEl) {
                clockEl.textContent = dateStr + ' • ' + timeStr;
            }
        }
        setInterval(updateClock, 1000);
        updateClock();
    </script>
</body>

</html>