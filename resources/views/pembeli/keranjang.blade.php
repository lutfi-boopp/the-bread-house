{{-- ========================================================================================= --}}
{{-- [FITUR PEMBELI] KERANJANG BELANJA                                                         --}}
{{-- Fungsi: Menampilkan item roti di keranjang, ubah jumlah kuantitas, & hapus item           --}}
{{-- ========================================================================================= --}}
@extends('layouts.pembeli')

@section('content')
    <div class="min-h-screen bg-[#fbf9f4] py-12 relative overflow-hidden">
        <!-- Decorative background elements -->
        <div class="absolute top-0 left-0 w-full h-96 bg-gradient-to-b from-[#f0e6d5]/40 to-transparent z-0"></div>
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-[#f5efe6] rounded-full blur-3xl opacity-60 z-0"></div>
        <div class="absolute top-48 -left-24 w-72 h-72 bg-[#f0e6d5] rounded-full blur-3xl opacity-50 z-0"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

            <!-- Back link -->
            <a href="{{ route('dashboard') ?? url('/') }}"
                class="inline-flex items-center text-sm font-semibold text-[#7a6a5f] hover:text-[#6b3e1c] transition-all mb-8 group bg-white/50 backdrop-blur px-4 py-2 rounded-full shadow-sm hover:shadow-md border border-[#e6dace]/50">
                <i data-lucide="arrow-left" class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform"></i> Kembali ke Katalog
            </a>

            <div class="flex items-center gap-3 mb-10">
                <div class="w-12 h-12 rounded-full bg-white shadow-sm flex items-center justify-center text-[#6b3e1c] border border-[#f0e6d5]">
                    <i data-lucide="shopping-bag" class="w-6 h-6"></i>
                </div>
                <h1 class="font-heading text-3xl md:text-4xl font-bold text-[#332115]">Keranjang Belanja</h1>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 xl:gap-12">

                <!-- Daftar Produk (Kiri) -->
                <div class="lg:col-span-2 space-y-6">

                    @forelse($cartItems as $item)
                        <!-- Produk Card -->
                        <div class="bg-white rounded-[2rem] p-4 sm:p-6 flex flex-col sm:flex-row items-center gap-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] border border-[#f0e6d5] transition-all duration-300 group">
                            
                            <div class="relative w-full sm:w-32 h-32 sm:h-32 flex-shrink-0 rounded-2xl overflow-hidden">
                                <img src="{{ $item->product->image ? asset('storage/' . $item->product->image) : 'https://placehold.co/400x300?text=No+Image' }}"
                                    alt="{{ $item->product->name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                <div class="absolute inset-0 border border-black/5 rounded-2xl"></div>
                            </div>
                            
                            <div class="flex-1 w-full text-center sm:text-left flex flex-col justify-center">
                                <div class="inline-block px-2.5 py-1 bg-[#f5efe6] text-[#6b3e1c] text-[10px] font-bold uppercase tracking-widest rounded-full w-max mx-auto sm:mx-0 mb-2">
                                    {{ $item->product->category->name ?? 'Roti' }}
                                </div>
                                <h3 class="font-heading text-xl font-bold text-[#332115] mb-1 group-hover:text-[#6b3e1c] transition-colors">{{ $item->product->name }}</h3>
                                <p class="text-sm text-[#7a6a5f] mb-3 line-clamp-1">{{ $item->product->description }}</p>
                                <p class="font-bold text-lg text-[#6b3e1c]">Rp {{ number_format($item->product->price, 0, ',', '.') }}</p>
                            </div>
                            
                            <div class="flex items-center gap-5 w-full sm:w-auto justify-between sm:justify-end mt-2 sm:mt-0 pt-4 sm:pt-0 border-t border-[#f0e6d5] sm:border-t-0">
                                <!-- Qty Control -->
                                <form action="{{ route('pembeli.keranjang.update', $item->id) }}" method="POST" class="m-0">
                                    @csrf
                                    @method('PUT')
                                    <div class="flex items-center bg-[#fbf9f4] rounded-xl border border-[#e6dace] p-1 shadow-inner">
                                        <button type="submit" name="quantity" value="{{ max(1, $item->quantity - 1) }}"
                                            class="w-8 h-8 rounded-lg flex items-center justify-center text-[#7a6a5f] hover:bg-white hover:text-[#6b3e1c] hover:shadow-sm transition-all">
                                            <i data-lucide="minus" class="w-4 h-4"></i>
                                        </button>
                                        <span class="text-sm font-bold text-[#332115] w-10 text-center">{{ $item->quantity }}</span>
                                        <button type="submit" name="quantity" value="{{ $item->quantity + 1 }}"
                                            class="w-8 h-8 rounded-lg flex items-center justify-center text-[#7a6a5f] hover:bg-white hover:text-[#6b3e1c] hover:shadow-sm transition-all">
                                            <i data-lucide="plus" class="w-4 h-4"></i>
                                        </button>
                                    </div>
                                </form>
                                
                                <!-- Delete -->
                                <form action="{{ route('pembeli.keranjang.destroy', $item->id) }}" method="POST" class="m-0" onsubmit="return confirm('Apakah Anda yakin ingin menghapus roti ini dari keranjang?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-10 h-10 rounded-xl bg-red-50 text-red-400 hover:bg-red-500 hover:text-white flex items-center justify-center transition-all shadow-sm hover:shadow-md" title="Hapus dari keranjang">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <!-- Empty State -->
                        <div class="bg-white rounded-[2rem] p-12 text-center shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-[#f0e6d5] flex flex-col items-center justify-center py-20">
                            <div class="w-32 h-32 bg-[#fbf9f4] rounded-full flex items-center justify-center mb-6 shadow-inner relative">
                                <i data-lucide="shopping-cart" class="w-12 h-12 text-[#d5c3b1]"></i>
                                <!-- Floating decorative dots -->
                                <div class="absolute top-4 right-4 w-3 h-3 bg-[#e6dace] rounded-full animate-bounce"></div>
                                <div class="absolute bottom-6 left-6 w-2 h-2 bg-[#d5c3b1] rounded-full animate-pulse"></div>
                            </div>
                            <h3 class="font-heading text-2xl font-bold text-[#332115] mb-2">Keranjang Masih Kosong</h3>
                            <p class="text-[#7a6a5f] max-w-sm mx-auto mb-8">Anda belum menambahkan roti lezat apapun ke dalam keranjang. Yuk jelajahi menu kami!</p>
                            <a href="{{ route('dashboard') }}" class="bg-[#6b3e1c] hover:bg-[#522d12] text-white font-bold py-3.5 px-8 rounded-xl transition-all shadow-lg shadow-[#6b3e1c]/20 transform hover:-translate-y-0.5 flex items-center gap-2">
                                <i data-lucide="search" class="w-4 h-4"></i> Mulai Belanja
                            </a>
                        </div>
                    @endforelse

                </div>

                <!-- Ringkasan Pesanan (Kanan) -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-[2rem] p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-[#f0e6d5] sticky top-8 relative overflow-hidden">
                        
                        <!-- Top Receipt Zig-zag decorative -->
                        <div class="absolute top-0 left-0 w-full h-2 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyMCIgaGVpZ2h0PSI4Ij48cGF0aCBkPSJNMCAwTDEwIDhsMTAtOHY4SDB6IiBmaWxsPSIjZmJmOWY0Ii8+PC9zdmc+')] opacity-50"></div>
                        
                        <div class="flex items-center gap-3 mb-6 mt-2">
                            <div class="w-8 h-8 rounded-full bg-[#fbf9f4] flex items-center justify-center text-[#6b3e1c]">
                                <i data-lucide="receipt" class="w-4 h-4"></i>
                            </div>
                            <h2 class="font-heading text-xl font-bold text-[#332115]">Ringkasan Pesanan</h2>
                        </div>

                        @php
                            $subtotal = $cartItems->sum(function ($item) {
                                return $item->product->price * $item->quantity;
                            });
                            $totalBarang = $cartItems->sum('quantity');
                            $pajak = $subtotal * 0.08;
                            $layanan = $subtotal * 0.05;
                            $total = $subtotal + $pajak + $layanan;
                        @endphp

                        <div class="space-y-4 mb-6 text-sm">
                            <div class="flex justify-between items-center text-[#7a6a5f]">
                                <span>Subtotal ({{ $totalBarang }} barang)</span>
                                <span class="font-bold text-[#332115]">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            @if($totalBarang > 0)
                                <div class="flex justify-between items-center text-[#7a6a5f]">
                                    <span class="flex items-center gap-1.5">
                                        Pajak (8%)
                                    </span>
                                    <span class="font-bold text-[#332115]">Rp {{ number_format($pajak, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between items-center text-[#7a6a5f]">
                                    <span class="flex items-center gap-1.5">
                                        Layanan (5%)
                                    </span>
                                    <span class="font-bold text-[#332115]">Rp {{ number_format($layanan, 0, ',', '.') }}</span>
                                </div>
                            @endif
                        </div>

                        <div class="border-t-2 border-dashed border-[#e6dace] pt-6 mb-8 relative">
                            <!-- Cutout circles for receipt effect -->
                            <div class="absolute -left-10 -top-3 w-6 h-6 bg-[#fbf9f4] rounded-full border border-[#f0e6d5] border-r-0"></div>
                            <div class="absolute -right-10 -top-3 w-6 h-6 bg-[#fbf9f4] rounded-full border border-[#f0e6d5] border-l-0"></div>
                            
                            <div class="flex justify-between items-end">
                                <div>
                                    <span class="block text-[10px] uppercase tracking-wider text-[#7a6a5f] font-semibold mb-1">Total Pembayaran</span>
                                </div>
                                <span class="text-2xl font-bold text-[#6b3e1c]">
                                    Rp {{ $totalBarang > 0 ? number_format($total, 0, ',', '.') : 0 }}
                                </span>
                            </div>
                        </div>

                        @if($totalBarang > 0)
                            <a href="{{ route('pembeli.checkout') }}"
                                class="w-full bg-[#6b3e1c] hover:bg-[#522d12] text-white font-bold py-4 rounded-xl transition-all shadow-lg shadow-[#6b3e1c]/20 flex justify-center items-center gap-2 transform hover:-translate-y-0.5 group">
                                Lanjut ke Pembayaran 
                                <div class="w-6 h-6 rounded-full bg-white/20 flex items-center justify-center group-hover:bg-white/30 transition-colors">
                                    <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                                </div>
                            </a>
                            <p class="text-center text-[10px] text-[#7a6a5f] mt-4 flex items-center justify-center gap-1">
                                <i data-lucide="shield-check" class="w-3 h-3 text-green-500"></i> Transaksi Aman & Terenkripsi
                            </p>
                        @else
                            <button disabled class="w-full bg-[#f0e6d5] text-[#a89b8d] font-bold py-4 rounded-xl cursor-not-allowed flex justify-center items-center gap-2">
                                Lanjut ke Pembayaran
                            </button>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection