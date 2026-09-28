@extends('layouts.pembeli')

@section('content')
<div class="min-h-screen bg-[#fdfaf6] py-12 flex items-center justify-center relative overflow-hidden">
    <!-- Background Decor -->
    <div class="absolute top-0 left-0 w-full h-96 bg-gradient-to-b from-[#e3cbad]/30 to-transparent"></div>
    <div class="absolute -top-24 -right-24 w-96 h-96 bg-[#f5e3d7] rounded-full mix-blend-multiply filter blur-3xl opacity-60"></div>
    <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-[#e3cad6] rounded-full mix-blend-multiply filter blur-3xl opacity-40"></div>

    <div class="max-w-md w-full px-4 relative z-10">
        
        <!-- Main Card: Receipt Style -->
        <div class="bg-white rounded-3xl p-8 sm:p-10 shadow-[0_20px_50px_rgba(107,62,28,0.08)] relative">
            
            <!-- Animations -->
            <style>
                @keyframes scaleUp {
                    0% { transform: scale(0.8) translateY(20px); opacity: 0; }
                    100% { transform: scale(1) translateY(0); opacity: 1; }
                }
                @keyframes slideUpFade {
                    0% { transform: translateY(15px); opacity: 0; }
                    100% { transform: translateY(0); opacity: 1; }
                }
                .animate-scale-up { animation: scaleUp 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
                .animate-slide-up-1 { animation: slideUpFade 0.6s cubic-bezier(0.16, 1, 0.3, 1) 0.2s forwards; opacity: 0; }
                .animate-slide-up-2 { animation: slideUpFade 0.6s cubic-bezier(0.16, 1, 0.3, 1) 0.35s forwards; opacity: 0; }
                .animate-slide-up-3 { animation: slideUpFade 0.6s cubic-bezier(0.16, 1, 0.3, 1) 0.5s forwards; opacity: 0; }
                .animate-slide-up-4 { animation: slideUpFade 0.6s cubic-bezier(0.16, 1, 0.3, 1) 0.65s forwards; opacity: 0; }
            </style>

            <div class="flex flex-col items-center">
                
                <!-- Success Icon -->
                <div class="relative w-24 h-24 mb-6 animate-scale-up">
                    <div class="absolute inset-0 bg-[#e8f5e9] rounded-full animate-ping opacity-60" style="animation-duration: 2.5s;"></div>
                    <div class="relative w-full h-full bg-gradient-to-tr from-[#4caf50] to-[#81c784] rounded-full flex items-center justify-center text-white shadow-lg shadow-green-500/20 border-4 border-white">
                        <i data-lucide="check" class="w-12 h-12"></i>
                    </div>
                </div>
                
                <!-- Headers -->
                <h1 class="font-heading text-3xl font-bold text-[#4a3020] mb-2 text-center leading-tight animate-slide-up-1">Pembayaran<br>Berhasil!</h1>
                <p class="text-sm text-[#8c7a6b] text-center mb-8 px-2 animate-slide-up-1">Terima kasih telah berbelanja di The Bread House. Pesanan Anda akan segera kami siapkan dengan penuh cinta.</p>
                
                <!-- Separator -->
                <div class="w-full relative h-[1px] bg-gray-200 mb-8 animate-slide-up-2">
                    <div class="absolute -left-10 top-1/2 -translate-y-1/2 w-6 h-6 bg-[#fdfaf6] rounded-full border-r border-gray-200"></div>
                    <div class="absolute -right-10 top-1/2 -translate-y-1/2 w-6 h-6 bg-[#fdfaf6] rounded-full border-l border-gray-200"></div>
                </div>

                <!-- Order ID -->
                <div class="w-full flex justify-between items-center mb-6 animate-slide-up-2">
                    <span class="text-xs text-[#8c7a6b] font-bold uppercase tracking-widest">ID Pesanan</span>
                    <span class="text-sm font-bold text-[#7a3b00] bg-[#fdf5eb] px-3 py-1 rounded-lg">{{ $order->order_number }}</span>
                </div>
                
                <!-- Order Summary -->
                <div class="w-full bg-[#fcf9f5] rounded-2xl p-5 mb-8 border border-[#f0e6d5] animate-slide-up-3">
                    <div class="space-y-4">
                        @foreach($order->orderItems as $item)
                        <div class="flex justify-between items-start text-sm">
                            <div class="flex items-center gap-3">
                                <span class="bg-white border border-[#e8dfd3] text-[#7a3b00] font-bold w-6 h-6 rounded flex items-center justify-center text-xs shadow-sm">{{ $item->quantity }}x</span>
                                <span class="text-[#4a3020] font-medium leading-tight max-w-[150px] sm:max-w-[180px]">{{ $item->product_name ?? ($item->product ? $item->product->name : 'Item') }}</span>
                            </div>
                            <span class="text-[#7a6a5f] font-medium pt-0.5">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                        </div>
                        @endforeach
                        
                        <div class="border-t border-dashed border-[#e8dfd3] pt-4 mt-2">
                            <div class="flex justify-between items-center text-sm mb-2">
                                <span class="text-[#8c7a6b]">Subtotal</span>
                                <span class="text-[#4a3020] font-medium">Rp {{ number_format($order->subtotal ?? ($order->total_amount - $order->shipping_cost), 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-[#8c7a6b]">Biaya Tambahan</span>
                                <span class="text-[#4a3020] font-medium">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        
                        <div class="border-t border-[#e8dfd3] pt-4 mt-2 flex justify-between items-end">
                            <span class="text-[#4a3020] font-bold mb-1">Total Pembayaran</span>
                            <span class="text-2xl font-bold text-[#7a3b00]">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
                
                <!-- Buttons -->
                <div class="w-full space-y-3 animate-slide-up-4">
                    <a href="{{ route('pembeli.riwayat-pesanan') }}" class="flex items-center justify-center gap-2 w-full bg-gradient-to-r from-[#7a3b00] to-[#9c5929] hover:from-[#522a0e] hover:to-[#7a3b00] text-white text-[15px] font-bold py-4 rounded-2xl transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                        Lacak Pesanan Saya <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                    <a href="{{ route('dashboard') }}" class="flex items-center justify-center w-full bg-white border-2 border-[#f0e6d5] hover:bg-[#fcf9f5] text-[#8c7a6b] hover:text-[#7a3b00] text-[15px] font-bold py-3.5 rounded-2xl transition-all duration-300">
                        Kembali ke Beranda
                    </a>
                </div>
                
            </div>
        </div>

    </div>
</div>
@endsection
