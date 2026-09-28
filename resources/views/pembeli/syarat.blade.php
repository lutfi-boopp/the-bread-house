@extends('layouts.pembeli')
@section('content')
<!-- Hero -->
<div class="bg-[#fbf9f4] border-b border-[#e6dace] py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="font-heading text-4xl font-bold text-[#332115] mb-4">Syarat & Ketentuan</h1>
        <p class="text-[#7a6a5f]">Pembaruan Terakhir: {{ date('d F Y') }}</p>
    </div>
</div>

<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="prose prose-lg prose-headings:font-heading prose-headings:text-[#332115] prose-p:text-[#7a6a5f] prose-a:text-[#6b3e1c] max-w-none">
        
        <p class="lead text-xl text-[#332115] mb-10">Selamat datang di The Bread House. Harap membaca dokumen ini dengan saksama karena penggunaan layanan kami menandakan persetujuan Anda terhadap aturan main berikut.</p>
        
        <div class="space-y-12">
            <section>
                <h3 class="text-2xl font-bold border-b border-[#e6dace] pb-3 mb-6">1. Pemesanan dan Transaksi</h3>
                <p>Harga yang tertera pada katalog produk di situs kami sudah final, namun dapat berubah sewaktu-waktu sesuai dengan fluktuasi harga bahan baku. Semua pesanan yang telah dikonfirmasi dan dibayarkan (baik melalui QRIS maupun janji bayar di kasir) tidak dapat dibatalkan secara sepihak oleh pelanggan.</p>
            </section>

            <section>
                <h3 class="text-2xl font-bold border-b border-[#e6dace] pb-3 mb-6">2. Standar Visual Produk</h3>
                <p>Sebagai toko roti artisanal yang memproduksi roti dengan tangan (handmade), bentuk, ukuran minor, dan warna kerak roti mungkin bervariasi setiap harinya. Gambar produk di dalam website difungsikan sebagai representasi visual dan ilustrasi, sehingga toleransi perbedaan kecil dengan produk asli adalah hal yang wajar.</p>
            </section>
            
            <section>
                <h3 class="text-2xl font-bold border-b border-[#e6dace] pb-3 mb-6">3. Ketersediaan Bahan Baku</h3>
                <p>Kami sangat memprioritaskan kesegaran. Apabila bahan baku untuk produk yang Anda pesan mendadak habis atau kualitasnya tidak memenuhi standar, kami berhak menghubungi Anda untuk menawarkan opsi penggantian dengan produk sejenis atau memberikan pengembalian dana 100%.</p>
            </section>
        </div>
        
    </div>
</div>
@endsection
