@extends('layouts.pembeli')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 relative">

    <!-- Header Section -->
    <div class="mb-8">
        <h1 class="font-heading text-4xl font-bold text-[#6b3e1c] mb-3">Riwayat Pesanan Saya</h1>
        <p class="text-[#7a6a5f]">Lacak dan kelola semua pesanan roti artisanal Anda di sini.</p>
    </div>

    <!-- Filter Pills -->
    <div class="flex flex-wrap items-center gap-3 mb-8">
        <a href="{{ route('pembeli.riwayat-pesanan') }}" class="px-5 py-2 rounded-full {{ empty($status) ? 'bg-[#6b3e1c] text-white font-semibold' : 'bg-[#ebe7e0] text-[#7a6a5f] font-medium hover:bg-[#dfd9ce]' }} text-sm transition-colors">Semua</a>
        <a href="{{ route('pembeli.riwayat-pesanan', ['status' => 'menunggu_pembayaran']) }}" class="px-5 py-2 rounded-full {{ ($status ?? '') == 'menunggu_pembayaran' ? 'bg-[#6b3e1c] text-white font-semibold' : 'bg-[#ebe7e0] text-[#7a6a5f] font-medium hover:bg-[#dfd9ce]' }} text-sm transition-colors">Menunggu Pembayaran</a>
        <a href="{{ route('pembeli.riwayat-pesanan', ['status' => 'selesai']) }}" class="px-5 py-2 rounded-full {{ ($status ?? '') == 'selesai' ? 'bg-[#6b3e1c] text-white font-semibold' : 'bg-[#ebe7e0] text-[#7a6a5f] font-medium hover:bg-[#dfd9ce]' }} text-sm transition-colors">Selesai</a>
    </div>

    <!-- Order List -->
    <div class="space-y-4 mb-10">
        
        @forelse($orders as $order)
        <div class="bg-white rounded-xl p-5 border border-[#f0e6d5] shadow-[0_2px_10px_-5px_rgba(0,0,0,0.05)] flex flex-col md:flex-row md:items-center justify-between gap-5 {{ $order->status === 'dibatalkan' ? 'opacity-75' : '' }}">
            <div class="flex items-center gap-5">
                <div class="w-20 h-20 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400">
                    <i data-lucide="shopping-bag" class="w-8 h-8"></i>
                </div>
                <div>
                    <div class="flex items-center gap-3 mb-1">
                        <span class="font-bold text-[#6b3e1c] text-sm">{{ $order->order_number }}</span>
                        @if($order->status === 'selesai')
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs font-semibold bg-[#e6f4ea] text-[#1e7e34]">
                            <i data-lucide="check-circle" class="w-3 h-3"></i> Selesai
                        </span>
                        @elseif($order->status === 'menunggu_pembayaran')
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs font-semibold bg-[#fef3c7] text-[#92400e]">
                            <i data-lucide="clock" class="w-3 h-3"></i> Menunggu Pembayaran
                        </span>
                        @elseif($order->status === 'diproses')
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs font-semibold bg-[#e0f2fe] text-[#0369a1]">
                            <i data-lucide="loader" class="w-3 h-3"></i> Diproses
                        </span>
                        @else
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs font-semibold bg-[#fce8e8] text-[#c53030]">
                            <i data-lucide="x-circle" class="w-3 h-3"></i> Dibatalkan
                        </span>
                        @endif
                    </div>
                    <p class="text-xs text-[#7a6a5f] mb-2">{{ $order->created_at->format('d F Y, H:i') }} WIB</p>
                    <p class="font-bold text-[#6b3e1c] text-lg">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                @if($order->status === 'menunggu_pembayaran')
                    @if($order->payment_method === 'kasir')
                    <a href="{{ route('pembeli.pembayaran.kasir', $order->order_number) }}" class="px-4 py-2 rounded-lg bg-[#f59e0b] text-white text-sm font-semibold hover:bg-[#d97706] transition-colors">
                        Bayar Sekarang
                    </a>
                    @else
                    <a href="{{ route('pembeli.pembayaran.qris', $order->order_number) }}" class="px-4 py-2 rounded-lg bg-[#f59e0b] text-white text-sm font-semibold hover:bg-[#d97706] transition-colors">
                        Bayar Sekarang
                    </a>
                    @endif
                @endif
                <a href="{{ route('pembeli.pesanan.detail', $order->order_number) }}" class="px-4 py-2 rounded-lg {{ $order->status === 'dibatalkan' ? 'bg-[#f0e6d5] text-[#a39487]' : 'bg-[#6b3e1c] text-white hover:bg-[#522d12]' }} text-sm font-semibold transition-colors">
                    Lihat Detail
                </a>
            </div>
        </div>
        @empty
        <div class="text-center py-10">
            <p class="text-gray-500">Anda belum memiliki pesanan.</p>
        </div>
        @endforelse

    </div>

    <!-- Pagination -->
    @if ($orders->hasPages())
    <div class="flex items-center justify-between bg-white px-6 py-4 rounded-xl border border-[#f0e6d5] shadow-sm mt-4">
        <a href="{{ $orders->previousPageUrl() }}" class="flex items-center gap-2 px-4 py-2 text-sm font-semibold rounded-lg transition-all {{ $orders->onFirstPage() ? 'text-gray-400 bg-gray-50 pointer-events-none' : 'text-[#6b3e1c] hover:bg-[#f5efe6]' }}">
            <i data-lucide="chevron-left" class="w-4 h-4"></i> Sebelumnya
        </a>
        <span class="text-sm font-bold text-gray-600">
            Halaman {{ $orders->currentPage() }} dari {{ $orders->lastPage() }}
        </span>
        <a href="{{ $orders->nextPageUrl() }}" class="flex items-center gap-2 px-4 py-2 text-sm font-semibold rounded-lg transition-all {{ !$orders->hasMorePages() ? 'text-gray-400 bg-gray-50 pointer-events-none' : 'text-[#6b3e1c] hover:bg-[#f5efe6]' }}">
            Selanjutnya <i data-lucide="chevron-right" class="w-4 h-4"></i>
        </a>
    </div>
    @endif

</div>
@endsection
