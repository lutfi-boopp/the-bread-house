{{-- ========================================================================================= --}}
{{-- [FITUR PEMBELI] PEMBAYARAN QRIS                                                           --}}
{{-- Fungsi: Menampilkan Kode QRIS e-wallet/m-banking & countdown timer batas waktu bayar     --}}
{{-- ========================================================================================= --}}
@extends('layouts.pembeli')

@section('content')
<div class="min-h-screen bg-[#faf8f5] py-12 flex items-center justify-center">
    <div class="max-w-md w-full px-4">
        
        <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 relative overflow-hidden">
            <!-- Decorative gradient top right -->
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-gradient-to-br from-[#f5e3d7] to-white rounded-full opacity-50 blur-2xl"></div>
            <!-- Decorative gradient bottom left -->
            <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-gradient-to-tr from-[#f5e3d7] to-white rounded-full opacity-50 blur-2xl"></div>
            
            <div class="relative z-10 flex flex-col items-center">
                <h1 class="font-heading text-2xl font-bold text-[#6b3e1c] mb-2 text-center">Pembayaran QRIS</h1>
                <p class="text-sm text-[#7a6a5f] text-center mb-6">Selesaikan pesanan The Bread House Anda</p>
                
                <hr class="w-full border-t border-gray-200 mb-8">
                
                <div class="bg-white p-3 border border-gray-200 rounded-2xl shadow-sm mb-4">
                    <!-- Gunakan url simulasi sebagai konten QR Code -->
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data={{ urlencode(route('pembeli.pembayaran.simulate', $order->order_number)) }}" alt="QR Code QRIS" class="w-48 h-48">
                </div>
                
                <a href="{{ route('pembeli.pembayaran.simulate', $order->order_number) }}" target="_blank" class="text-[10px] text-gray-400 hover:text-[#6b3e1c] underline mb-6 inline-block">
                    [Testing] Simulasi Klik URL QRIS (Jika tidak pakai scan HP)
                </a>
                
                <h2 class="font-heading text-2xl font-bold text-[#332115] mb-1">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</h2>
                <p class="text-xs text-gray-500 mb-8">Order {{ $order->order_number }}</p>
                
                <div class="w-full bg-[#fbf9f8] border border-gray-200 rounded-xl p-5 mb-8">
                    <div class="flex items-center gap-2 mb-3">
                        <i data-lucide="info" class="w-4 h-4 text-[#6b3e1c] fill-[#6b3e1c]/20"></i>
                        <h3 class="text-sm font-bold text-[#332115]">Instruksi Pembayaran</h3>
                    </div>
                    <ul class="space-y-2 text-sm text-gray-600 list-none pl-1">
                        <li class="flex items-start gap-2"><span class="text-gray-300">•</span> Buka aplikasi perbankan atau e-wallet Anda.</li>
                        <li class="flex items-start gap-2"><span class="text-gray-300">•</span> Pilih fitur Scan QR.</li>
                        <li class="flex items-start gap-2"><span class="text-gray-300">•</span> Pindai kode QRIS di atas.</li>
                        <li class="flex items-start gap-2"><span class="text-gray-300">•</span> Pastikan nama merchant adalah <strong class="font-bold text-[#332115]">The Bread House</strong>.</li>
                        <li class="flex items-start gap-2"><span class="text-gray-300">•</span> Masukkan nominal Rp {{ number_format($order->total_amount, 0, ',', '.') }}.</li>
                        <li class="flex items-start gap-2"><span class="text-gray-300">•</span> Konfirmasi pembayaran Anda.</li>
                    </ul>
                </div>
                
                <div class="flex items-center justify-center gap-3 bg-[#fff9f0] border border-[#f5e3d7] text-[#6b3e1c] text-sm font-bold w-full py-4 rounded-xl mb-4">
                    <i data-lucide="loader-2" class="w-5 h-5 animate-spin"></i>
                    Menunggu Pembayaran Anda...
                </div>

                <a href="{{ route('dashboard') }}" class="block w-full bg-white border border-gray-300 hover:bg-gray-50 text-[#332115] text-sm font-semibold py-3.5 rounded-xl transition-colors text-center mb-4">
                    Kembali ke Dashboard
                </a>
                
                <p class="text-[11px] text-gray-400 text-center">Kode berlaku selama <span id="countdown">15:00</span></p>
            </div>
        </div>

    </div>
</div>
<script>
    let timeInSecs = 15 * 60;
    const ticker = document.getElementById("countdown");

    function updateTimer() {
        let mins = Math.floor(timeInSecs / 60);
        let secs = timeInSecs % 60;
        if (secs < 10) secs = "0" + secs;
        
        ticker.innerText = mins + ":" + secs;
        
        if (timeInSecs > 0) {
            timeInSecs--;
        } else {
            ticker.innerText = "Kadaluarsa";
        }
    }
    
    updateTimer();
    setInterval(updateTimer, 1000);

    // [FITUR TESTING] AJAX Polling: Cek status pesanan setiap 3 detik
    function checkPaymentStatus() {
        fetch("{{ route('pembeli.pesanan.status', $order->order_number) }}")
            .then(response => response.json())
            .then(data => {
                if (data.status === 'diproses' || data.status === 'selesai') {
                    // Jika status sudah berubah dari simulasi scan/kasir, otomatis arahkan ke sukses
                    window.location.href = "{{ route('pembeli.pembayaran.sukses', $order->order_number) }}";
                }
            })
            .catch(error => console.error('Error polling status:', error));
    }

    // Jalankan polling setiap 3 detik (3000 ms)
    setInterval(checkPaymentStatus, 3000);
</script>
@endsection
