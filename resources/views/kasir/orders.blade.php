{{-- ========================================================================================= --}}
{{-- [FITUR KASIR] DAFTAR PESANAN ONLINE MASUK --}}
{{-- Fungsi: Konfirmasi pembayaran pesanan pembeli & ubah status pesanan menjadi selesai --}}
{{-- ========================================================================================= --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pesanan Kasir - The Bread House</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                    class="text-gray-500 hover:bg-[#fdf5eb] hover:text-[#6b3e1c] px-3 lg:px-4 py-3 rounded-xl flex items-center justify-center lg:justify-start gap-3 font-semibold text-sm transition-colors group">
                    <i data-lucide="layout-dashboard" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                    <span class="hidden lg:inline">Dasbor Utama</span>
                </a>
                <a href="{{ route('kasir.orders') }}"
                    class="bg-[#fdf5eb] text-[#6b3e1c] shadow-inner px-3 lg:px-4 py-3 rounded-xl flex items-center justify-center lg:justify-start gap-3 font-semibold text-sm transition-colors group">
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
    <main class="flex-1 overflow-y-auto bg-gray-50/50 p-6 lg:p-10 relative">
        <!-- Abstract Background Decoration -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-gradient-to-br from-[#b37a54]/10 to-transparent rounded-bl-full pointer-events-none -z-10"></div>
        <div class="absolute bottom-0 left-0 w-72 h-72 bg-gradient-to-tr from-[#6b3e1c]/5 to-transparent rounded-tr-full pointer-events-none -z-10"></div>

        <!-- Header -->
        <div class="mb-10 flex flex-col md:flex-row justify-between items-start md:items-end gap-4 relative z-10">
            <div>
                <h2 class="font-heading text-4xl lg:text-[2.75rem] font-bold text-[#332115] mb-2 tracking-tight leading-none drop-shadow-sm">Daftar Pesanan</h2>
                <p class="text-gray-500 text-[15px] max-w-md">Kelola dan proses pesanan pelanggan hari ini dengan cepat dan efisien.</p>
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
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10 relative z-10">
            <!-- Card 1 -->
            <div class="bg-white/70 backdrop-blur-xl rounded-[2rem] p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-white relative overflow-hidden group hover:shadow-[0_8px_40px_rgb(0,0,0,0.08)] transition-all duration-300">
                <div class="absolute -right-6 -top-6 w-32 h-32 bg-gray-50 rounded-full group-hover:scale-150 transition-transform duration-700 ease-in-out -z-10"></div>
                
                <div class="flex justify-between items-center mb-6">
                    <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center text-gray-600 shadow-sm border border-gray-100 group-hover:scale-110 transition-transform duration-300">
                        <i data-lucide="inbox" class="w-6 h-6"></i>
                    </div>
                </div>
                <div>
                    <h3 class="font-heading text-5xl font-bold text-gray-800 tracking-tight group-hover:text-[#6b3e1c] transition-colors">{{ $orders->count() }}</h3>
                    <p class="text-gray-500 text-sm font-semibold tracking-wider mt-2">TOTAL ANTREAN PESANAN</p>
                </div>
            </div>
            
            <!-- Card 2 (Highlighted) -->
            <div class="bg-gradient-to-br from-[#6b3e1c] to-[#8c4a1d] rounded-[2rem] p-8 shadow-xl shadow-[#8c4a1d]/20 relative overflow-hidden group hover:shadow-2xl hover:shadow-[#8c4a1d]/30 transition-all duration-300 transform hover:-translate-y-1">
                <!-- Decorative Elements -->
                <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-2xl group-hover:bg-white/20 transition-colors duration-500"></div>
                <div class="absolute right-10 bottom-10 w-20 h-20 bg-black/10 rounded-full blur-xl"></div>
                <i data-lucide="zap" class="absolute -right-4 -bottom-4 w-32 h-32 text-white/5 -rotate-12 group-hover:scale-110 transition-transform duration-500"></i>
                
                <div class="flex justify-between items-start mb-6 relative z-10">
                    <div class="w-14 h-14 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center text-white border border-white/20 group-hover:scale-110 group-hover:bg-white/20 transition-all duration-300">
                        <i data-lucide="clock" class="w-6 h-6"></i>
                    </div>
                    <span class="bg-[#cc2929]/90 backdrop-blur-sm text-white text-[11px] font-bold px-3 py-1.5 rounded-full shadow-lg tracking-wide border border-red-400/30 animate-pulse">
                        Menunggu Tindakan
                    </span>
                </div>
                <div class="relative z-10">
                    <h3 class="font-heading text-5xl font-bold text-white drop-shadow-md">
                        {{ $orders->where('status', 'menunggu_pembayaran')->count() }}
                    </h3>
                    <p class="text-white/80 text-sm font-semibold tracking-wider mt-2">BELUM DIBAYAR</p>
                </div>
            </div>
        </div>

        <!-- Orders Section -->
        <div class="bg-white/80 backdrop-blur-xl rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-white overflow-hidden relative z-10">
            <!-- Table Header Area -->
            <div class="p-6 md:p-8 border-b border-gray-100 flex flex-col md:flex-row items-center justify-between gap-4 bg-white">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-[#fdf5eb] rounded-xl flex items-center justify-center text-[#8c4a1d]">
                        <i data-lucide="list-ordered" class="w-5 h-5"></i>
                    </div>
                    <h3 class="font-bold text-[#332115] text-lg">Daftar Antrean</h3>
                </div>
                
                <div class="flex items-center gap-3 w-full md:w-auto">
                    <div class="relative flex-1 md:w-72 group">
                        <i data-lucide="search" class="w-5 h-5 text-gray-400 absolute left-4 top-1/2 -translate-y-1/2 group-focus-within:text-[#6b3e1c] transition-colors"></i>
                        <input type="text" placeholder="Cari pesanan..." class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-100 rounded-2xl text-sm font-medium focus:outline-none focus:ring-2 focus:ring-[#6b3e1c]/20 focus:border-[#6b3e1c] focus:bg-white transition-all shadow-sm">
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
                            <th class="px-8 py-5 rounded-tl-2xl">Pesanan</th>
                            <th class="px-6 py-5">Tipe & Meja</th>
                            <th class="px-6 py-5 text-center">Total Tagihan</th>
                            <th class="px-6 py-5 text-center">Status</th>
                            <th class="px-8 py-5 text-right rounded-tr-2xl">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($orders as $order)
                            <tr class="hover:bg-blue-50/30 transition-colors group">
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-[#f3dcb8] to-[#fcecd7] text-[#8c4a1d] flex flex-col items-center justify-center font-bold text-lg shrink-0 shadow-sm border border-white group-hover:scale-105 transition-transform">
                                            {{ strtoupper(substr($order->recipient_name ?? $order->user->name ?? 'G', 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-gray-900 text-base group-hover:text-[#6b3e1c] transition-colors">
                                                {{ $order->recipient_name ?? $order->user->name ?? 'Guest' }}
                                            </div>
                                            <div class="text-xs text-gray-400 font-medium mt-0.5 tracking-wide">
                                                #{{ $order->order_number }}
                                            </div>
                                            
                                            <div class="flex items-center gap-3 mt-1.5">
                                                @if($order->shipping_notes)
                                                    <div class="text-[11px] font-bold text-orange-600/80 bg-orange-50 px-2 py-0.5 rounded-md flex items-center gap-1 cursor-pointer hover:bg-orange-100 hover:text-orange-700 transition-colors" onclick="showNoteModal('{{ addslashes($order->shipping_notes) }}')">
                                                        <i data-lucide="message-square-text" class="w-3 h-3"></i>
                                                        <span>Catatan</span>
                                                    </div>
                                                @endif
                                                @if($order->email)
                                                    <div class="text-[11px] font-bold text-blue-600/80 bg-blue-50 px-2 py-0.5 rounded-md flex items-center gap-1 cursor-pointer hover:bg-blue-100 hover:text-blue-700 transition-colors" onclick="navigator.clipboard.writeText('{{ $order->email }}'); showToast('Email disalin: {{ $order->email }}');" title="Klik untuk Salin">
                                                        <i data-lucide="at-sign" class="w-3 h-3"></i>
                                                        <span class="max-w-[120px] truncate">{{ $order->email }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    @if($order->order_type === 'takeaway')
                                        <div class="flex flex-col items-start gap-1">
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-amber-50 border border-amber-100/50 text-amber-700 text-[11px] font-bold">
                                                <i data-lucide="shopping-bag" class="w-3.5 h-3.5"></i> Takeaway
                                            </span>
                                        </div>
                                    @else
                                        <div class="flex flex-col items-start gap-1">
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-50 border border-emerald-100/50 text-emerald-700 text-[11px] font-bold">
                                                <i data-lucide="utensils-crossed" class="w-3.5 h-3.5"></i> Dine-in
                                            </span>
                                            @if($order->table_number)
                                                <span class="text-xs font-bold text-gray-500 pl-2 mt-0.5">Meja {{ $order->table_number }}</span>
                                            @endif
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <div class="font-heading font-bold text-gray-900 text-lg">
                                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                    </div>
                                    <div class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mt-0.5">
                                        {{ $order->payment_method === 'qris' ? 'QRIS' : 'Tunai' }}
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    @if($order->status === 'menunggu_pembayaran')
                                        <span class="inline-flex justify-center items-center px-4 py-1.5 rounded-full bg-red-50 text-red-600 text-[11px] font-bold border border-red-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500 mr-2 animate-pulse"></span>
                                            Belum Bayar
                                        </span>
                                    @elseif($order->status === 'diproses')
                                        <span class="inline-flex justify-center items-center px-4 py-1.5 rounded-full bg-blue-50 text-blue-600 text-[11px] font-bold border border-blue-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-2 animate-pulse"></span>
                                            Diproses
                                        </span>
                                    @else
                                        <span class="inline-flex justify-center items-center px-4 py-1.5 rounded-full bg-gray-50 text-gray-600 text-[11px] font-bold border border-gray-200">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-8 py-5 text-right">
                                    @if($order->payment_method === 'qris' && $order->status === 'menunggu_pembayaran')
                                        <button disabled class="group/btn relative overflow-hidden bg-gray-200 text-gray-400 cursor-not-allowed px-5 py-2.5 rounded-xl text-xs font-bold shadow-sm flex items-center gap-2" title="Menunggu pembeli scan QRIS">
                                            <i data-lucide="loader-2" class="w-4 h-4 animate-spin"></i>
                                            <span class="relative z-10">Menunggu Scan</span>
                                        </button>
                                    @elseif(in_array($order->status, ['menunggu_pembayaran', 'diproses']))
                                        <form action="{{ route('kasir.orders.update-status', $order->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="selesai">
                                            <button type="submit" class="group/btn relative overflow-hidden bg-gradient-to-r from-[#6b3e1c] to-[#8c4a1d] text-white px-5 py-2.5 rounded-xl text-xs font-bold shadow-md hover:shadow-lg transition-all active:scale-95 flex items-center gap-2">
                                                <div class="absolute inset-0 bg-white/20 translate-y-full group-hover/btn:translate-y-0 transition-transform duration-300 ease-in-out"></div>
                                                <i data-lucide="check-circle-2" class="w-4 h-4 relative z-10 group-hover/btn:scale-110 transition-transform"></i>
                                                <span class="relative z-10">Selesaikan</span>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-8 py-16">
                                    <div class="flex flex-col items-center justify-center text-center">
                                        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                            <i data-lucide="clipboard-x" class="w-10 h-10 text-gray-300"></i>
                                        </div>
                                        <h4 class="font-bold text-gray-800 text-lg mb-1">Belum ada pesanan</h4>
                                        <p class="text-gray-500 text-sm max-w-xs">Pesanan online yang masuk akan otomatis muncul di sini.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($orders->count() > 0)
            <div class="px-8 py-5 border-t border-gray-100 bg-gray-50/30 flex items-center justify-between text-xs font-semibold text-gray-500">
                <span>Menampilkan {{ $orders->count() }} pesanan aktif</span>
                <span class="flex items-center gap-1"><i data-lucide="refresh-cw" class="w-3 h-3"></i> Auto-refresh aktif</span>
            </div>
            @endif
        </div>
    </main>

    <!-- Custom Modal for Notes -->
    <div id="noteModal"
        class="hidden fixed inset-0 z-50 items-center justify-center bg-[#332115]/40 backdrop-blur-md transition-opacity duration-300 opacity-0">
        <div id="noteModalContent"
            class="bg-white rounded-3xl shadow-[0_20px_50px_rgba(107,62,28,0.15)] w-full max-w-sm overflow-hidden transform scale-95 translate-y-8 opacity-0 transition-all duration-400 ease-[cubic-bezier(0.16,1,0.3,1)] border border-white/40">

            <!-- Header Section with Pattern -->
            <div class="bg-gradient-to-br from-[#6b3e1c] via-[#8c4a1d] to-[#9c5929] px-6 py-6 relative overflow-hidden">
                <!-- Decorative Quote Icon Background -->
                <i data-lucide="quote" class="absolute -bottom-4 -right-4 w-24 h-24 text-white/10 rotate-12"></i>

                <h3
                    class="font-heading text-xl font-bold text-white flex items-center justify-center gap-2.5 relative z-10 text-center tracking-wide">
                    <i data-lucide="message-square-quote" class="w-5 h-5 text-[#fcecd7]"></i> Pesan Pelanggan
                </h3>
            </div>

            <!-- Body Section -->
            <div class="px-8 py-10 bg-[#faf9f6] relative">
                <!-- Top gradient line for elegance -->
                <div
                    class="absolute top-0 left-1/2 -translate-x-1/2 w-16 h-[3px] bg-gradient-to-r from-transparent via-[#8c4a1d]/20 to-transparent rounded-full">
                </div>

                <p id="noteModalText"
                    class="text-[#5a483e] text-[15px] leading-relaxed italic text-center relative z-10 font-medium"></p>
            </div>

            <!-- Footer Section -->
            <div class="px-6 py-5 bg-white flex justify-center">
                <button onclick="closeNoteModal()"
                    class="w-full bg-[#fcf4ec] hover:bg-[#f5e3d7] text-[#6b3e1c] px-6 py-3.5 rounded-2xl text-[15px] font-bold transition-all duration-300 shadow-sm hover:shadow-md focus:outline-none active:scale-[0.98]">
                    Tutup Catatan
                </button>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toastNotification"
        class="fixed bottom-6 right-6 z-[100] transform translate-y-20 opacity-0 pointer-events-none transition-all duration-400 ease-[cubic-bezier(0.16,1,0.3,1)] flex items-center gap-3 bg-white px-5 py-3.5 rounded-2xl shadow-[0_15px_40px_rgba(107,62,28,0.2)] border border-gray-100">
        <div class="w-9 h-9 rounded-full bg-[#e6f4ea] text-[#1e7e34] flex items-center justify-center shrink-0">
            <i data-lucide="check" class="w-5 h-5"></i>
        </div>
        <div>
            <h4 class="text-sm font-bold text-gray-800 leading-tight">Berhasil Disalin</h4>
            <p id="toastMessage" class="text-xs text-gray-500 font-medium mt-0.5"></p>
        </div>
    </div>

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

        // Auto-refresh setiap 15 detik agar pesanan baru otomatis muncul
        let refreshInterval;
        const refreshTime = 15000;

        function startAutoRefresh() {
            refreshInterval = setInterval(() => {
                window.location.reload();
            }, refreshTime);
        }

        document.addEventListener('DOMContentLoaded', () => {
            startAutoRefresh();

            // Tahan refresh jika kasir sedang fokus mengetik di kotak pencarian
            const searchInput = document.querySelector('input[placeholder="Cari ID Pesanan atau Nama..."]');
            if (searchInput) {
                searchInput.addEventListener('focus', () => clearInterval(refreshInterval));
                searchInput.addEventListener('blur', () => startAutoRefresh());
            }
        });

        function showNoteModal(noteText) {
            document.getElementById('noteModalText').innerText = '"' + noteText + '"';
            const modal = document.getElementById('noteModal');
            const content = document.getElementById('noteModalContent');

            // Remove hidden
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            // Force browser reflow to enable transition
            void modal.offsetWidth;

            // Add animation classes (Fade In + Slide Up)
            modal.classList.remove('opacity-0');
            modal.classList.add('opacity-100');

            content.classList.remove('scale-95', 'translate-y-8', 'opacity-0');
            content.classList.add('scale-100', 'translate-y-0', 'opacity-100');

            // Close by clicking outside
            modal.addEventListener('click', function (e) {
                if (e.target === modal) {
                    closeNoteModal();
                }
            });
        }

        function closeNoteModal() {
            const modal = document.getElementById('noteModal');
            const content = document.getElementById('noteModalContent');

            // Revert animation classes (Fade Out + Slide Down)
            modal.classList.remove('opacity-100');
            modal.classList.add('opacity-0');

            content.classList.remove('scale-100', 'translate-y-0', 'opacity-100');
            content.classList.add('scale-95', 'translate-y-8', 'opacity-0');

            // Wait for CSS transition (400ms) before actually hiding the div
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 400);
        }

        let toastTimeout;
        function showToast(message) {
            const toast = document.getElementById('toastNotification');
            document.getElementById('toastMessage').textContent = message;

            // Clear existing timeout if multiple clicks happen
            if (toastTimeout) clearTimeout(toastTimeout);

            // Animate In (Slide Up + Fade In)
            toast.classList.remove('translate-y-20', 'opacity-0');
            toast.classList.add('translate-y-0', 'opacity-100');

            // Auto hide after 3 seconds
            toastTimeout = setTimeout(() => {
                // Animate Out (Slide Down + Fade Out)
                toast.classList.remove('translate-y-0', 'opacity-100');
                toast.classList.add('translate-y-20', 'opacity-0');
            }, 3000);
        }

        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#8c4a1d',
                confirmButtonText: 'Tutup',
                customClass: {
                    popup: 'rounded-3xl'
                }
            });
        @endif
    </script>
</body>

</html>