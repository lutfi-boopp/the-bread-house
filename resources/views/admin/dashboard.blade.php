{{-- ========================================================================================= --}}
{{-- [FITUR ADMIN] DASHBOARD UTAMA ADMIN --}}
{{-- Fungsi: Menampilkan indikator pendapatan, statistik pesanan, warning stok, & pesanan baru --}}
{{-- ========================================================================================= --}}
@extends('layouts.admin')

@section('content')
    <div class="w-full">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end mb-8 gap-4">
            <div>
                <h2 class="font-heading text-4xl font-bold text-[#693e1b] mb-1">Ringkasan Bisnis</h2>
                <p class="text-sm text-[#8c7a6b]">Pantau performa UpiBakery Anda hari ini.</p>
            </div>
            <div
                class="flex items-center bg-[#f9f5f0] border border-[#ece3d4] px-4 py-2.5 rounded-xl text-sm font-semibold text-[#472c1b] shadow-sm">
                <i data-lucide="calendar" class="w-4 h-4 mr-2 text-[#8c7a6b]"></i>
                <span id="realtime-clock">{{ \Carbon\Carbon::now()->translatedFormat('d F Y • H:i:s') }}</span>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <!-- Card 1: Pendapatan -->
            <div
                class="bg-white border border-[#ece3d4] rounded-2xl p-5 shadow-sm relative overflow-hidden group hover:border-[#e2d5c2] transition-colors">
                <div class="flex justify-between items-start mb-6">
                    <div class="w-10 h-10 bg-[#fdf0dc] rounded-xl flex items-center justify-center text-[#b86b16]">
                        <i data-lucide="banknote" class="w-5 h-5"></i>
                    </div>
                </div>
                <div class="text-[10px] font-bold text-[#8c7a6b] tracking-wider uppercase mb-1">Pendapatan Hari Ini</div>
                <div class="text-xl font-bold text-[#693e1b]">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
            </div>

            <!-- Card 2: Pesanan Masuk -->
            <div
                class="bg-white border border-[#ece3d4] rounded-2xl p-5 shadow-sm relative overflow-hidden group hover:border-[#e2d5c2] transition-colors">
                <div class="flex justify-between items-start mb-6">
                    <div class="w-10 h-10 bg-[#f9f5f0] rounded-xl flex items-center justify-center text-[#693e1b]">
                        <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                    </div>
                </div>
                <div class="text-[10px] font-bold text-[#8c7a6b] tracking-wider uppercase mb-1">Pesanan Hari Ini</div>
                <div class="text-xl font-bold text-[#693e1b]">{{ $totalOrders }} Pesanan</div>
            </div>

            <!-- Card 3: Stok Menipis -->
            <div
                class="bg-white border border-[#ece3d4] rounded-2xl p-5 shadow-sm relative overflow-hidden group hover:border-[#e2d5c2] transition-colors">
                <div class="flex justify-between items-start mb-6">
                    <div
                        class="w-10 h-10 {{ $lowStockCount > 0 ? 'bg-[#fae8e8] text-[#c42b2b]' : 'bg-[#e6f5eb] text-[#1d8a43]' }} rounded-xl flex items-center justify-center">
                        <i data-lucide="alert-triangle" class="w-5 h-5"></i>
                    </div>
                </div>
                <div class="text-[10px] font-bold text-[#8c7a6b] tracking-wider uppercase mb-1">Stok Menipis (&lt;15)</div>
                <div class="text-xl font-bold {{ $lowStockCount > 0 ? 'text-[#c42b2b]' : 'text-[#693e1b]' }}">
                    {{ $lowStockCount }} Produk
                </div>
            </div>

                <!-- Card 4: Pelanggan Baru -->
                <div
                    class="bg-white border border-[#ece3d4] rounded-2xl p-5 shadow-sm relative overflow-hidden group hover:border-[#e2d5c2] transition-colors">
                    <div class="flex justify-between items-start mb-6">
                        <div class="w-10 h-10 bg-[#e6f5eb] rounded-xl flex items-center justify-center text-[#1d8a43]">
                            <i data-lucide="users" class="w-5 h-5"></i>
                        </div>
                    </div>
                    <div class="text-[10px] font-bold text-[#8c7a6b] tracking-wider uppercase mb-1">Pelanggan Baru (Bulan
                        Ini)</div>
                    <div class="text-xl font-bold text-[#693e1b]">{{ $newCustomers }} Orang</div>
                </div>
            </div>

            <!-- Tables Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Pesanan Terbaru -->
                <div class="lg:col-span-2">
                    <div class="flex justify-between items-end mb-4">
                        <h3 class="font-heading text-xl font-bold text-[#472c1b]">Pesanan Terbaru</h3>
                    </div>
                    <div class="bg-white border border-[#ece3d4] rounded-2xl overflow-hidden shadow-sm overflow-x-auto">
                        <table class="w-full text-left text-sm min-w-[600px]">
                            <thead class="text-[#472c1b] text-xs font-bold border-b border-[#ece3d4] bg-[#faf9f6]">
                                <tr>
                                    <th class="px-6 py-4">ID Pesanan</th>
                                    <th class="px-6 py-4">Pelanggan</th>
                                    <th class="px-6 py-4">Produk</th>
                                    <th class="px-6 py-4 text-center">Status</th>
                                    <th class="px-6 py-4 text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#ece3d4]">
                                @forelse($recentOrders as $order)
                                    <tr class="hover:bg-[#fbf9f6] transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="font-bold text-[#693e1b]">{{ $order->order_number }}</div>
                                            <div class="text-[10px] text-gray-500 mt-1">
                                                {{ $order->created_at->diffForHumans() }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-[#472c1b] font-medium text-sm">
                                                {{ $order->recipient_name ?? $order->user->name ?? 'Walk-in' }}</div>
                                            <div class="text-[10px] text-gray-500 font-bold uppercase">
                                                @if($order->order_type === 'dine_in')
                                                    Dine In
                                                @elseif($order->order_type === 'takeaway')
                                                    Takeaway
                                                @else
                                                    {{ str_replace('_', ' ', $order->order_type) }}
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-[#472c1b] font-medium text-xs">
                                            @php
                                                $items = $order->orderItems->map(function ($item) {
                                                    return $item->quantity . 'x ' . ($item->product->name ?? 'Item');
                                                })->implode('<br>');
                                            @endphp
                                            {!! Str::limit(strip_tags(str_replace('<br>', ', ', $items)), 40) !!}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @if($order->status === 'menunggu_pembayaran')
                                                <span
                                                    class="bg-[#fef3c7] text-[#92400e] px-3 py-1.5 rounded-full text-[10px] font-bold tracking-wide">Menunggu</span>
                                            @elseif($order->status === 'diproses')
                                                <span
                                                    class="bg-[#fdf0dc] text-[#b86b16] px-3 py-1.5 rounded-full text-[10px] font-bold tracking-wide">Diproses</span>
                                            @elseif($order->status === 'selesai')
                                                <span
                                                    class="bg-[#e6f5eb] text-[#1d8a43] px-3 py-1.5 rounded-full text-[10px] font-bold tracking-wide">Selesai</span>
                                            @else
                                                <span
                                                    class="bg-[#fae8e8] text-[#c42b2b] px-3 py-1.5 rounded-full text-[10px] font-bold tracking-wide">Batal</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 font-bold text-[#472c1b] text-right">Rp
                                            {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-10 text-center text-gray-500">Belum ada pesanan masuk.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Stok Roti -->
                <div>
                    <div class="flex justify-between items-end mb-4">
                        <h3 class="font-heading text-xl font-bold text-[#472c1b]">Stok Roti</h3>
                        <a href="{{ route('admin.stok') }}"
                            class="text-xs font-bold text-[#693e1b] hover:underline">Kelola</a>
                    </div>
                    <div class="bg-white border border-[#ece3d4] rounded-2xl p-6 shadow-sm">

                        <div class="space-y-6 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar">
                            @forelse($products as $product)
                                @php
                                    // Hitung persentase dari target stok misalnya 100
                                    $maxStock = 100;
                                    $percentage = min(100, ($product->stock / $maxStock) * 100);

                                    $isLow = $product->stock < 15;
                                    $isCritical = $product->stock < 5;

                                    $barColor = $isCritical ? 'bg-[#c42b2b]' : ($isLow ? 'bg-[#b86b16]' : 'bg-[#693e1b]');
                                @endphp
                                <div class="flex items-center">
                                    @if($product->image)
                                        <img src="{{ Storage::url($product->image) }}"
                                            class="w-12 h-12 rounded-lg object-cover mr-4" alt="{{ $product->name }}">
                                    @else
                                        <div
                                            class="w-12 h-12 rounded-lg bg-gray-100 flex items-center justify-center mr-4 text-gray-400">
                                            <i data-lucide="image" class="w-6 h-6"></i>
                                        </div>
                                    @endif
                                    <div class="flex-1">
                                        <h4 class="text-[13px] font-bold text-[#472c1b]">{{ $product->name }}</h4>
                                        <div class="mt-2 w-full bg-[#f9f5f0] rounded-full h-1.5">
                                            <div class="{{ $barColor }} h-1.5 rounded-full" style="width: {{ $percentage }}%">
                                            </div>
                                        </div>
                                        <div class="flex justify-between items-center mt-1.5">
                                            @if($isCritical)
                                                <div class="text-[10px] font-bold text-[#c42b2b]">Kritis</div>
                                            @elseif($isLow)
                                                <div class="text-[10px] font-bold text-[#b86b16]">Menipis</div>
                                            @else
                                                <div class="text-[10px] font-bold text-[#1d8a43]">Aman</div>
                                            @endif
                                            <div class="text-[10px] font-bold text-[#472c1b]">{{ $product->stock }} pcs</div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center text-sm text-gray-500 py-4">Belum ada produk di database.</div>
                            @endforelse
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <style>
            .custom-scrollbar::-webkit-scrollbar {
                width: 4px;
            }

            .custom-scrollbar::-webkit-scrollbar-track {
                background: #f9f5f0;
                border-radius: 10px;
            }

            .custom-scrollbar::-webkit-scrollbar-thumb {
                background: #ece3d4;
                border-radius: 10px;
            }

            .custom-scrollbar::-webkit-scrollbar-thumb:hover {
                background: #d4c5b0;
            }
        </style>

        <script>
            function updateAdminClock() {
                const now = new Date();
                const options = { day: '2-digit', month: 'long', year: 'numeric' };
                const dateStr = now.toLocaleDateString('id-ID', options);
                const timeStr = now.getHours().toString().padStart(2, '0') + ':' +
                    now.getMinutes().toString().padStart(2, '0') + ':' +
                    now.getSeconds().toString().padStart(2, '0');

                const clockEl = document.getElementById('realtime-clock');
                if (clockEl) {
                    clockEl.textContent = dateStr + ' • ' + timeStr;
                }
            }
            setInterval(updateAdminClock, 1000);
            updateAdminClock();
        </script>
@endsection