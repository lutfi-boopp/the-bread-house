{{-- ========================================================================================= --}}
{{-- [FITUR ADMIN] MANAJEMEN STOK INVENTARIS ROTI --}}
{{-- Fungsi: Memantau jumlah persediaan stok roti & memperbarui jumlah stok secara langsung --}}
{{-- ========================================================================================= --}}
@extends('layouts.admin')

@section('content')
    <div class="w-full relative">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end mb-8 gap-4">
            <div>
                <h2 class="font-heading text-4xl font-bold text-[#693e1b] mb-1">Kelola Stok</h2>
                <p class="text-sm text-[#8c7a6b] mt-2">Pantau dan perbarui stok produk roti Anda secara real-time dengan
                    cepat.</p>
            </div>
        </div>

        <!-- Alert Success -->
        @if(session('success'))
            <div id="success-alert"
                class="bg-[#e6f5eb] border border-[#1d8a43] text-[#1d8a43] px-4 py-4 rounded-2xl relative mb-8 shadow-sm flex items-center gap-3 transform transition-all duration-300">
                <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center shrink-0">
                    <i data-lucide="check" class="w-5 h-5"></i>
                </div>
                <span class="block sm:inline font-bold">{{ session('success') }}</span>
                <button onclick="document.getElementById('success-alert').style.display='none'"
                    class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
        @endif

        <!-- Product Stock Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($products as $product)
                @php
                    $isLow = $product->stock < 15;
                    $isCritical = $product->stock < 5;
                    $stockStatusColor = $isCritical ? 'bg-[#c42b2b]' : ($isLow ? 'bg-[#b86b16]' : 'bg-[#1d8a43]');
                    $stockStatusBg = $isCritical ? 'bg-[#fae8e8]' : ($isLow ? 'bg-[#fdf0dc]' : 'bg-[#e6f5eb]');
                    $stockStatusText = $isCritical ? 'KRITIS' : ($isLow ? 'MENIPIS' : 'AMAN');

                    // Tentukan icon dinamis jika tidak ada gambar
                    $catName = strtolower($product->category->name ?? '');
                    $iconName = 'wheat'; // Default icon
                    if (str_contains($catName, 'pastry') || str_contains($catName, 'croissant'))
                        $iconName = 'croissant';
                    elseif (str_contains($catName, 'cake') || str_contains($catName, 'kue') || str_contains($catName, 'bolu'))
                        $iconName = 'cake-slice';
                    elseif (str_contains($catName, 'minuman') || str_contains($catName, 'kopi') || str_contains($catName, 'drink'))
                        $iconName = 'coffee';
                    elseif (str_contains($catName, 'pizza') || str_contains($catName, 'savory'))
                        $iconName = 'pizza';
                    elseif (str_contains($catName, 'donat') || str_contains($catName, 'donut'))
                        $iconName = 'circle';

                    // Warna dinamis untuk placeholder
                    $colors = [
                        ['bg' => 'bg-[#fdf0dc]', 'text' => 'text-[#b86b16]'],
                        ['bg' => 'bg-[#fae8e8]', 'text' => 'text-[#c42b2b]'],
                        ['bg' => 'bg-[#e6f5eb]', 'text' => 'text-[#1d8a43]'],
                        ['bg' => 'bg-[#e8f0fe]', 'text' => 'text-[#1a73e8]'],
                        ['bg' => 'bg-[#f3e5f5]', 'text' => 'text-[#8e24aa]'],
                    ];
                    $color = $colors[$product->id % count($colors)];
                @endphp

                <div
                    class="bg-white border {{ $isCritical ? 'border-[#fae8e8] shadow-[0_4px_20px_-5px_rgba(196,43,43,0.15)]' : 'border-[#ece3d4] hover:shadow-md' }} rounded-3xl overflow-hidden flex flex-col transition-all duration-300">
                    <!-- Image / Icon Header -->
                    <div class="relative h-40 w-full bg-[#f9f5f0] flex items-center justify-center overflow-hidden">
                        @if($product->image)
                            <img src="{{ Storage::url($product->image) }}"
                                class="w-full h-full object-cover transition-transform duration-500 hover:scale-105"
                                alt="{{ $product->name }}">
                        @else
                            <div class="w-full h-full {{ $color['bg'] }} flex items-center justify-center">
                                <i data-lucide="{{ $iconName }}" class="w-16 h-16 {{ $color['text'] }} opacity-80"></i>
                            </div>
                        @endif

                        <!-- Status Badge -->
                        <div
                            class="absolute top-3 left-3 {{ $stockStatusBg }} text-[10px] font-bold px-2.5 py-1 rounded-lg flex items-center shadow-sm">
                            <span class="w-1.5 h-1.5 rounded-full {{ $stockStatusColor }} mr-1.5"></span>
                            <span class="{{ str_replace('bg-', 'text-', $stockStatusColor) }}">{{ $stockStatusText }}</span>
                        </div>

                        @if($product->stock == 0)
                            <div class="absolute inset-0 bg-white/60 backdrop-blur-[2px] flex items-center justify-center z-10">
                                <span
                                    class="bg-[#c42b2b] text-white font-bold px-4 py-1.5 rounded-xl shadow-lg transform -rotate-12 tracking-widest uppercase">Habis</span>
                            </div>
                        @endif
                    </div>

                    <div class="p-5 flex-1 flex flex-col">
                        <div class="mb-4 text-center">
                            <h3 class="font-heading text-lg font-bold text-[#2d251d] mb-1 line-clamp-1"
                                title="{{ $product->name }}">{{ $product->name }}</h3>
                            <p class="text-[10px] font-bold text-[#8c7a6b] uppercase tracking-wider">
                                {{ $product->category->name ?? 'Tanpa Kategori' }}</p>
                        </div>

                        <div class="mt-auto pt-4 border-t border-dashed border-[#ece3d4]">
                            <p class="text-xs text-center text-[#8c7a6b] font-medium mb-3">Penyesuaian Stok Cepat</p>

                            <form action="{{ route('admin.stok.update', $product->id) }}" method="POST"
                                class="flex flex-col gap-3 relative z-20">
                                @csrf
                                <div
                                    class="flex items-center justify-between bg-[#f9f5f0] rounded-2xl border border-[#ece3d4] p-1.5">
                                    <button type="button"
                                        class="w-10 h-10 flex items-center justify-center text-[#c42b2b] bg-white hover:bg-[#fae8e8] rounded-xl shadow-sm transition-colors"
                                        onclick="decrementStock({{ $product->id }})">
                                        <i data-lucide="minus" class="w-5 h-5"></i>
                                    </button>

                                    <input type="number" name="stock" id="stock_{{ $product->id }}"
                                        value="{{ $product->stock }}"
                                        class="w-full text-center bg-transparent border-none text-xl font-bold text-[#472c1b] focus:ring-0 p-0 hide-arrows"
                                        min="0" required>

                                    <button type="button"
                                        class="w-10 h-10 flex items-center justify-center text-[#1d8a43] bg-white hover:bg-[#e6f5eb] rounded-xl shadow-sm transition-colors"
                                        onclick="incrementStock({{ $product->id }})">
                                        <i data-lucide="plus" class="w-5 h-5"></i>
                                    </button>
                                </div>

                                <button type="submit"
                                    class="w-full bg-white border-2 border-[#693e1b] hover:bg-[#693e1b] hover:text-white text-[#693e1b] py-2.5 rounded-xl text-sm font-bold transition-colors flex items-center justify-center group">
                                    <i data-lucide="save" class="w-4 h-4 mr-2 group-hover:scale-110 transition-transform"></i>
                                    Simpan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 text-center bg-white border border-dashed border-[#ece3d4] rounded-3xl">
                    <div
                        class="w-20 h-20 bg-[#f9f5f0] rounded-full flex items-center justify-center mx-auto mb-5 text-[#8c7a6b]">
                        <i data-lucide="boxes" class="w-10 h-10"></i>
                    </div>
                    <h4 class="font-heading text-2xl font-bold text-[#472c1b] mb-2">Belum Ada Roti</h4>
                    <p class="text-base text-[#8c7a6b] mb-6">Tambahkan produk roti di menu Kelola Produk terlebih dahulu.</p>
                    <a href="{{ route('admin.menu') }}"
                        class="inline-flex items-center bg-[#693e1b] hover:bg-[#522d12] text-white px-6 py-3 rounded-xl text-sm font-bold transition-colors shadow-sm">
                        Ke Menu Roti <i data-lucide="arrow-right" class="w-4 h-4 ml-2"></i>
                    </a>
                </div>
            @endforelse
        </div>
    </div>

    <style>
        /* Hide number input arrows */
        .hide-arrows::-webkit-inner-spin-button,
        .hide-arrows::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .hide-arrows {
            -moz-appearance: textfield;
        }
    </style>

    <script>
        function incrementStock(id) {
            const input = document.getElementById('stock_' + id);
            input.value = parseInt(input.value) + 1;
            // Optionally add a subtle scale animation to the input
            input.style.transform = 'scale(1.1)';
            setTimeout(() => input.style.transform = 'scale(1)', 150);
        }

        function decrementStock(id) {
            const input = document.getElementById('stock_' + id);
            if (parseInt(input.value) > 0) {
                input.value = parseInt(input.value) - 1;
                // Optionally add a subtle scale animation to the input
                input.style.transform = 'scale(0.9)';
                setTimeout(() => input.style.transform = 'scale(1)', 150);
            }
        }

        // Auto-hide success alert after 3 seconds
        setTimeout(function () {
            const alert = document.getElementById('success-alert');
            if (alert) {
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-10px)';
                setTimeout(() => alert.style.display = 'none', 300);
            }
        }, 3000);
    </script>
@endsection