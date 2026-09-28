{{-- ========================================================================================= --}}
{{-- [FITUR PEMBELI] HALAMAN CHECKOUT PESANAN                                                  --}}
{{-- Fungsi: Input nama penerima, nomor meja, metode pembayaran (Kasir/QRIS), & rincian biaya --}}
{{-- ========================================================================================= --}}
@extends('layouts.pembeli')

@section('content')
    <div class="min-h-screen bg-[#faf8f5] py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <form action="{{ route('pembeli.checkout.process') }}" method="POST" id="checkout-form"
                class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                @csrf
                
                @guest
                <!-- Guest Warning Banner -->
                <div class="col-span-1 lg:col-span-3 mb-2">
                    <div class="bg-gradient-to-r from-[#6b3e1c] to-[#b37a54] rounded-2xl p-4 sm:p-6 shadow-md text-white flex flex-col sm:flex-row items-center justify-between gap-4 relative overflow-hidden">
                        <div class="absolute -right-4 -top-4 opacity-20">
                            <i data-lucide="gift" class="w-24 h-24"></i>
                        </div>
                        <div class="flex items-start sm:items-center gap-4 relative z-10">
                            <div class="bg-white/20 p-3 rounded-full hidden sm:block">
                                <i data-lucide="info" class="w-6 h-6 text-white"></i>
                            </div>
                            <div>
                                <h3 class="font-heading font-bold text-lg">Pesan Sebagai Tamu</h3>
                                <p class="text-sm text-white/90 mt-1 max-w-2xl">Anda belum masuk akun. <strong>Login sekarang</strong> untuk kemudahan melacak pesanan, mendapatkan promo spesial, dan benefit member lainnya!</p>
                            </div>
                        </div>
                        <div class="flex gap-3 whitespace-nowrap relative z-10 w-full sm:w-auto">
                            <a href="{{ route('login') }}" class="flex-1 sm:flex-none text-center bg-white text-[#6b3e1c] px-6 py-2.5 rounded-xl font-bold text-sm hover:bg-gray-50 transition-colors shadow-sm">Masuk</a>
                            <a href="{{ route('register') }}" class="flex-1 sm:flex-none text-center bg-transparent border border-white text-white px-6 py-2.5 rounded-xl font-bold text-sm hover:bg-white/10 transition-colors">Daftar</a>
                        </div>
                    </div>
                </div>
                @endguest

                <!-- Form Informasi & Pembayaran (Kiri) -->
                <div class="lg:col-span-2 space-y-8">

                    <!-- Informasi Pemesan -->
                    <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
                        <h2 class="font-heading text-xl font-bold text-[#6b3e1c] mb-6 flex items-center">
                            <i data-lucide="utensils" class="w-5 h-5 mr-3"></i> Informasi Meja (Dine-in)
                        </h2>

                        @if ($errors->any())
                            <div class="bg-red-50 text-red-500 p-4 rounded-lg mb-6 text-sm">
                                <ul class="list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="space-y-6">
                            <!-- Biodata -->
                            <div>
                                <h3 class="text-xs font-bold text-[#b37a54] uppercase tracking-wider mb-4">Biodata Pemesan
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-[#332115] mb-1">Nama Lengkap</label>
                                        <input type="text" name="recipient_name"
                                            value="{{ old('recipient_name') }}" required
                                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-[#6b3e1c] focus:ring focus:ring-[#6b3e1c] focus:ring-opacity-20 text-sm py-2.5 px-3"
                                            placeholder="Masukkan nama lengkap">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-[#332115] mb-1">Nomor Meja</label>
                                        <input type="text" name="table_number" value="{{ old('table_number') }}"
                                            required
                                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-[#6b3e1c] focus:ring focus:ring-[#6b3e1c] focus:ring-opacity-20 text-sm py-2.5 px-3"
                                            placeholder="Contoh: 03">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-[#332115] mb-1">Email <span class="text-gray-500 font-normal">(opsional)</span></label>
                                        <input type="email" name="email" value="{{ old('email') }}"
                                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-[#6b3e1c] focus:ring focus:ring-[#6b3e1c] focus:ring-opacity-20 text-sm py-2.5 px-3"
                                            placeholder="Masukkan email Anda">
                                        <p class="text-xs text-gray-500 mt-1">*Struk rincian pesanan akan dikirimkan ke email ini.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Catatan -->
                            <div>
                                <h3 class="text-xs font-bold text-[#b37a54] uppercase tracking-wider mb-4">Catatan Pesanan
                                </h3>
                                <div>
                                    <label class="block text-sm font-medium text-[#332115] mb-1">Instruksi Khusus (Opsional)</label>
                                    <textarea name="shipping_notes" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-[#6b3e1c] focus:ring focus:ring-[#6b3e1c] focus:ring-opacity-20 text-sm py-2.5 px-3" rows="2" placeholder="Contoh: Roti tolong dihangatkan dulu">{{ old('shipping_notes') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Metode Pembayaran -->
                    <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
                        <h2 class="font-heading text-xl font-bold text-[#6b3e1c] mb-6 flex items-center">
                            <i data-lucide="wallet" class="w-5 h-5 mr-3"></i> Metode Pembayaran
                        </h2>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Bayar di Kasir (Selected) -->
                            <label class="relative cursor-pointer">
                                <input type="radio" name="payment_method" value="kasir" class="peer sr-only" checked>
                                <div
                                    class="rounded-lg border border-gray-200 p-3 flex flex-row justify-center items-center gap-3 peer-checked:bg-[#f5e3d7] peer-checked:border-[#b37a54] transition-all">
                                    <i data-lucide="store" class="w-5 h-5 text-[#6b3e1c]"></i>
                                    <span class="font-semibold text-sm text-[#332115]">Bayar di Kasir</span>
                                </div>
                            </label>

                            <!-- QRIS -->
                            <label class="relative cursor-pointer">
                                <input type="radio" name="payment_method" value="qris" class="peer sr-only">
                                <div
                                    class="rounded-lg border border-gray-200 p-3 flex flex-row justify-center items-center gap-3 hover:bg-gray-50 peer-checked:bg-[#f5e3d7] peer-checked:border-[#b37a54] transition-all">
                                    <i data-lucide="qr-code" class="w-5 h-5 text-[#7a6a5f] peer-checked:text-[#6b3e1c]"></i>
                                    <span
                                        class="font-semibold text-sm text-[#7a6a5f] peer-checked:text-[#332115]">QRIS</span>
                                </div>
                            </label>
                        </div>
                    </div>

                </div>

                <!-- Ringkasan Pesanan (Kanan) -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 sticky top-8">
                        <h2
                            class="font-heading text-xl font-bold text-[#6b3e1c] mb-6 flex items-center border-b border-gray-100 pb-4">
                            <i data-lucide="receipt" class="w-5 h-5 mr-3"></i> Ringkasan Pesanan
                        </h2>

                        <!-- Item List -->
                        <div class="space-y-4 mb-6">
                            @foreach($cartItems as $item)
                                <!-- Item -->
                                <div class="flex items-center gap-4">
                                    <img src="{{ $item->product->image ? asset('storage/' . $item->product->image) : 'https://placehold.co/150x150?text=No+Image' }}"
                                        alt="{{ $item->product->name }}" class="w-12 h-12 rounded-lg object-cover">
                                    <div class="flex-1">
                                        <h4 class="text-sm font-semibold text-[#332115]">{{ $item->product->name }}</h4>
                                        <p class="text-xs text-gray-500">{{ $item->quantity }} x Rp
                                            {{ number_format($item->product->price, 0, ',', '.') }}</p>
                                    </div>
                                    <span class="text-sm font-semibold text-[#332115]">Rp
                                        {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        </div>

                        <div class="border-t border-gray-100 pt-4 mb-6 space-y-3 text-sm text-[#7a6a5f]">
                            <div class="flex justify-between">
                                <span>Subtotal</span>
                                <span class="font-medium text-[#332115]">Rp
                                    {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Pajak (8%)</span>
                                <span class="font-medium text-[#332115]">Rp
                                    {{ number_format(round($subtotal * 0.08), 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between mt-3">
                                <span>Layanan (5%)</span>
                                <span class="font-medium text-[#332115]">Rp
                                    {{ number_format($shippingCost - round($subtotal * 0.08), 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="border-t border-gray-100 pt-6 mb-8">
                            <div class="flex justify-between items-center">
                                <span class="text-[#6b3e1c] font-bold">Total</span>
                                <span class="text-2xl font-bold text-[#332115]">Rp
                                    {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <button type="submit"
                            class="w-full bg-[#6b3e1c] hover:bg-[#522e15] text-white font-semibold py-4 rounded-xl transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5 flex justify-center items-center mb-4 relative overflow-hidden group">
                            <span class="absolute w-0 h-0 transition-all duration-500 ease-out bg-white rounded-full group-hover:w-56 group-hover:h-56 opacity-10"></span>
                            <i data-lucide="lock" class="w-4 h-4 mr-2 relative z-10"></i> <span class="relative z-10">Konfirmasi & Bayar</span>
                        </button>

                        <p class="text-center text-xs text-gray-400 flex items-center justify-center">
                            <i data-lucide="shield-check" class="w-3.5 h-3.5 mr-1"></i> Pembayaran Aman 100%
                        </p>
                    </div>
                </div>

            </form>


        </div>
    </div>
@endsection