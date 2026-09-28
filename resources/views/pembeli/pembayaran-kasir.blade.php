{{-- ========================================================================================= --}}
{{-- [FITUR PEMBELI] INSTRUKSI PEMBAYARAN KASIR                                               --}}
{{-- Fungsi: Menampilkan instruksi bayar tunai di meja kasir toko & status pemesanan           --}}
{{-- ========================================================================================= --}}
@extends('layouts.pembeli')

@section('content')
<div class="min-h-screen bg-[#faf8f5] py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8">
            <h1 class="font-heading text-4xl font-bold text-[#6b3e1c] mb-2">Selesaikan Pembayaran</h1>
            <p class="text-[#7a6a5f]">Tunjukkan kode ini ke kasir untuk memproses pesanan Anda.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            
            <!-- Kolom Kiri -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Card Status -->
                <div class="bg-white rounded-2xl p-10 shadow-sm border border-gray-100 flex flex-col items-center justify-center text-center">
                    <div class="w-16 h-16 bg-[#f5e3d7] text-[#6b3e1c] rounded-full flex items-center justify-center mb-6">
                        <i data-lucide="loader" class="w-8 h-8 animate-spin"></i>
                    </div>
                    <h2 class="font-heading text-2xl font-bold text-[#332115] mb-2">Menunggu Konfirmasi Kasir</h2>
                    <p class="text-gray-500 mb-8 text-sm">Pesanan Anda dengan ID <span class="font-bold text-[#b37a54]">{{ $order->order_number }}</span> sedang dalam antrean. Kasir akan segera memprosesnya.</p>

                    <div class="inline-flex items-center gap-2 bg-[#f5e3d7] px-4 py-2 rounded-full text-sm font-semibold text-[#6b3e1c]">
                        <i data-lucide="clock" class="w-4 h-4"></i> Otomatis memuat ulang...
                    </div>
                </div>

                <!-- Instruksi Pembayaran -->
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
                    <h2 class="font-heading text-xl font-bold text-[#332115] mb-6">Instruksi</h2>
                    
                    <div class="space-y-6">
                        <div class="flex gap-4">
                            <div class="w-8 h-8 rounded-full bg-[#6b3e1c] text-white flex items-center justify-center font-bold shrink-0">1</div>
                            <div>
                                <h3 class="font-bold text-[#332115] text-sm mb-1">Tunggu di Meja Anda</h3>
                                <p class="text-sm text-gray-500 leading-relaxed">Kasir telah menerima pesanan Anda di sistem. Anda tidak perlu berdiri atau mendatangi kasir.</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="w-8 h-8 rounded-full bg-[#6b3e1c] text-white flex items-center justify-center font-bold shrink-0">2</div>
                            <div>
                                <h3 class="font-bold text-[#332115] text-sm mb-1">Kasir Memproses</h3>
                                <p class="text-sm text-gray-500 leading-relaxed">Ketika kasir menyetujui pesanan Anda, halaman ini akan otomatis berpindah.</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="w-8 h-8 rounded-full bg-[#6b3e1c] text-white flex items-center justify-center font-bold shrink-0">3</div>
                            <div>
                                <h3 class="font-bold text-[#332115] text-sm mb-1">Pesanan Diantar</h3>
                                <p class="text-sm text-gray-500 leading-relaxed">Nikmati roti dan minuman Anda yang akan segera diantarkan ke meja.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Ringkasan Pesanan (Kanan) -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 sticky top-8">
                    <h2 class="font-heading text-xl font-bold text-[#332115] mb-6 flex items-center border-b border-gray-100 pb-4">
                        <i data-lucide="receipt" class="w-5 h-5 mr-3 text-[#6b3e1c]"></i> Ringkasan Pesanan
                    </h2>
                    
                    <!-- Item List -->
                    <div class="space-y-4 mb-6">
                        @foreach($order->orderItems as $item)
                        <div class="flex items-center gap-4">
                            <img src="{{ $item->product && $item->product->image ? asset('storage/'.$item->product->image) : 'https://placehold.co/150x150?text=No+Image' }}" alt="Item" class="w-12 h-12 rounded-lg object-cover">
                            <div class="flex-1">
                                <h4 class="text-sm font-semibold text-[#332115]">{{ $item->product_name ?? ($item->product ? $item->product->name : 'Item') }}</h4>
                                <p class="text-xs text-gray-500">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                            </div>
                            <span class="text-sm font-semibold text-[#332115]">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                        </div>
                        @endforeach
                    </div>

                    <div class="border-t border-gray-100 pt-4 mb-6 space-y-3 text-sm text-[#7a6a5f]">
                        @php
                            $realSubtotal = $order->subtotal ?? ($order->total_amount - $order->shipping_cost);
                            $pajak = $realSubtotal * 0.08;
                            $layanan = $realSubtotal * 0.05;
                        @endphp
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span class="font-medium text-[#332115]">Rp {{ number_format($realSubtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Pajak (8%)</span>
                            <span class="font-medium text-[#332115]">Rp {{ number_format($pajak, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Layanan (5%)</span>
                            <span class="font-medium text-[#332115]">Rp {{ number_format($layanan, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="border-t border-gray-100 pt-6 mb-8">
                        <div class="flex justify-between items-center">
                            <span class="text-[#6b3e1c] font-bold text-lg">Total</span>
                            <span class="text-2xl font-bold text-[#6b3e1c]">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Halaman akan pindah otomatis -->
                    <a href="{{ route('dashboard') }}" class="block w-full bg-white border border-gray-300 hover:bg-gray-50 text-[#332115] text-sm font-semibold py-3.5 rounded-xl transition-colors text-center">
                        Kembali ke Dashboard
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
<script>
    // Polling status setiap 3 detik
    setInterval(() => {
        fetch(`/pesanan/{{ $order->order_number }}/status`)
            .then(response => response.json())
            .then(data => {
                if (data.status !== 'menunggu_pembayaran') {
                    window.location.href = "{{ route('pembeli.pembayaran.sukses', $order->order_number) }}";
                }
            })
            .catch(error => console.error('Error fetching status:', error));
    }, 3000);
</script>
@endsection
