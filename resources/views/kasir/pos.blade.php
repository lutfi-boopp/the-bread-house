{{-- ========================================================================================= --}}
{{-- [FITUR KASIR] POINT OF SALE (POS) TRANSAKSI TOKO LANGSUNG --}}
{{-- Fungsi: Antarmuka kasir untuk melayani pembeli langsung di toko & hitung kembalian tunai --}}
{{-- ========================================================================================= --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>POS Kasir - The Bread House</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #faf9f6;
        }

        .font-heading {
            font-family: 'Playfair Display', serif;
        }

        /* Custom scrollbar for POS items */
        .pos-scroll::-webkit-scrollbar {
            width: 6px;
        }

        .pos-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        .pos-scroll::-webkit-scrollbar-thumb {
            background: #e6dace;
            border-radius: 10px;
        }

        .pos-scroll::-webkit-scrollbar-thumb:hover {
            background: #b37a54;
        }

        /* Receipt zigzag top */
        .receipt-top {
            position: relative;
            background: #fff;
            padding-top: 20px;
        }

        .receipt-top::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 10px;
            background-image: radial-gradient(circle at 10px 0, transparent 11px, #fff 12px);
            background-size: 20px 20px;
            background-repeat: repeat-x;
            transform: translateY(-10px);
        }

        /* Smooth Cart item exit/enter animation */
        .cart-item-enter {
            animation: slideInRight 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
    </style>
</head>

<body class="flex h-screen overflow-hidden text-gray-800 antialiased selection:bg-[#f5e3d7] selection:text-[#6b3e1c]">

    <!-- Sidebar -->
    <aside
        class="w-24 lg:w-64 flex-shrink-0 bg-white border-r border-gray-100 flex flex-col justify-between z-20 shadow-[4px_0_24px_rgba(0,0,0,0.02)] transition-all duration-300 relative">
        <!-- Decoration -->
        <div
            class="absolute top-0 left-0 w-full h-32 bg-gradient-to-b from-[#fdf5eb] to-transparent opacity-50 pointer-events-none">
        </div>

        <div>
            <div class="p-6 flex items-center gap-4 justify-center lg:justify-start relative z-10">
                <div
                    class="w-12 h-12 bg-gradient-to-br from-[#6b3e1c] to-[#b37a54] rounded-2xl flex items-center justify-center text-white shrink-0 shadow-lg shadow-[#6b3e1c]/20 transform rotate-3 transition-transform hover:rotate-0">
                    <i data-lucide="store" class="w-6 h-6"></i>
                </div>
                <div class="hidden lg:block">
                    <h1 class="font-heading text-2xl font-bold text-[#332115] leading-tight tracking-tight">The Bread House
                    </h1>
                    <p class="text-[10px] uppercase tracking-widest text-[#b37a54] font-bold mt-0.5">Terminal Kasir</p>
                </div>
            </div>

            <div class="px-4 lg:px-6 mb-8 mt-2">
                <a href="{{ route('kasir.pos') }}"
                    class="w-full bg-[#6b3e1c] hover:bg-[#522e15] text-white py-3 lg:py-3.5 px-0 lg:px-4 rounded-xl flex items-center justify-center gap-2.5 font-bold text-sm transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5 group">
                    <i data-lucide="plus-circle"
                        class="w-5 h-5 group-hover:rotate-90 transition-transform duration-300"></i>
                    <span class="hidden lg:inline">Pesanan Cepat</span>
                </a>
            </div>

            <nav class="px-3 lg:px-4 space-y-1.5 relative z-10">
                <a href="{{ route('kasir.dashboard') }}"
                    class="text-gray-500 hover:bg-[#fdf5eb] hover:text-[#6b3e1c] px-3 lg:px-4 py-3 rounded-xl flex items-center justify-center lg:justify-start gap-3 font-semibold text-sm transition-colors group">
                    <i data-lucide="layout-dashboard" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                    <span class="hidden lg:inline">Dasbor Utama</span>
                </a>
                <a href="{{ route('kasir.orders') }}"
                    class="text-gray-500 hover:bg-[#fdf5eb] hover:text-[#6b3e1c] px-3 lg:px-4 py-3 rounded-xl flex items-center justify-center lg:justify-start gap-3 font-semibold text-sm transition-colors group">
                    <i data-lucide="clipboard-list" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                    <span class="hidden lg:inline">Pesanan Masuk</span>
                </a>
                <a href="{{ route('kasir.history') }}"
                    class="text-gray-500 hover:bg-[#fdf5eb] hover:text-[#6b3e1c] px-3 lg:px-4 py-3 rounded-xl flex items-center justify-center lg:justify-start gap-3 font-semibold text-sm transition-colors group">
                    <i data-lucide="history" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                    <span class="hidden lg:inline">Riwayat Transaksi</span>
                </a>
            </nav>
        </div>

        <div class="p-3 lg:p-4 mb-2">
            <div class="bg-gray-50 rounded-2xl p-2 lg:p-3">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full text-red-500 hover:bg-white hover:shadow-sm px-2 py-2.5 rounded-xl flex items-center justify-center lg:justify-start gap-3 font-bold text-sm transition-all group">
                        <div class="bg-red-100 p-1.5 rounded-lg group-hover:bg-red-50 transition-colors">
                            <i data-lucide="log-out" class="w-4 h-4"></i>
                        </div>
                        <span class="hidden lg:inline">Keluar Sesi</span>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content POS -->
    <main class="flex-1 flex bg-[#faf8f5] h-full relative overflow-hidden">



        <!-- Products Section (Left) -->
        <div class="flex-1 flex flex-col h-full relative z-10">
            <!-- Header -->
            <div class="px-8 py-6 bg-transparent flex justify-between items-center z-10">
                <div>
                    <h2 class="font-heading text-3xl font-bold text-[#332115]">Katalog Menu</h2>
                    <p class="text-sm text-[#7a6a5f] mt-1 font-medium">Ketuk produk untuk menambahkan ke pesanan.</p>
                </div>
                <div class="relative group">
                    <input type="text" id="searchInput" placeholder="Cari menu favorit..."
                        class="pl-12 pr-6 py-3.5 bg-white border-2 border-transparent rounded-full shadow-sm text-sm focus:bg-white focus:border-[#b37a54] focus:ring-4 focus:ring-[#b37a54]/10 w-72 transition-all font-medium text-[#332115] placeholder-gray-400">
                    <i data-lucide="search"
                        class="w-5 h-5 text-gray-400 absolute left-4 top-1/2 -translate-y-1/2 group-focus-within:text-[#b37a54] transition-colors"></i>
                </div>
            </div>

            <!-- Product Grid -->
            <div class="flex-1 overflow-y-auto px-8 pb-8 pt-2 pos-scroll">
                <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-6" id="productGrid">
                    @foreach($products as $product)
                        <div class="bg-white rounded-[2rem] border-2 border-transparent overflow-hidden shadow-sm hover:shadow-xl hover:border-[#f5e3d7] hover:-translate-y-1.5 transition-all duration-300 cursor-pointer product-card flex flex-col h-full group relative"
                            onclick="addToCart({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }}, {{ $product->stock }})"
                            data-name="{{ strtolower($product->name) }}">

                            <!-- Image Container -->
                            <div class="aspect-[4/3] bg-[#f9f9f9] relative p-4 pb-0">
                                <div
                                    class="w-full h-full rounded-2xl overflow-hidden relative shadow-[0_8px_16px_rgba(0,0,0,0.04)]">
                                    <img src="{{ str_starts_with($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}"
                                        alt="{{ $product->name }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out">

                                    <!-- Stock Badge -->
                                    @if($product->stock <= 0)
                                        <div
                                            class="absolute inset-0 bg-white/60 backdrop-blur-[2px] flex items-center justify-center z-10">
                                            <span
                                                class="bg-red-500 text-white text-xs font-bold px-4 py-1.5 rounded-full shadow-lg shadow-red-500/30 tracking-wider">HABIS</span>
                                        </div>
                                    @elseif($product->stock <= 5)
                                        <div
                                            class="absolute top-3 right-3 bg-gradient-to-r from-orange-500 to-red-500 text-white text-[10px] font-bold px-3 py-1 rounded-full shadow-lg shadow-orange-500/30 z-10 animate-pulse">
                                            Sisa {{ $product->stock }}
                                        </div>
                                    @endif

                                    <!-- Hover Add Icon Overlay -->
                                    <div
                                        class="absolute inset-0 bg-black/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center z-0">
                                        <div
                                            class="w-10 h-10 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center text-[#6b3e1c] shadow-lg transform scale-50 group-hover:scale-100 transition-transform duration-300">
                                            <i data-lucide="plus" class="w-5 h-5"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-5 flex flex-col flex-1 justify-between bg-white relative z-10 rounded-b-[2rem]">
                                <h3
                                    class="font-bold text-[#332115] text-[15px] mb-2 leading-tight group-hover:text-[#6b3e1c] transition-colors">
                                    {{ $product->name }}</h3>
                                <div class="flex items-center justify-between mt-auto">
                                    <p class="font-extrabold text-[#b37a54] text-lg tracking-tight">Rp
                                        {{ number_format($product->price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Cart Section (Right) -->
        <div
            class="w-[420px] flex-shrink-0 bg-white shadow-[-15px_0_40px_rgba(107,62,28,0.06)] flex flex-col h-full z-20 border-l border-gray-100 relative">
            <!-- Order Header -->
            <div class="px-6 py-7 border-b border-gray-100 bg-white relative overflow-hidden">
                <!-- BG Decoration -->
                <div
                    class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-[#fdf5eb] to-transparent rounded-bl-full opacity-50">
                </div>

                <h2 class="font-heading text-2xl font-bold text-[#332115] flex items-center gap-4 relative z-10">
                    <i data-lucide="shopping-cart" class="w-6 h-6 text-[#b37a54]"></i>
                    Pesanan Saat Ini
                    <span id="cartItemCount"
                        class="bg-[#f5e3d7] text-[#6b3e1c] text-sm px-3 py-1 rounded-full font-bold ml-auto">0</span>
                </h2>

                <div class="mt-5 relative z-10 space-y-3">
                    <div>
                        <label class="block text-[11px] uppercase tracking-wider font-bold text-[#7a6a5f] mb-1.5">Nama Pemesan</label>
                        <div class="relative">
                            <i data-lucide="user" class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                            <input type="text" id="customerName" placeholder="Masukkan nama..." required
                                class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium focus:ring-2 focus:ring-[#b37a54]/20 focus:border-[#b37a54] focus:bg-white transition-all text-[#332115] placeholder-gray-400">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[11px] uppercase tracking-wider font-bold text-[#7a6a5f] mb-1.5">Email (Opsional - Untuk Struk)</label>
                        <div class="relative">
                            <i data-lucide="mail" class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                            <input type="email" id="customerEmail" placeholder="email@contoh.com"
                                class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium focus:ring-2 focus:ring-[#b37a54]/20 focus:border-[#b37a54] focus:bg-white transition-all text-[#332115] placeholder-gray-400">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cart Items List -->
            <div class="flex-1 overflow-y-auto p-2 pos-scroll relative bg-[#fcfcfc]">
                <!-- Empty State -->
                <div class="absolute inset-0 flex flex-col items-center justify-center text-center p-8 transition-opacity duration-300"
                    id="emptyCartMsg">
                    <div class="w-28 h-28 bg-[#fdf5eb] rounded-full flex items-center justify-center mb-6 shadow-inner">
                        <i data-lucide="shopping-bag" class="w-12 h-12 text-[#b37a54] opacity-50"></i>
                    </div>
                    <p class="text-lg font-heading font-bold text-[#332115]">Keranjang Kosong</p>
                    <p class="text-sm text-[#7a6a5f] mt-2 max-w-[200px] mx-auto leading-relaxed">Pilih menu dari katalog
                        di samping untuk memulai pesanan baru.</p>
                </div>

                <!-- Items Container -->
                <div id="cartItems" class="space-y-4 p-5"></div>
            </div>

            <!-- Receipt & Checkout Section -->
            <div
                class="bg-white receipt-top pt-6 pb-6 px-6 border-t border-dashed border-gray-300 shadow-[0_-10px_20px_rgba(0,0,0,0.02)] relative z-30">
                <div class="space-y-3 mb-5">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-[#7a6a5f] font-medium">Subtotal</span>
                        <span class="font-bold text-[#332115]" id="cartSubtotal">Rp 0</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-[#7a6a5f] font-medium">Pajak (8%)</span>
                        <span class="font-bold text-[#332115]" id="cartPajak">Rp 0</span>
                    </div>
                    <div class="flex justify-between items-center text-sm mt-1">
                        <span class="text-[#7a6a5f] font-medium">Layanan (5%)</span>
                        <span class="font-bold text-[#332115]" id="cartLayanan">Rp 0</span>
                    </div>
                    <div class="h-px w-full border-t border-dashed border-gray-200 my-2"></div>
                    <div class="flex justify-between items-center">
                        <span class="text-[#332115] font-bold text-lg">Total Pembayaran</span>
                        <span class="font-bold text-3xl text-[#6b3e1c] tracking-tight" id="cartTotal">Rp 0</span>
                    </div>
                </div>

                <div class="mb-5 p-4 bg-[#fbf9f4] rounded-2xl border border-[#f0e6d8]">
                    <label class="block text-xs uppercase tracking-wider font-bold text-[#b37a54] mb-2">Tunai
                        Diterima</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-bold">Rp</span>
                        <input type="number" id="amountPaid" placeholder="0"
                            class="w-full pl-11 pr-4 py-3.5 bg-white border-2 border-transparent rounded-xl text-xl font-bold focus:ring-4 focus:ring-[#b37a54]/20 focus:border-[#b37a54] transition-all text-[#332115] shadow-sm">
                    </div>
                    <div class="flex items-center gap-2 mt-2 hidden" id="amountError">
                        <i data-lucide="alert-circle" class="w-4 h-4 text-red-500"></i>
                        <p class="text-xs font-bold text-red-500">Nominal kurang dari total tagihan!</p>
                    </div>

                    <div class="flex justify-between items-center mt-3 pt-3 border-t border-[#f0e6d8] hidden"
                        id="changeDiv">
                        <span class="text-[#7a6a5f] text-sm font-bold uppercase tracking-wider">Kembalian</span>
                        <span class="font-bold text-xl text-green-600 bg-green-50 px-3 py-1 rounded-lg"
                            id="changeAmount">Rp 0</span>
                    </div>
                </div>

                <button id="checkoutBtn"
                    class="w-full bg-[#6b3e1c] hover:bg-[#522e15] text-white py-4 rounded-2xl font-bold text-lg transition-all flex items-center justify-center gap-3 shadow-lg shadow-[#6b3e1c]/30 hover:shadow-xl hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none disabled:shadow-none group relative overflow-hidden"
                    disabled>
                    <span
                        class="absolute w-0 h-0 transition-all duration-500 ease-out bg-white rounded-full group-hover:w-[150%] group-hover:h-[300%] opacity-10 pointer-events-none"></span>
                    <i data-lucide="check-circle-2" class="w-6 h-6 relative z-10"></i>
                    <span class="relative z-10">Proses Pembayaran</span>
                </button>
            </div>
        </div>
    </main>

    <!-- Modal Sukses -->
    <div id="successModal"
        class="fixed inset-0 bg-[#332115]/50 z-[100] hidden flex items-center justify-center backdrop-blur-sm transition-opacity duration-300 opacity-0">
        <div class="bg-white rounded-[2rem] p-10 max-w-sm w-full mx-4 shadow-2xl text-center transform scale-95 translate-y-8 opacity-0 transition-all duration-500 cubic-bezier(0.34, 1.56, 0.64, 1) relative overflow-hidden"
            id="successModalContent">

            <div class="absolute top-0 left-0 w-full h-32 bg-gradient-to-b from-green-50 to-transparent"></div>

            <div class="relative w-24 h-24 mx-auto mb-6 z-10">
                <div class="absolute inset-0 bg-green-200 rounded-full animate-ping opacity-60"></div>
                <div
                    class="relative w-full h-full bg-gradient-to-tr from-green-400 to-green-500 rounded-full flex items-center justify-center text-white shadow-xl shadow-green-500/30 border-4 border-white">
                    <i data-lucide="check" class="w-12 h-12"></i>
                </div>
            </div>

            <h3 class="font-heading text-3xl font-bold text-[#332115] mb-2 relative z-10">Transaksi Sukses!</h3>
            <p class="text-[#7a6a5f] text-sm mb-6 relative z-10">Pesanan telah berhasil dicatat ke dalam sistem.</p>

            <div class="bg-[#fcfcfc] rounded-2xl p-5 mb-8 border border-gray-100 relative z-10 shadow-inner">
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-1">Nomor Pesanan</p>
                <p class="font-bold text-xl text-[#332115] mb-4 bg-white py-2 rounded-xl border border-gray-50 shadow-sm"
                    id="successOrderId"></p>

                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-1">Uang Kembalian</p>
                <p class="font-bold text-3xl text-green-500" id="successChange"></p>
            </div>

            <button onclick="resetPOS()"
                class="w-full bg-[#6b3e1c] hover:bg-[#522e15] text-white font-bold py-4 rounded-xl transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5 relative z-10">
                Lanjut Pesanan Baru
            </button>
        </div>
    </div>

    <!-- Modal Error / Warning -->
    <div id="errorModal"
        class="fixed inset-0 bg-[#332115]/50 z-[100] hidden flex items-center justify-center backdrop-blur-sm transition-opacity duration-300 opacity-0">
        <div class="bg-white rounded-[2rem] p-10 max-w-sm w-full mx-4 shadow-2xl text-center transform scale-95 translate-y-8 opacity-0 transition-all duration-400 relative overflow-hidden"
            id="errorModalContent">

            <div class="absolute top-0 left-0 w-full h-32 bg-gradient-to-b from-red-50 to-transparent"></div>

            <div class="relative w-24 h-24 mx-auto mb-6 z-10">
                <div class="absolute inset-0 bg-red-200 rounded-full animate-ping opacity-60"
                    style="animation-duration: 1.5s;"></div>
                <div
                    class="relative w-full h-full bg-gradient-to-tr from-red-400 to-red-500 rounded-full flex items-center justify-center text-white shadow-xl shadow-red-500/30 border-4 border-white">
                    <i data-lucide="alert-triangle" class="w-12 h-12"></i>
                </div>
            </div>

            <h3 class="font-heading text-2xl font-bold text-[#332115] mb-3 relative z-10" id="errorModalTitle">
                Peringatan</h3>
            <div class="mb-8 relative z-10">
                <p class="text-[#7a6a5f] font-medium leading-relaxed bg-[#fcfcfc] p-4 rounded-xl border border-gray-100"
                    id="errorModalMessage"></p>
            </div>

            <button onclick="closeErrorModal()"
                class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-4 rounded-xl transition-all shadow-sm transform hover:-translate-y-0.5 relative z-10">
                Mengerti
            </button>
        </div>
    </div>

    <script>
        lucide.createIcons();

        let cart = [];
        let total = 0;

        // Search Product functionality
        document.getElementById('searchInput').addEventListener('input', function (e) {
            const term = e.target.value.toLowerCase();
            const cards = document.querySelectorAll('.product-card');
            cards.forEach(card => {
                if (card.dataset.name.includes(term)) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        });

        function addToCart(id, name, price, maxStock) {
            if (maxStock <= 0) return; // Out of stock

            const existingItem = cart.find(item => item.id === id);

            if (existingItem) {
                if (existingItem.quantity < maxStock) {
                    existingItem.quantity++;
                } else {
                    showErrorModal('Stok produk ini sudah mencapai batas maksimal!', 'Stok Habis');
                }
            } else {
                cart.push({ id, name, price, quantity: 1, maxStock });
            }

            renderCart();
        }

        function updateQuantity(id, change) {
            const index = cart.findIndex(item => item.id === id);
            if (index !== -1) {
                const item = cart[index];
                const newQty = item.quantity + change;

                if (newQty > 0 && newQty <= item.maxStock) {
                    item.quantity = newQty;
                } else if (newQty === 0) {
                    cart.splice(index, 1);
                } else if (newQty > item.maxStock) {
                    showErrorModal('Stok produk ini sudah mencapai batas maksimal!', 'Stok Habis');
                }
                renderCart();
            }
        }

        function renderCart() {
            const cartItems = document.getElementById('cartItems');
            const emptyMsg = document.getElementById('emptyCartMsg');
            const checkoutBtn = document.getElementById('checkoutBtn');
            const cartItemCount = document.getElementById('cartItemCount');

            // Update item count badge
            const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
            cartItemCount.textContent = totalItems;

            if (cart.length === 0) {
                cartItems.innerHTML = '';
                emptyMsg.classList.remove('opacity-0', 'pointer-events-none');
                total = 0;
                checkoutBtn.disabled = true;
            } else {
                emptyMsg.classList.add('opacity-0', 'pointer-events-none');
                cartItems.innerHTML = '';
                total = 0;

                cart.forEach((item, idx) => {
                    const subtotal = item.price * item.quantity;
                    total += subtotal;

                    const div = document.createElement('div');
                    div.className = 'bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex justify-between items-center cart-item-enter';
                    // Stagger animation delay
                    div.style.animationDelay = `${idx * 0.05}s`;

                    div.innerHTML = `
                        <div class="flex-1 pr-3">
                            <h4 class="text-sm font-bold text-[#332115] leading-tight mb-1 truncate">${item.name}</h4>
                            <p class="text-[13px] font-extrabold text-[#b37a54]">Rp ${new Intl.NumberFormat('id-ID').format(subtotal)}</p>
                            <p class="text-[10px] text-gray-400 mt-0.5">Rp ${new Intl.NumberFormat('id-ID').format(item.price)} / item</p>
                        </div>
                        <div class="flex items-center gap-2 bg-[#fdfaf5] p-1.5 rounded-full border border-[#f0e6d8]">
                            <button onclick="updateQuantity(${item.id}, -1)" class="w-7 h-7 flex items-center justify-center bg-white text-[#b37a54] hover:bg-[#b37a54] hover:text-white rounded-full shadow-sm transition-colors border border-[#f0e6d8]">
                                <i data-lucide="minus" class="w-3.5 h-3.5"></i>
                            </button>
                            <span class="w-6 text-center text-xs font-bold text-[#332115]">${item.quantity}</span>
                            <button onclick="updateQuantity(${item.id}, 1)" class="w-7 h-7 flex items-center justify-center bg-white text-[#b37a54] hover:bg-[#b37a54] hover:text-white rounded-full shadow-sm transition-colors border border-[#f0e6d8]">
                                <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                            </button>
                        </div>
                    `;
                    cartItems.appendChild(div);
                });
                checkoutBtn.disabled = false;
                lucide.createIcons();
            }

            const pajak = total * 0.08;
            const layanan = total * 0.05;
            const grandTotal = total + pajak + layanan;

            document.getElementById('cartSubtotal').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
            document.getElementById('cartPajak').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(pajak);
            document.getElementById('cartLayanan').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(layanan);
            document.getElementById('cartTotal').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(grandTotal);

            // Store grand total for calculateChange
            window.currentGrandTotal = grandTotal;

            calculateChange();
        }

        document.getElementById('amountPaid').addEventListener('input', calculateChange);

        function calculateChange() {
            const paidInput = document.getElementById('amountPaid').value;
            const paid = parseInt(paidInput) || 0;
            const grandTotal = window.currentGrandTotal || 0;
            const changeDiv = document.getElementById('changeDiv');
            const errorText = document.getElementById('amountError');
            const checkoutBtn = document.getElementById('checkoutBtn');

            if (cart.length === 0) {
                changeDiv.classList.add('hidden');
                errorText.classList.add('hidden');
                checkoutBtn.disabled = true;
                return;
            }

            if (paidInput !== '' && paid < grandTotal) {
                errorText.classList.remove('hidden');
                changeDiv.classList.add('hidden');
                checkoutBtn.disabled = true;
            } else {
                errorText.classList.add('hidden');
                if (paid >= grandTotal) {
                    const change = paid - grandTotal;
                    document.getElementById('changeAmount').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(change);
                    changeDiv.classList.remove('hidden');
                    checkoutBtn.disabled = false;
                } else {
                    changeDiv.classList.add('hidden');
                    checkoutBtn.disabled = true;
                }
            }
        }

        document.getElementById('checkoutBtn').addEventListener('click', async function () {
            const customerName = document.getElementById('customerName').value.trim();
            const customerEmail = document.getElementById('customerEmail').value.trim();
            if (!customerName) {
                showErrorModal('Harap isi Nama Pemesan terlebih dahulu sebelum memproses pembayaran!', 'Data Belum Lengkap');
                document.getElementById('customerName').focus();
                return;
            }

            const btn = this;
            const originalText = btn.innerHTML;
            const amountPaid = document.getElementById('amountPaid').value;

            btn.disabled = true;
            btn.innerHTML = '<i data-lucide="loader" class="w-6 h-6 animate-spin relative z-10"></i> <span class="relative z-10">Memproses...</span>';
            lucide.createIcons();

            try {
                const response = await fetch('{{ route("kasir.pos.checkout") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        items: cart,
                        amount_paid: amountPaid,
                        customer_name: customerName,
                        email: customerEmail
                    })
                });

                const data = await response.json();

                if (response.ok) {
                    showSuccessModal(data.order_number, data.change);
                } else {
                    showErrorModal(data.message || 'Terjadi kesalahan saat memproses pesanan.', 'Gagal Memproses');
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                }
            } catch (error) {
                showErrorModal('Terjadi gangguan jaringan atau server tidak merespon.', 'Koneksi Bermasalah');
                btn.disabled = false;
                btn.innerHTML = originalText;
            }
        });

        function showSuccessModal(orderId, change) {
            document.getElementById('successOrderId').textContent = orderId;
            document.getElementById('successChange').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(change);

            const modal = document.getElementById('successModal');
            const content = document.getElementById('successModalContent');

            modal.classList.remove('hidden');
            void modal.offsetWidth; // force reflow

            modal.classList.remove('opacity-0');
            modal.classList.add('opacity-100');

            setTimeout(() => {
                content.classList.remove('scale-95', 'translate-y-8', 'opacity-0');
                content.classList.add('scale-100', 'translate-y-0', 'opacity-100');
            }, 10);
        }

        function resetPOS() {
            const modal = document.getElementById('successModal');
            const content = document.getElementById('successModalContent');

            content.classList.remove('scale-100', 'translate-y-0', 'opacity-100');
            content.classList.add('scale-95', 'translate-y-8', 'opacity-0');

            modal.classList.remove('opacity-100');
            modal.classList.add('opacity-0');

            setTimeout(() => {
                modal.classList.add('hidden');
                window.location.reload();
            }, 300);
        }

        function showErrorModal(message, title = 'Peringatan') {
            document.getElementById('errorModalTitle').textContent = title;
            document.getElementById('errorModalMessage').textContent = message;

            const modal = document.getElementById('errorModal');
            const content = document.getElementById('errorModalContent');

            modal.classList.remove('hidden');
            void modal.offsetWidth;

            modal.classList.remove('opacity-0');
            modal.classList.add('opacity-100');

            setTimeout(() => {
                content.classList.remove('scale-95', 'translate-y-8', 'opacity-0');
                content.classList.add('scale-100', 'translate-y-0', 'opacity-100');
            }, 10);
        }

        function closeErrorModal() {
            const modal = document.getElementById('errorModal');
            const content = document.getElementById('errorModalContent');

            content.classList.remove('scale-100', 'translate-y-0', 'opacity-100');
            content.classList.add('scale-95', 'translate-y-8', 'opacity-0');

            modal.classList.remove('opacity-100');
            modal.classList.add('opacity-0');

            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }
    </script>
</body>

</html>