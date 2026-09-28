@extends('layouts.pembeli')

@section('content')
<div class="min-h-screen bg-[#fdfaf6] pb-12 pt-6 sm:py-12 flex items-center justify-center relative overflow-hidden">
    <!-- Background Decor -->
    <div class="absolute top-0 left-0 w-full h-64 bg-gradient-to-b from-[#6b3e1c] to-[#8b4f23]"></div>
    <div class="absolute top-0 left-0 w-full h-64 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>

    <div class="max-w-md w-full px-4 relative z-10">
        
        <!-- Header text -->
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('pembeli.riwayat-pesanan') }}" class="w-10 h-10 bg-white/20 hover:bg-white/30 rounded-full flex items-center justify-center text-white transition-colors backdrop-blur-sm">
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
            </a>
            <h1 class="font-heading text-2xl font-bold text-white">Detail Pesanan</h1>
        </div>

        <!-- Main Card -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-[0_20px_50px_rgba(107,62,28,0.1)]">
            
            <!-- Timeline Tracker -->
            <div class="mb-8 relative">
                <div class="absolute left-6 top-4 bottom-4 w-0.5 bg-gray-100"></div>
                
                <!-- Step 1: Dibuat -->
                <div class="relative flex gap-4 mb-6">
                    <div class="w-12 h-12 rounded-full bg-[#fcf9f5] border-2 border-[#f0e6d5] text-[#7a3b00] flex items-center justify-center shrink-0 z-10 bg-white">
                        <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                    </div>
                    <div class="pt-1.5">
                        <h4 class="text-sm font-bold text-[#4a3020]">Pesanan Dibuat</h4>
                        <p class="text-xs text-gray-500 mt-0.5">{{ $order->created_at->translatedFormat('d M Y, H:i') }}</p>
                    </div>
                </div>
                
                <!-- Step 2: Selesai/Batal/Menunggu -->
                <div class="relative flex gap-4">
                    @if($order->status === 'selesai')
                    <div class="w-12 h-12 rounded-full bg-[#4caf50] text-white flex items-center justify-center shrink-0 z-10 shadow-lg shadow-green-500/30 border-4 border-white ring-1 ring-green-100">
                        <i data-lucide="check" class="w-6 h-6"></i>
                    </div>
                    <div class="pt-1.5">
                        <h4 class="text-sm font-bold text-[#2e7d32]">Pesanan Selesai</h4>
                        <p class="text-xs text-gray-500 mt-0.5">Pembayaran telah berhasil</p>
                    </div>
                    @elseif($order->status === 'dibatalkan')
                    <div class="w-12 h-12 rounded-full bg-red-500 text-white flex items-center justify-center shrink-0 z-10 shadow-lg shadow-red-500/30 border-4 border-white ring-1 ring-red-100">
                        <i data-lucide="x" class="w-6 h-6"></i>
                    </div>
                    <div class="pt-1.5">
                        <h4 class="text-sm font-bold text-red-600">Dibatalkan</h4>
                        <p class="text-xs text-gray-500 mt-0.5">Pesanan tidak dilanjutkan</p>
                    </div>
                    @else
                    <div class="w-12 h-12 rounded-full bg-white border-2 border-dashed border-[#f59e0b] text-[#f59e0b] flex items-center justify-center shrink-0 z-10 shadow-sm">
                        <div class="absolute inset-0 rounded-full bg-orange-100 animate-ping opacity-30"></div>
                        <i data-lucide="clock" class="w-5 h-5 relative z-20"></i>
                    </div>
                    <div class="pt-1.5">
                        <h4 class="text-sm font-bold text-[#f59e0b]">Menunggu Pembayaran</h4>
                        <p class="text-xs text-gray-500 mt-0.5">Selesaikan pembayaran Anda</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Separator -->
            <div class="w-full h-px bg-gray-100 mb-6 relative mt-10">
                <span class="absolute left-1/2 -translate-x-1/2 -top-3 bg-white px-3 text-[10px] font-bold text-gray-400 uppercase tracking-widest rounded-full border border-gray-100">Informasi</span>
            </div>

            <!-- Order Information -->
            <div class="space-y-4 mb-6 bg-gray-50/50 p-4 rounded-2xl">
                <div class="flex justify-between items-center">
                    <span class="text-xs text-gray-500 font-medium">ID Pesanan</span>
                    <span class="text-sm font-bold text-[#6b3e1c]">{{ $order->order_number }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-xs text-gray-500 font-medium">Metode Pembayaran</span>
                    <span class="text-xs font-bold text-[#4a3020] bg-white border border-gray-200 px-2.5 py-1 rounded-lg uppercase shadow-sm">{{ $order->payment_method }}</span>
                </div>
            </div>

            <!-- Items -->
            <div class="bg-white rounded-2xl p-4 border border-[#f0e6d5] mb-6 shadow-[0_2px_10px_-5px_rgba(0,0,0,0.05)]">
                <div class="space-y-3">
                    @foreach($order->orderItems as $item)
                    <div class="flex justify-between items-start text-sm">
                        <div class="flex items-center gap-2">
                            <span class="bg-[#fcf9f5] border border-[#e8dfd3] text-[#7a3b00] font-bold w-6 h-6 rounded flex items-center justify-center text-xs">{{ $item->quantity }}x</span>
                            <span class="text-[#4a3020] font-medium">{{ $item->product_name ?? ($item->product ? $item->product->name : 'Item') }}</span>
                        </div>
                        <span class="text-[#7a6a5f] font-medium pt-0.5">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                    </div>
                    @endforeach
                    
                    <div class="border-t border-dashed border-[#e8dfd3] pt-3 mt-3">
                        @php
                            $realSubtotal = $order->subtotal ?? ($order->total_amount - $order->shipping_cost);
                            $pajak = $realSubtotal * 0.08;
                            $layanan = $realSubtotal * 0.05;
                        @endphp
                        <div class="flex justify-between items-center text-sm mb-2">
                            <span class="text-gray-500">Subtotal</span>
                            <span class="text-[#4a3020] font-medium">Rp {{ number_format($realSubtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm mb-2">
                            <span class="text-gray-500">Pajak (8%)</span>
                            <span class="text-[#4a3020] font-medium">Rp {{ number_format($pajak, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-500">Layanan (5%)</span>
                            <span class="text-[#4a3020] font-medium">Rp {{ number_format($layanan, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total -->
            <div class="flex justify-between items-end mb-8 bg-[#fdfaf6] p-4 rounded-2xl border border-[#f5e3d7]">
                <span class="text-[#4a3020] font-bold text-sm">Total Tagihan</span>
                <span class="text-2xl font-bold text-[#7a3b00]">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
            </div>

            <!-- Actions -->
            @if($order->status === 'menunggu_pembayaran')
                @if($order->payment_method === 'kasir')
                <a href="{{ route('pembeli.pembayaran.kasir', $order->order_number) }}" class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-[#f59e0b] to-[#d97706] hover:from-[#d97706] hover:to-[#b45309] text-white text-[15px] font-bold py-4 rounded-xl transition-all shadow-[0_8px_20px_rgba(245,158,11,0.25)] transform hover:-translate-y-0.5">
                    Tampilkan Layar Pembayaran <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
                @else
                <a href="{{ route('pembeli.pembayaran.qris', $order->order_number) }}" class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-[#f59e0b] to-[#d97706] hover:from-[#d97706] hover:to-[#b45309] text-white text-[15px] font-bold py-4 rounded-xl transition-all shadow-[0_8px_20px_rgba(245,158,11,0.25)] transform hover:-translate-y-0.5">
                    Tampilkan QRIS Pembayaran <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
                @endif
            @else
                <a href="{{ route('dashboard') }}" class="w-full flex items-center justify-center gap-2 bg-[#fdf9f5] border-2 border-[#f0e6d5] hover:bg-[#f5e3d7] text-[#6b3e1c] text-[15px] font-bold py-3.5 rounded-xl transition-all">
                    <i data-lucide="shopping-bag" class="w-4 h-4"></i> Belanja Lagi
                </a>
            @endif
        </div>
    </div>
</div>
@endsection
