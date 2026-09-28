@extends('layouts.pembeli')
@section('content')
<!-- Hero -->
<div class="bg-[#fbf9f4] border-b border-[#e6dace] py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="font-heading text-4xl font-bold text-[#332115] mb-4">Kebijakan Privasi</h1>
        <p class="text-[#7a6a5f]">Pembaruan Terakhir: {{ date('d F Y') }}</p>
    </div>
</div>

<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="prose prose-lg prose-headings:font-heading prose-headings:text-[#332115] prose-p:text-[#7a6a5f] prose-a:text-[#6b3e1c] max-w-none">
        
        <p class="lead text-xl text-[#332115] mb-10">Kepercayaan Anda adalah prioritas kami. The Bread House berkomitmen penuh untuk melindungi informasi pribadi Anda dengan standar keamanan tertinggi.</p>
        
        <div class="space-y-12">
            <section>
                <h3 class="text-2xl font-bold border-b border-[#e6dace] pb-3 mb-6">1. Informasi yang Kami Kumpulkan</h3>
                <p>Saat Anda membuat akun, melakukan pemesanan, atau menghubungi layanan pelanggan kami, kami akan mengumpulkan informasi dasar yang mencakup Nama Lengkap, Alamat Email, Nomor Telepon, dan riwayat pesanan Anda.</p>
            </section>

            <section>
                <h3 class="text-2xl font-bold border-b border-[#e6dace] pb-3 mb-6">2. Bagaimana Kami Menggunakan Informasi Anda</h3>
                <p>Data pribadi Anda secara eksklusif hanya digunakan untuk:</p>
                <ul class="list-disc pl-6 mt-4 space-y-2 text-[#7a6a5f]">
                    <li>Memproses dan mengkonfirmasi pesanan roti Anda.</li>
                    <li>Mengirimkan informasi status transaksi atau perubahan penting layanan.</li>
                    <li>Merespons pertanyaan, masukan, atau keluhan Anda kepada tim layanan pelanggan.</li>
                </ul>
            </section>
            
            <section>
                <h3 class="text-2xl font-bold border-b border-[#e6dace] pb-3 mb-6">3. Jaminan Anti-Spam dan Berbagi Data</h3>
                <p>Kami sangat menentang praktik jual-beli data. Kami <strong>tidak akan pernah</strong> menjual, menyewakan, atau menukar data pribadi Anda kepada pihak ketiga mana pun. Akses terhadap data Anda sangat dibatasi dan hanya diberikan kepada staf toko yang berwenang demi kelancaran operasional.</p>
            </section>
        </div>
        
    </div>
</div>
@endsection
