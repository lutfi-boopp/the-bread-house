@extends('layouts.pembeli')

@section('content')
    <div class="min-h-screen bg-[#faf8f5] py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="flex items-center justify-center mb-10">
                <h1 class="font-bold text-xl text-[#332115]">Profil Pengguna</h1>
            </div>

            @auth
                <!-- Avatar & Name -->
                <div class="flex flex-col items-center mb-8">
                    <div class="relative mb-3">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Pengguna') }}&background=e6dace&color=6b3e1c&size=128"
                            alt="Profile" class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-sm">
                        <button
                            class="absolute bottom-0 right-0 bg-[#b37a54] p-1.5 rounded-full text-white border-2 border-white shadow-sm hover:bg-[#8b5a3b] transition-colors">
                            <i data-lucide="camera" class="w-3.5 h-3.5"></i>
                        </button>
                    </div>
                    <h2 class="text-2xl font-bold text-[#332115]">{{ auth()->user()->name ?? 'Pengguna' }}</h2>
                    <div class="bg-[#f5e3d7] text-[#b37a54] text-xs font-bold px-3 py-1 rounded-full mt-2 flex items-center">
                        <i data-lucide="check-circle-2" class="w-3 h-3 mr-1"></i>
                        {{ ucfirst(auth()->user()->role ?? 'Pembeli') }}
                    </div>
                </div>

                <!-- Statistik & Loyalty Card -->
                <div class="grid grid-cols-2 gap-4 mb-8">
                    <div
                        class="bg-gradient-to-br from-[#6b3e1c] to-[#8b4f23] rounded-2xl p-5 shadow-sm text-white relative overflow-hidden">
                        <div class="absolute -right-4 -bottom-4 opacity-10">
                            <i data-lucide="shopping-bag" class="w-24 h-24"></i>
                        </div>
                        <p class="text-xs font-medium text-white/80 uppercase tracking-wider mb-1">Pesanan Selesai</p>
                        <h3 class="font-heading text-3xl font-bold">
                            {{ auth()->user()->orders ? auth()->user()->orders()->where('status', 'selesai')->count() : 0 }}
                        </h3>
                        <p class="text-xs text-white/80 mt-2">Terima kasih atas kesetiaannya!</p>
                    </div>
                    <div
                        class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex flex-col justify-center items-center text-center relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-full h-1 bg-[#b37a54]"></div>
                        <div
                            class="w-12 h-12 bg-[#fdf5eb] text-[#7a3b00] rounded-full flex items-center justify-center mb-2 shadow-sm">
                            <i data-lucide="award" class="w-6 h-6"></i>
                        </div>
                        <h3 class="font-bold text-[#4a3020]">Member The Bread House</h3>
                        <p class="text-xs text-gray-500">Bergabung
                            {{ auth()->user()->created_at ? auth()->user()->created_at->translatedFormat('M Y') : 'Baru saja' }}
                        </p>
                    </div>
                </div>

                <!-- Info Card -->
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 mb-8" id="info-card">
                    <div class="space-y-6">
                        <!-- Name -->
                        <div class="flex items-start">
                            <div class="bg-[#faf8f5] p-3 rounded-full mr-5 text-[#b37a54]">
                                <i data-lucide="user" class="w-6 h-6"></i>
                            </div>
                            <div class="flex-1 border-b border-gray-100 pb-5">
                                <p class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-1">Nama Lengkap</p>
                                <p class="text-base font-medium text-[#332115]">{{ auth()->user()->name ?? '-' }}</p>
                            </div>
                        </div>
                        <!-- Phone -->
                        <div class="flex items-start">
                            <div class="bg-[#faf8f5] p-3 rounded-full mr-5 text-[#b37a54]">
                                <i data-lucide="phone" class="w-6 h-6"></i>
                            </div>
                            <div class="flex-1 border-b border-gray-100 pb-5">
                                <p class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-1">Nomor Telepon</p>
                                <p class="text-base font-medium text-[#332115]">{{ auth()->user()->phone ?? '-' }}</p>
                            </div>
                        </div>
                        <!-- Email -->
                        <div class="flex items-start">
                            <div class="bg-[#faf8f5] p-3 rounded-full mr-5 text-[#b37a54]">
                                <i data-lucide="mail" class="w-6 h-6"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-1">Email</p>
                                <p class="text-base font-medium text-[#332115]">{{ auth()->user()->email ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Edit Form (Hidden by default) -->
                <div id="edit-form" class="hidden bg-white rounded-2xl p-8 shadow-sm border border-gray-100 mb-8">
                    <h3 class="font-bold text-[#332115] mb-4">Edit Profil</h3>
                    <form method="POST" action="{{ route('pembeli.profil.update') }}">
                        @csrf
                        @method('PUT')
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-[#332115] mb-1">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-[#6b3e1c] focus:ring focus:ring-[#6b3e1c] focus:ring-opacity-20 text-sm py-2.5 px-3">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-[#332115] mb-1">Email</label>
                                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-[#6b3e1c] focus:ring focus:ring-[#6b3e1c] focus:ring-opacity-20 text-sm py-2.5 px-3">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-[#332115] mb-1">Nomor Telepon</label>
                                <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone) }}"
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-[#6b3e1c] focus:ring focus:ring-[#6b3e1c] focus:ring-opacity-20 text-sm py-2.5 px-3">
                            </div>
                            <div class="flex gap-3 pt-4">
                                <button type="button" onclick="toggleEditForm()"
                                    class="flex-1 bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 font-semibold py-2.5 rounded-xl transition-colors">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="flex-1 bg-[#6b3e1c] hover:bg-[#522e15] text-white font-semibold py-2.5 rounded-xl transition-colors">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Permissions -->
                <div class="bg-transparent rounded-2xl p-6 border border-gray-200 border-dashed mb-8">
                    <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-4 flex items-center">
                        <i data-lucide="shield" class="w-4 h-4 mr-2"></i> Wewenang Akun
                    </h3>
                    <ul class="space-y-3">
                        @if(auth()->check() && auth()->user()->role == 'admin')
                            <li class="flex items-center text-sm text-gray-600">
                                <i data-lucide="check-circle-2" class="w-4 h-4 mr-3 text-[#b37a54]"></i> Kelola seluruh sistem dan pengguna
                            </li>
                        @elseif(auth()->check() && auth()->user()->role == 'kasir')
                            <li class="flex items-center text-sm text-gray-600">
                                <i data-lucide="check-circle-2" class="w-4 h-4 mr-3 text-[#b37a54]"></i> Kelola transaksi dan pesanan
                            </li>
                        @else
                            <li class="flex items-center text-sm text-gray-600">
                                <i data-lucide="check-circle-2" class="w-4 h-4 mr-3 text-[#b37a54]"></i> Akses pemesanan produk
                            </li>
                            <li class="flex items-center text-sm text-gray-600">
                                <i data-lucide="check-circle-2" class="w-4 h-4 mr-3 text-[#b37a54]"></i> Pantau riwayat pesanan pribadi
                            </li>
                        @endif
                        <li class="flex items-center text-sm text-gray-600">
                            <i data-lucide="check-circle-2" class="w-4 h-4 mr-3 text-[#b37a54]"></i> Edit informasi profil dasar
                        </li>
                    </ul>
                </div>

                <!-- Buttons -->
                <div class="space-y-3" id="action-buttons">
                    <button type="button" onclick="toggleEditForm()"
                        class="w-full bg-[#b37a54] hover:bg-[#8b5a3b] text-white font-semibold py-3.5 rounded-xl transition-colors flex justify-center items-center">
                        <i data-lucide="edit-3" class="w-4 h-4 mr-2"></i> Edit Profil
                    </button>
                    <button type="button" onclick="toggleLogoutModal()"
                        class="w-full bg-[#fff5f5] hover:bg-[#ffe5e5] text-[#dc2626] border border-[#ffcccc] font-semibold py-3.5 rounded-xl transition-colors flex justify-center items-center">
                        <i data-lucide="log-out" class="w-4 h-4 mr-2"></i> Keluar dari Akun
                    </button>
                </div>
            @else
                <!-- Guest State UI -->
                <div class="bg-white rounded-3xl p-10 shadow-[0_4px_20px_-10px_rgba(0,0,0,0.1)] border border-[#f0e6d5] flex flex-col items-center text-center">
                    <div class="w-24 h-24 bg-[#fdf5eb] rounded-full flex items-center justify-center mb-6 shadow-sm border-4 border-[#fff9f0]">
                        <i data-lucide="user-x" class="w-10 h-10 text-[#b37a54]"></i>
                    </div>
                    
                    <h2 class="font-heading text-2xl font-bold text-[#332115] mb-3">Belum Masuk Akun</h2>
                    <p class="text-[#7a6a5f] text-sm mb-8 max-w-md leading-relaxed">
                        Anda saat ini sedang berbelanja sebagai tamu (Guest). Silakan masuk ke akun Anda atau daftar sekarang untuk menikmati berbagai keuntungan eksklusif di The Bread House!
                    </p>
                    
                    <div class="w-full max-w-sm space-y-3">
                        <a href="{{ route('login') }}" class="w-full block bg-[#6b3e1c] hover:bg-[#522e15] text-white font-bold py-3.5 rounded-xl transition-colors">
                            Masuk Akun
                        </a>
                        <a href="{{ route('register') }}" class="w-full block bg-white border-2 border-[#e6dace] text-[#6b3e1c] hover:bg-[#fcf8f2] hover:border-[#6b3e1c] font-bold py-3.5 rounded-xl transition-colors">
                            Buat Akun Baru
                        </a>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mt-10 border-t border-gray-100 pt-8 w-full">
                        <div class="flex flex-col items-center">
                            <i data-lucide="tag" class="w-6 h-6 text-[#b37a54] mb-2"></i>
                            <span class="text-xs font-semibold text-[#332115]">Promo Khusus</span>
                            <span class="text-[10px] text-gray-500 mt-1">Hanya untuk member</span>
                        </div>
                        <div class="flex flex-col items-center">
                            <i data-lucide="history" class="w-6 h-6 text-[#b37a54] mb-2"></i>
                            <span class="text-xs font-semibold text-[#332115]">Riwayat Mudah</span>
                            <span class="text-[10px] text-gray-500 mt-1">Lacak pesanan kapan saja</span>
                        </div>
                        <div class="flex flex-col items-center">
                            <i data-lucide="award" class="w-6 h-6 text-[#b37a54] mb-2"></i>
                            <span class="text-xs font-semibold text-[#332115]">Poin Loyalitas</span>
                            <span class="text-[10px] text-gray-500 mt-1">Kumpulkan & tukarkan</span>
                        </div>
                    </div>
                </div>
            @endauth

            <div class="text-center mt-12 text-xs text-gray-400">
                &copy; {{ date('Y') }} The Bread House Website App. All rights reserved.
            </div>
        </div>
    </div>

    @auth
    <!-- Logout Confirmation Modal -->
    <div id="logout-modal"
        class="fixed inset-0 bg-black/40 z-[60] hidden flex items-center justify-center backdrop-blur-sm transition-opacity duration-300 opacity-0">
        <div id="logout-modal-content"
            class="bg-white rounded-3xl p-8 max-w-sm w-full mx-4 shadow-xl border border-gray-100 transform transition-all duration-300 scale-95 opacity-0">
            <div class="flex flex-col items-center text-center">
                <div class="bg-[#fff5f5] p-4 rounded-full mb-4">
                    <i data-lucide="log-out" class="w-8 h-8 text-[#dc2626]"></i>
                </div>
                <h3 class="font-heading text-xl font-bold text-[#332115] mb-2">Keluar Akun</h3>
                <p class="text-sm text-gray-500 mb-6">Apakah Anda yakin ingin keluar dari akun The Bread House Anda?</p>

                <div class="w-full space-y-3">
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit"
                            class="w-full bg-[#dc2626] hover:bg-[#b91c1c] text-white font-semibold py-3 rounded-xl transition-colors">
                            Ya, Keluar
                        </button>
                    </form>
                    <button type="button" onclick="toggleLogoutModal()"
                        class="w-full bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 font-semibold py-3 rounded-xl transition-colors">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleLogoutModal() {
            const modal = document.getElementById('logout-modal');
            const modalContent = document.getElementById('logout-modal-content');

            if (modal.classList.contains('hidden')) {
                // Tampilkan modal (hilangkan hidden)
                modal.classList.remove('hidden');
                // Trigger reflow untuk memastikan transisi berjalan
                void modal.offsetWidth;

                // Terapkan class untuk animasi masuk
                modal.classList.remove('opacity-0');
                modal.classList.add('opacity-100');

                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            } else {
                // Terapkan class untuk animasi keluar
                modal.classList.remove('opacity-100');
                modal.classList.add('opacity-0');

                modalContent.classList.remove('scale-100', 'opacity-100');
                modalContent.classList.add('scale-95', 'opacity-0');

                // Sembunyikan sepenuhnya setelah animasi selesai
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 300);
            }
        }

        // Edit Form Logic
        function toggleEditForm() {
            const infoCard = document.getElementById('info-card');
            const formCard = document.getElementById('edit-form');
            const actionButtons = document.getElementById('action-buttons');

            if (formCard.classList.contains('hidden')) {
                formCard.classList.remove('hidden');
                infoCard.classList.add('hidden');
                actionButtons.classList.add('hidden');
            } else {
                formCard.classList.add('hidden');
                infoCard.classList.remove('hidden');
                actionButtons.classList.remove('hidden');
            }
        }
    </script>
    @endauth
@endsection