{{-- ========================================================================================= --}}
{{-- [FITUR KASIR] RIWAYAT TRANSAKSI KASIR --}}
{{-- Fungsi: Menampilkan daftar riwayat pesanan selesai/dibatalkan & cetak ulang struk --}}
{{-- ========================================================================================= --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Riwayat Transaksi Kasir - The Bread House</title>
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
                    class="text-gray-500 hover:bg-[#fdf5eb] hover:text-[#6b3e1c] px-3 lg:px-4 py-3 rounded-xl flex items-center justify-center lg:justify-start gap-3 font-semibold text-sm transition-colors group">
                    <i data-lucide="layout-dashboard" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                    <span class="hidden lg:inline">Dasbor Utama</span>
                </a>
                <a href="{{ route('kasir.orders') }}"
                    class="text-gray-500 hover:bg-[#fdf5eb] hover:text-[#6b3e1c] px-3 lg:px-4 py-3 rounded-xl flex items-center justify-center lg:justify-start gap-3 font-semibold text-sm transition-colors group">
                    <i data-lucide="clipboard-list" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                    <span class="hidden lg:inline">Pesanan Masuk</span>
                </a>
                <a href="{{ route('kasir.history') }}"
                    class="bg-[#fdf5eb] text-[#6b3e1c] shadow-inner px-3 lg:px-4 py-3 rounded-xl flex items-center justify-center lg:justify-start gap-3 font-semibold text-sm transition-colors group">
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
    <main class="flex-1 overflow-y-auto bg-gray-50/50 p-6 lg:p-10 relative">
        <!-- Abstract Background Decoration -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-gradient-to-br from-[#b37a54]/10 to-transparent rounded-bl-full pointer-events-none -z-10"></div>
        <div class="absolute bottom-0 left-0 w-72 h-72 bg-gradient-to-tr from-[#6b3e1c]/5 to-transparent rounded-tr-full pointer-events-none -z-10"></div>

        <!-- Header -->
        <div class="mb-10 flex flex-col md:flex-row justify-between items-start md:items-end gap-4 relative z-10">
            <div>
                <h2 class="font-heading text-4xl lg:text-[2.75rem] font-bold text-[#332115] mb-2 tracking-tight leading-none drop-shadow-sm">Riwayat Transaksi</h2>
                <p class="text-gray-500 text-[15px] max-w-md">Daftar transaksi harian dan historis toko Anda.</p>
            </div>
            <div class="bg-white/80 backdrop-blur-md px-5 py-3 rounded-2xl flex items-center gap-3 text-sm font-bold text-[#6b3e1c] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-white">
                <div class="bg-[#f5e3d7] p-2 rounded-xl">
                    <i data-lucide="calendar-clock" class="w-5 h-5"></i>
                </div>
                <div class="flex flex-col">
                    <span class="text-[10px] uppercase tracking-wider text-gray-500">Waktu Saat Ini</span>
                    <span id="realtime-clock" class="tracking-wide">{{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}</span>
                </div>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10 relative z-10">
            <!-- Card 1 -->
            <div class="bg-gradient-to-br from-[#6b3e1c] to-[#8c4a1d] rounded-[2rem] p-6 lg:p-8 shadow-xl shadow-[#8c4a1d]/20 relative overflow-hidden group hover:shadow-2xl hover:shadow-[#8c4a1d]/30 transition-all duration-300 transform hover:-translate-y-1">
                <div class="absolute right-0 top-0 w-32 h-32 bg-white/10 rounded-full blur-2xl group-hover:bg-white/20 transition-colors duration-500"></div>
                <i data-lucide="wallet" class="absolute -right-4 -bottom-4 w-24 h-24 text-white/5 -rotate-12 group-hover:scale-110 transition-transform duration-500"></i>
                
                <div class="flex justify-between items-start mb-6 relative z-10">
                    <div class="w-12 h-12 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center text-white border border-white/20 group-hover:bg-white/20 transition-all duration-300">
                        <i data-lucide="banknote" class="w-5 h-5"></i>
                    </div>
                </div>
                <div class="relative z-10">
                    <p class="text-white/80 text-xs font-semibold tracking-wider mb-1 uppercase">Pendapatan Hari Ini</p>
                    <h3 class="font-heading text-3xl font-bold text-white drop-shadow-md">
                        Rp {{ number_format($revenueToday, 0, ',', '.') }}
                    </h3>
                </div>
            </div>
            
            <!-- Card 2 -->
            <div class="bg-white/70 backdrop-blur-xl rounded-[2rem] p-6 lg:p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-white relative overflow-hidden group hover:shadow-[0_8px_40px_rgb(0,0,0,0.08)] transition-all duration-300">
                <div class="absolute -right-6 -top-6 w-24 h-24 bg-gray-50 rounded-full group-hover:scale-150 transition-transform duration-700 ease-in-out -z-10"></div>
                <div class="flex justify-between items-start mb-6 relative z-10">
                    <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-[#8c4a1d] shadow-sm border border-gray-100 group-hover:scale-110 transition-transform duration-300">
                        <i data-lucide="receipt" class="w-5 h-5"></i>
                    </div>
                </div>
                <div class="relative z-10">
                    <p class="text-gray-500 text-xs font-semibold tracking-wider mb-1 uppercase">Total Transaksi</p>
                    <h3 class="font-heading text-4xl font-bold text-gray-800 tracking-tight group-hover:text-[#6b3e1c] transition-colors">{{ $totalTransactionsToday }}</h3>
                    <p class="text-gray-400 text-[10px] uppercase font-bold mt-1">Hari Ini</p>
                </div>
            </div>
            
            <!-- Card 3 -->
            <div class="bg-white/70 backdrop-blur-xl rounded-[2rem] p-6 lg:p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-white relative overflow-hidden group hover:shadow-[0_8px_40px_rgb(0,0,0,0.08)] transition-all duration-300">
                <div class="absolute -right-6 -top-6 w-24 h-24 bg-gray-50 rounded-full group-hover:scale-150 transition-transform duration-700 ease-in-out -z-10"></div>
                <div class="flex justify-between items-start mb-6 relative z-10">
                    <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-[#8c4a1d] shadow-sm border border-gray-100 group-hover:scale-110 transition-transform duration-300">
                        <i data-lucide="bar-chart-2" class="w-5 h-5"></i>
                    </div>
                </div>
                <div class="relative z-10">
                    <p class="text-gray-500 text-xs font-semibold tracking-wider mb-1 uppercase">Rata-rata Transaksi</p>
                    <h3 class="font-heading text-3xl font-bold text-gray-800 tracking-tight group-hover:text-[#6b3e1c] transition-colors">
                        Rp {{ number_format($averageTransactionToday, 0, ',', '.') }}
                    </h3>
                    <p class="text-gray-400 text-[10px] uppercase font-bold mt-1">Per Pesanan</p>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="bg-white/80 backdrop-blur-xl rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-white overflow-hidden relative z-10">
            <!-- Table Header Area -->
            <div class="p-6 md:p-8 border-b border-gray-100 flex flex-col md:flex-row items-center justify-between gap-4 bg-white">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-[#fdf5eb] rounded-xl flex items-center justify-center text-[#8c4a1d]">
                        <i data-lucide="scroll-text" class="w-5 h-5"></i>
                    </div>
                    <h3 class="font-bold text-[#332115] text-lg">Daftar Riwayat</h3>
                </div>
                
                <div class="flex items-center gap-3 w-full md:w-auto">
                    <div class="relative flex-1 md:w-72 group">
                        <i data-lucide="search" class="w-5 h-5 text-gray-400 absolute left-4 top-1/2 -translate-y-1/2 group-focus-within:text-[#6b3e1c] transition-colors"></i>
                        <input type="text" placeholder="Cari ID Pesanan..." class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-100 rounded-2xl text-sm font-medium focus:outline-none focus:ring-2 focus:ring-[#6b3e1c]/20 focus:border-[#6b3e1c] focus:bg-white transition-all shadow-sm">
                    </div>
                    <button class="w-12 h-12 flex-shrink-0 bg-gray-50 hover:bg-gray-100 border border-gray-100 rounded-2xl flex items-center justify-center text-gray-600 transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-[#6b3e1c]/20">
                        <i data-lucide="sliders-horizontal" class="w-5 h-5"></i>
                    </button>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left whitespace-nowrap">
                    <thead class="text-xs text-gray-400 bg-gray-50/50 uppercase tracking-widest font-bold">
                        <tr>
                            <th class="px-8 py-5 rounded-tl-2xl">ID Pesanan</th>
                            <th class="px-6 py-5">Waktu</th>
                            <th class="px-6 py-5">Rincian Item</th>
                            <th class="px-6 py-5 text-center">Total Tagihan</th>
                            <th class="px-6 py-5 text-center">Status & Metode</th>
                            <th class="px-8 py-5 text-right rounded-tr-2xl">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($orders as $order)
                            <tr class="hover:bg-blue-50/30 transition-colors group">
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-4">
                                        <div>
                                            <div class="font-bold text-[#6b3e1c] text-sm group-hover:text-[#8c4a1d] transition-colors">
                                                #{{ $order->order_number }}
                                            </div>
                                            <div class="text-[11px] font-bold text-gray-400 flex items-center gap-1 mt-0.5 uppercase tracking-wide">
                                                <i data-lucide="user" class="w-3 h-3"></i>
                                                {{ $order->recipient_name ?? $order->user->name ?? 'Kasir / Guest' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex flex-col">
                                        <span class="text-gray-800 font-bold">{{ $order->updated_at->format('H:i') }}</span>
                                        <span class="text-[10px] text-gray-400 font-semibold">{{ $order->updated_at->format('d M Y') }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="max-w-[200px] truncate text-gray-600 font-medium text-xs bg-gray-50 px-3 py-1.5 rounded-lg border border-gray-100 group-hover:bg-white transition-colors" title="@foreach($order->orderItems as $item){{ $item->quantity }}x {{ $item->product->name ?? 'Item' }}, @endforeach">
                                        @php
                                            $items = $order->orderItems->map(function ($item) {
                                                return $item->quantity . 'x ' . ($item->product->name ?? 'Item');
                                            })->implode(', ');
                                        @endphp
                                        {{ Str::limit($items, 40) }}
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <div class="font-heading font-bold text-gray-900 text-base">
                                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex flex-col items-center gap-1.5">
                                        @if($order->status === 'dibatalkan')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded bg-[#fadada] text-[#c94040] text-[10px] font-bold uppercase tracking-wider shadow-sm border border-[#f5c6c6]">
                                                <i data-lucide="x-circle" class="w-3 h-3"></i> Dibatalkan
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded bg-[#e6f4ea] text-[#1e7e34] text-[10px] font-bold uppercase tracking-wider shadow-sm border border-[#c3e6cb]">
                                                <i data-lucide="check-circle" class="w-3 h-3"></i> Selesai
                                            </span>
                                        @endif
                                        
                                        <span class="text-[10px] text-gray-500 font-bold uppercase tracking-widest flex items-center gap-1">
                                            <i data-lucide="{{ $order->payment_method == 'qris' ? 'qr-code' : 'banknote' }}" class="w-3 h-3"></i> 
                                            {{ $order->payment_method }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <a href="{{ route('kasir.orders.print', $order->id) }}" target="_blank"
                                        class="inline-flex items-center justify-center w-10 h-10 text-[#8c4a1d] bg-[#fdf5eb] hover:bg-[#6b3e1c] hover:text-white rounded-xl transition-all duration-300 shadow-sm hover:shadow-md transform hover:-translate-y-0.5 group/print"
                                        title="Cetak Struk">
                                        <i data-lucide="printer" class="w-4 h-4 group-hover/print:scale-110 transition-transform"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-8 py-16">
                                    <div class="flex flex-col items-center justify-center text-center">
                                        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4 border border-gray-100">
                                            <i data-lucide="receipt" class="w-10 h-10 text-gray-300"></i>
                                        </div>
                                        <h4 class="font-bold text-gray-800 text-lg mb-1">Belum ada transaksi</h4>
                                        <p class="text-gray-500 text-sm max-w-xs">Data riwayat transaksi akan muncul di sini setelah ada pesanan yang selesai atau dibatalkan.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Custom Pagination -->
            <div class="px-6 md:px-8 py-5 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4 bg-white/50 rounded-b-[2rem]">
                <div class="text-[11px] font-bold text-gray-400 uppercase tracking-widest bg-gray-50 px-4 py-2 rounded-xl border border-gray-100">
                    Halaman <span class="text-[#8c4a1d]">{{ $orders->currentPage() }}</span> dari {{ $orders->lastPage() }}
                    <span class="mx-2 text-gray-300">|</span>
                    Total <span class="text-gray-600">{{ $orders->total() }}</span> Transaksi
                </div>

                <div class="flex items-center gap-2">
                    @if ($orders->onFirstPage())
                        <span class="w-10 h-10 rounded-xl border border-gray-100 text-gray-300 bg-gray-50/50 flex items-center justify-center cursor-not-allowed">
                            <i data-lucide="chevron-left" class="w-5 h-5"></i>
                        </span>
                    @else
                        <a href="{{ $orders->previousPageUrl() }}" class="w-10 h-10 rounded-xl border border-[#e8cdb0] text-[#8c4a1d] bg-white hover:bg-[#8c4a1d] hover:text-white transition-all duration-300 shadow-sm hover:shadow-md flex items-center justify-center hover:-translate-x-0.5">
                            <i data-lucide="chevron-left" class="w-5 h-5"></i>
                        </a>
                    @endif

                    @if ($orders->hasMorePages())
                        <a href="{{ $orders->nextPageUrl() }}" class="w-10 h-10 rounded-xl border border-[#e8cdb0] text-[#8c4a1d] bg-white hover:bg-[#8c4a1d] hover:text-white transition-all duration-300 shadow-sm hover:shadow-md flex items-center justify-center hover:translate-x-0.5">
                            <i data-lucide="chevron-right" class="w-5 h-5"></i>
                        </a>
                    @else
                        <span class="w-10 h-10 rounded-xl border border-gray-100 text-gray-300 bg-gray-50/50 flex items-center justify-center cursor-not-allowed">
                            <i data-lucide="chevron-right" class="w-5 h-5"></i>
                        </span>
                    @endif
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