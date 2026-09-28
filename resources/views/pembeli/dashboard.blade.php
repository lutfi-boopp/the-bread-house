{{-- ========================================================================================= --}}
{{-- [FITUR PEMBELI] DASHBOARD & KATALOG ROTI UTAMA                                            --}}
{{-- Fungsi: Menampilkan promo banner, filter kategori, pencarian roti, & daftar katalog menu --}}
{{-- ========================================================================================= --}}
@extends('layouts.pembeli')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 relative">

        <!-- Premium Hero Section -->
        <div class="mb-16">
            <div class="bg-[#fbf9f4] rounded-[2rem] p-8 md:p-12 border border-[#f0e6d5] relative overflow-hidden flex flex-col-reverse lg:flex-row items-center gap-12">
                <!-- Decorative blur -->
                <div class="absolute -top-24 -right-24 w-96 h-96 bg-[#f5efe6] rounded-full blur-3xl opacity-60"></div>
                
                <div class="lg:w-1/2 relative z-10 space-y-6 text-center lg:text-left">
                    <span class="inline-block bg-white text-[#6b3e1c] text-xs font-bold px-4 py-2 rounded-full uppercase tracking-widest shadow-sm border border-[#e6dace]">
                        Rekomendasi Chef
                    </span>
                    <h1 class="font-heading text-4xl md:text-5xl lg:text-6xl font-bold text-[#332115] leading-[1.15]">
                        Classic Sourdough <span class="text-[#6b3e1c]">Loaf</span>
                    </h1>
                    <p class="text-[#7a6a5f] text-lg leading-relaxed max-w-lg mx-auto lg:mx-0">
                        Dibuat penuh cinta dengan ragi alami selama 48 jam untuk menghasilkan tekstur sempurna, rasa yang kaya, dan kerak yang renyah.
                    </p>
                    <div class="pt-4 flex flex-wrap gap-4 justify-center lg:justify-start">
                        <a href="#katalog" class="bg-[#6b3e1c] hover:bg-[#5a3315] text-white px-8 py-4 rounded-xl font-bold transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                            Pesan Sekarang
                        </a>
                    </div>
                    
                    <!-- Quick features -->
                    <div class="pt-8 flex items-center justify-center lg:justify-start gap-8 border-t border-[#e6dace]/60">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-[#6b3e1c] shadow-sm">
                                <i data-lucide="clock" class="w-5 h-5"></i>
                            </div>
                            <div class="text-left">
                                <p class="text-xs text-[#7a6a5f] font-semibold uppercase tracking-wider">Buka Setiap Hari</p>
                                <p class="text-sm text-[#332115] font-bold">08:00 - 20:00</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-[#6b3e1c] shadow-sm">
                                <i data-lucide="leaf" class="w-5 h-5"></i>
                            </div>
                            <div class="text-left">
                                <p class="text-xs text-[#7a6a5f] font-semibold uppercase tracking-wider">Kualitas</p>
                                <p class="text-sm text-[#332115] font-bold">100% Alami</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="lg:w-1/2 relative z-10 w-full h-[300px] lg:h-[450px]">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSxlSobhZe7e3MXy5mx-pKEHWJ0NBHlUTIiTWdZpL8_jDcHSfYR4L0GlaA&s=10" 
                         alt="Promo Sourdough" 
                         class="w-full h-full object-cover rounded-3xl shadow-2xl">
                </div>
            </div>
        </div>

        <!-- Category Section -->
        <div id="katalog" class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6 scroll-mt-24">
            <div>
                <h2 class="font-heading text-3xl font-bold text-[#332115] mb-2">Katalog Menu</h2>
                <p class="text-[#7a6a5f]">Pilih varian roti segar favorit Anda hari ini.</p>
            </div>
            
            <!-- Filter Pills -->
            <div id="filter-pills" class="flex space-x-3 overflow-x-auto hide-scrollbar pb-2">
                <a href="{{ route('dashboard') }}#katalog"
                    class="category-link whitespace-nowrap px-6 py-2.5 rounded-full {{ !$category ? 'bg-[#6b3e1c] text-white shadow-md' : 'bg-white text-[#7a6a5f] hover:bg-[#fbf9f4] hover:text-[#332115] border border-[#f0e6d5]' }} text-sm font-bold transition-all">
                    Semua Menu
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('dashboard', ['category' => $cat->slug]) }}#katalog"
                        class="category-link whitespace-nowrap px-6 py-2.5 rounded-full {{ $category == $cat->slug ? 'bg-[#6b3e1c] text-white shadow-md' : 'bg-white text-[#7a6a5f] hover:bg-[#fbf9f4] hover:text-[#332115] border border-[#f0e6d5]' }} text-sm font-bold transition-all">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Product Grid -->
        <div id="product-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8 mb-20 relative">
            @forelse($products as $product)
                <!-- Product Item -->
                <div class="bg-white rounded-3xl overflow-hidden shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.12)] border border-[#f0e6d5] group flex flex-col transition-all duration-300 transform hover:-translate-y-1 cursor-pointer"
                     onclick="openProductModal(this, event)"
                     data-id="{{ $product->id }}"
                     data-name="{{ $product->name }}"
                     data-desc="{{ $product->description }}"
                     data-price="{{ number_format($product->price, 0, ',', '.') }}"
                     data-image="{{ $product->image ? asset('storage/' . $product->image) : 'https://placehold.co/400x300?text=No+Image' }}"
                     data-stock="{{ $product->stock }}"
                     data-rating="{{ $product->rating ? number_format($product->rating, 1) : '' }}"
                     data-category="{{ $product->category->name ?? 'Roti' }}">
                    <div class="relative h-56 overflow-hidden">
                        <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://placehold.co/400x300?text=No+Image' }}"
                            alt="{{ $product->name }}"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        
                        <!-- Rating Badge -->
                        @if($product->rating)
                            <div class="absolute top-4 left-4 bg-white/95 backdrop-blur px-3 py-1.5 rounded-full text-xs font-bold text-[#332115] shadow-sm flex items-center gap-1.5">
                                <i data-lucide="star" class="w-3.5 h-3.5 fill-[#f59e0b] text-[#f59e0b]"></i> 
                                {{ number_format($product->rating, 1) }}
                            </div>
                        @endif
                    </div>
                    
                    <div class="p-6 flex flex-col flex-grow relative">
                        <h3 class="font-heading text-xl font-bold text-[#332115] mb-2 group-hover:text-[#6b3e1c] transition-colors">{{ $product->name }}</h3>
                        <p class="text-[#7a6a5f] text-sm mb-6 line-clamp-2 leading-relaxed">{{ $product->description }}</p>
                        
                        <div class="mt-auto flex items-end justify-between">
                            <div>
                                <span class="block text-[10px] uppercase tracking-wider text-[#7a6a5f] font-semibold mb-0.5">Harga</span>
                                <span class="font-bold text-xl text-[#6b3e1c]">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </span>
                            </div>

                            @if($product->stock > 0)
                                <form action="{{ route('pembeli.keranjang.store') }}" method="POST" class="add-to-cart-form m-0">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="w-12 h-12 rounded-full bg-[#fbf9f4] hover:bg-[#6b3e1c] text-[#6b3e1c] hover:text-white border border-[#e6dace] hover:border-[#6b3e1c] flex items-center justify-center transition-all group/btn relative overflow-hidden shadow-sm hover:shadow-md submit-btn">
                                        <span class="btn-text">
                                            <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                                        </span>
                                        <span class="btn-loader hidden absolute inset-0 flex items-center justify-center">
                                            <i data-lucide="loader-2" class="w-5 h-5 animate-spin"></i>
                                        </span>
                                    </button>
                                </form>
                            @else
                                <div class="px-4 py-2 bg-gray-100 text-gray-400 rounded-full font-bold text-xs text-center border border-gray-200 cursor-not-allowed h-[40px] flex items-center">
                                    Habis
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 flex flex-col items-center justify-center bg-white rounded-3xl border border-dashed border-[#e6dace]">
                    <div class="w-16 h-16 bg-[#fbf9f4] rounded-full flex items-center justify-center text-[#d5c3b1] mb-4">
                        <i data-lucide="search-x" class="w-8 h-8"></i>
                    </div>
                    <h3 class="font-heading text-xl font-bold text-[#332115] mb-2">Belum Ada Roti</h3>
                    <p class="text-[#7a6a5f]">Kategori ini sedang kosong atau belum ada produk.</p>
                </div>
            @endforelse
        </div>

        <!-- Floating Action Bar (Cart Summary) -->
        <div id="cart-summary-container">
            @if(isset($cartItems) && $cartItems->count() > 0)
                <div class="fixed bottom-6 right-6 z-40">
                    <div class="bg-[#332115] text-white p-2 rounded-full shadow-2xl flex items-center space-x-2 border border-white/10 backdrop-blur-md pr-6">
                        <div class="w-12 h-12 bg-[#6b3e1c] rounded-full flex items-center justify-center relative shadow-inner">
                            <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                            <span class="absolute -top-1 -right-1 bg-white text-[#6b3e1c] text-[10px] font-bold w-5 h-5 rounded-full flex items-center justify-center shadow-sm">
                                {{ $cartItems->sum('quantity') }}
                            </span>
                        </div>
                        <div class="px-3">
                            <p class="text-[10px] text-white/60 font-semibold uppercase tracking-wider">Total Belanja</p>
                            <p class="font-bold text-base leading-tight">Rp {{ number_format($cartTotal, 0, ',', '.') }}</p>
                        </div>
                        <a href="{{ route('pembeli.keranjang') }}"
                            class="bg-white text-[#332115] hover:bg-[#fbf9f4] font-bold py-2.5 px-6 rounded-full text-sm transition-colors shadow-sm ml-2">
                            Bayar
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Product Detail Modal -->
    <div id="product-modal" class="fixed inset-0 z-[100] hidden items-center justify-center">
        <!-- Backdrop -->
        <div id="modal-backdrop" class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity duration-300 opacity-0" onclick="closeProductModal()"></div>
        
        <!-- Modal Content -->
        <div id="modal-content" class="bg-white rounded-3xl w-full max-w-3xl mx-4 relative z-10 overflow-hidden shadow-2xl transform transition-all duration-300 scale-95 opacity-0 flex flex-col md:flex-row max-h-[85vh]">
            <!-- Close Button -->
            <button type="button" onclick="closeProductModal()" class="absolute top-4 right-4 z-20 w-8 h-8 bg-white/90 backdrop-blur rounded-full flex items-center justify-center text-[#332115] hover:bg-[#fbf9f4] hover:scale-110 transition-all shadow-md">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
            
            <!-- Image Side -->
            <div class="md:w-1/2 h-56 md:h-auto relative bg-[#fbf9f4] overflow-hidden group">
                <img id="modal-image" src="" alt="" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                <div id="modal-rating-badge" class="absolute top-4 left-4 bg-white/95 backdrop-blur px-3 py-1.5 rounded-full text-xs font-bold text-[#332115] shadow-sm flex items-center gap-1.5 hidden transform -translate-y-2 opacity-0 transition-all duration-500">
                    <i data-lucide="star" class="w-3.5 h-3.5 fill-[#f59e0b] text-[#f59e0b]"></i> 
                    <span id="modal-rating"></span>
                </div>
            </div>
            
            <!-- Detail Side -->
            <div class="md:w-1/2 p-6 md:p-8 flex flex-col overflow-y-auto bg-white">
                <span id="modal-category" class="inline-block text-[#6b3e1c] text-[10px] font-bold uppercase tracking-widest mb-2 px-2.5 py-1 bg-[#f5efe6] rounded-full w-max"></span>
                <h3 id="modal-name" class="font-heading text-2xl font-bold text-[#332115] mb-3 leading-tight"></h3>
                <div class="w-12 h-1 bg-[#e6dace] rounded-full mb-4"></div>
                
                <p id="modal-desc" class="text-[#7a6a5f] text-sm leading-relaxed mb-6 whitespace-pre-line flex-grow"></p>
                
                <div class="mt-auto pt-5 border-t border-[#f0e6d5]">
                    <div class="flex items-center justify-between mb-5">
                        <div>
                            <span class="block text-[10px] uppercase tracking-wider text-[#7a6a5f] font-semibold mb-1">Harga</span>
                            <span class="font-bold text-2xl text-[#6b3e1c]">Rp <span id="modal-price"></span></span>
                        </div>
                    </div>
                    
                    <!-- Form Tambah ke Keranjang -->
                    <form id="modal-cart-form" action="{{ route('pembeli.keranjang.store') }}" method="POST" class="m-0 hidden add-to-cart-form">
                        @csrf
                        <input type="hidden" name="product_id" id="modal-product-id" value="">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="w-full bg-[#6b3e1c] hover:bg-[#522d12] text-white py-3 rounded-xl font-bold transition-all duration-300 shadow-lg shadow-[#6b3e1c]/20 flex items-center justify-center gap-2 relative overflow-hidden submit-btn transform hover:-translate-y-0.5">
                            <span class="btn-text flex items-center gap-2 text-sm">
                                <i data-lucide="shopping-bag" class="w-4 h-4"></i>
                                Tambah ke Keranjang
                            </span>
                            <span class="btn-loader hidden absolute inset-0 flex items-center justify-center bg-[#522d12]">
                                <i data-lucide="loader-2" class="w-5 h-5 animate-spin"></i>
                            </span>
                        </button>
                    </form>
                    
                    <div id="modal-out-of-stock" class="hidden w-full bg-gray-100 text-gray-500 py-3 rounded-xl font-bold text-center border border-gray-200 cursor-not-allowed text-sm">
                        Produk Habis
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Inject CSS for loading state
            const style = document.createElement('style');
            style.innerHTML = `
            html {
                scroll-behavior: smooth;
            }
            .ajax-loading {
                opacity: 0.5;
                pointer-events: none;
                transition: opacity 0.1s ease;
            }
            @keyframes popBounce {
                0% { transform: scale(1); }
                40% { transform: scale(1.15); }
                60% { transform: scale(0.95); }
                80% { transform: scale(1.05); }
                100% { transform: scale(1); }
            }
            .animate-pop-bounce {
                animation: popBounce 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            }
            @keyframes slideUpFade {
                from { opacity: 0; transform: translateY(10px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .animate-slide-up {
                animation: slideUpFade 0.2s ease-out forwards;
            }
        `;
            document.head.appendChild(style);

            function updateContent(html) {
                const doc = new DOMParser().parseFromString(html, 'text/html');

                const filterPills = document.querySelector('#filter-pills');
                const newFilterPills = doc.querySelector('#filter-pills');
                if (filterPills && newFilterPills) filterPills.innerHTML = newFilterPills.innerHTML;

                const productGrid = document.querySelector('#product-grid');
                const newProductGrid = doc.querySelector('#product-grid');
                if (productGrid && newProductGrid) {
                    productGrid.innerHTML = newProductGrid.innerHTML;
                    
                    // Memutar ulang animasi saat grid diperbarui
                    productGrid.classList.remove('animate-slide-up');
                    void productGrid.offsetWidth; // Memicu reflow browser
                    productGrid.classList.add('animate-slide-up');
                }

                const cartSummary = document.querySelector('#cart-summary-container');
                const newCartSummary = doc.querySelector('#cart-summary-container');
                if (cartSummary && newCartSummary) {
                    cartSummary.innerHTML = newCartSummary.innerHTML;
                    // Add animation class to the newly injected widget
                    const widget = cartSummary.querySelector('.rounded-full.shadow-2xl');
                    if (widget) {
                        widget.classList.add('animate-pop-bounce');
                        // Remove class after animation finishes so it can be re-triggered later
                        setTimeout(() => widget.classList.remove('animate-pop-bounce'), 500);
                    }
                }

                const navbarCart = document.querySelector('#navbar-cart-link');
                const newNavbarCart = doc.querySelector('#navbar-cart-link');
                if (navbarCart && newNavbarCart) {
                    navbarCart.innerHTML = newNavbarCart.innerHTML;
                    // Also animate the navbar cart icon!
                    navbarCart.classList.add('animate-pop-bounce');
                    setTimeout(() => navbarCart.classList.remove('animate-pop-bounce'), 500);
                }

                // Re-initialize Lucide icons if the library is available
                if (typeof lucide !== 'undefined' && lucide.createIcons) {
                    lucide.createIcons();
                }
            }

            // Category click handler
            document.addEventListener('click', function (e) {
                const link = e.target.closest('.category-link');
                if (link) {
                    e.preventDefault();
                    const url = link.href;

                    document.querySelector('#product-grid').classList.add('ajax-loading');
                    document.querySelector('#filter-pills').classList.add('ajax-loading');

                    fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                        .then(res => res.text())
                        .then(html => {
                            updateContent(html);
                            history.pushState(null, '', url);

                            document.querySelector('#product-grid').classList.remove('ajax-loading');
                            document.querySelector('#filter-pills').classList.remove('ajax-loading');
                        });
                }
            });

            // Add to cart form handler
            document.addEventListener('submit', function (e) {
                const form = e.target.closest('.add-to-cart-form');
                if (form) {
                    e.preventDefault();

                    const btn = form.querySelector('.submit-btn');
                    const btnText = form.querySelector('.btn-text');
                    const btnLoader = form.querySelector('.btn-loader');

                    if (btnText && btnLoader) {
                        btnText.classList.add('hidden');
                        btnLoader.classList.remove('hidden');
                    }

                    const url = form.action;
                    const formData = new FormData(form);

                    fetch(url, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                        .then(res => res.text())
                        .then(html => {
                            updateContent(html);
                            // If modal is open, close it after adding to cart
                            closeProductModal();
                        })
                        .finally(() => {
                            if (btnText && btnLoader) {
                                btnText.classList.remove('hidden');
                                btnLoader.classList.add('hidden');
                            }
                        });
                }
            });
        });

        // Modal Functions
        function openProductModal(el, event) {
            // Prevent modal if clicking on the add-to-cart form inside the card
            if (event.target.closest('.add-to-cart-form')) {
                return;
            }
            
            const modal = document.getElementById('product-modal');
            const backdrop = document.getElementById('modal-backdrop');
            const content = document.getElementById('modal-content');
            
            // Populate data
            document.getElementById('modal-image').src = el.dataset.image;
            document.getElementById('modal-image').alt = el.dataset.name;
            document.getElementById('modal-name').textContent = el.dataset.name;
            document.getElementById('modal-desc').textContent = el.dataset.desc;
            document.getElementById('modal-price').textContent = el.dataset.price;
            document.getElementById('modal-category').textContent = el.dataset.category;
            
            // Rating
            const ratingBadge = document.getElementById('modal-rating-badge');
            if (el.dataset.rating) {
                document.getElementById('modal-rating').textContent = el.dataset.rating;
                ratingBadge.classList.remove('hidden');
                setTimeout(() => {
                    ratingBadge.classList.remove('-translate-y-2', 'opacity-0');
                    ratingBadge.classList.add('translate-y-0', 'opacity-100');
                }, 100);
            } else {
                ratingBadge.classList.add('hidden');
            }
            
            // Buttons
            const stock = parseInt(el.dataset.stock);
            const cartForm = document.getElementById('modal-cart-form');
            const outOfStock = document.getElementById('modal-out-of-stock');
            
            if (stock > 0) {
                document.getElementById('modal-product-id').value = el.dataset.id;
                cartForm.classList.remove('hidden');
                outOfStock.classList.add('hidden');
            } else {
                cartForm.classList.add('hidden');
                outOfStock.classList.remove('hidden');
            }
            
            // Show modal
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
            
            // Trigger animation
            setTimeout(() => {
                backdrop.classList.remove('opacity-0');
                backdrop.classList.add('opacity-100');
                
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);
            
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        }
        
        function closeProductModal() {
            const backdrop = document.getElementById('modal-backdrop');
            const content = document.getElementById('modal-content');
            
            backdrop.classList.remove('opacity-100');
            backdrop.classList.add('opacity-0');
            
            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                const modal = document.getElementById('product-modal');
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.style.overflow = '';
            }, 300); // match duration-300
        }
    </script>
@endsection