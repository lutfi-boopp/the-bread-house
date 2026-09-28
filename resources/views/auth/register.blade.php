{{-- ========================================================================================= --}}
{{-- [FITUR AUTH] HALAMAN REGISTRASI AKUN PEMBELI BARU                                         --}}
{{-- Fungsi: Pendaftaran akun baru, konfirmasi kata sandi, & validasi bot via Google reCAPTCHA --}}
{{-- ========================================================================================= --}}
<x-guest-layout>
    <div class="mb-6">
        <h2 class="font-heading text-3xl font-bold text-brand-text mb-2">Buat Akun Baru</h2>
        <p class="text-sm text-brand-text-light">Lengkapi data diri Anda untuk memulai perjalanan manis bersama kami.
        </p>
    </div>

    <form id="register-form" method="POST" action="/register">
        @csrf

        <!-- Nama Lengkap -->
        <div class="mb-4">
            <label for="name" class="block text-xs font-semibold text-brand-text mb-1.5">Nama Lengkap</label>
            <input id="name" type="text" name="name"
                class="w-full px-3 py-2.5 bg-white border border-brand-border rounded-lg text-sm focus:outline-none focus:ring-1 focus:ring-brand-brown focus:border-brand-brown"
                placeholder="Masukkan nama lengkap Anda" required autofocus>
        </div>

        <!-- Email -->
        <div class="mb-4">
            <label for="email" class="block text-xs font-semibold text-brand-text mb-1.5">Alamat Email</label>
            <input id="email" type="email" name="email"
                class="w-full px-3 py-2.5 bg-white border border-brand-border rounded-lg text-sm focus:outline-none focus:ring-1 focus:ring-brand-brown focus:border-brand-brown"
                placeholder="nama@email.com" required>
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="block text-xs font-semibold text-brand-text mb-1.5">Kata Sandi</label>
            <div class="relative">
                <input id="password" type="password" name="password"
                    class="w-full pl-3 pr-10 py-2.5 bg-white border border-brand-border rounded-lg text-sm focus:outline-none focus:ring-1 focus:ring-brand-brown focus:border-brand-brown"
                    placeholder="Min. 8 karakter" required>
                <div
                    class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer text-gray-400 hover:text-gray-600 toggle-password" onclick="togglePasswordVisibility(this)">
                    <!-- Eye Closed Icon -->
                    <svg class="w-4 h-4 eye-closed" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                    </svg>
                    <!-- Eye Open Icon (hidden by default) -->
                    <svg class="w-4 h-4 eye-open hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </div>
            </div>

            <!-- Ketentuan Password -->
            <div id="password-criteria-card" class="mt-3 bg-gray-50/80 p-4 rounded-xl border border-gray-100 shadow-sm transition-all duration-300">
                <p class="text-xs text-gray-600 font-semibold mb-3">Kata sandi Anda harus memenuhi:</p>
                <ul class="space-y-2.5 text-xs">
                    <li id="req-length" class="flex items-center text-gray-400 transition-all duration-300">
                        <div class="icon-wrapper transition-transform duration-300 transform scale-100 mr-2.5">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <span class="transition-all duration-300 inline-block">Minimal 8 karakter</span>
                    </li>
                    <li id="req-uppercase" class="flex items-center text-gray-400 transition-all duration-300">
                        <div class="icon-wrapper transition-transform duration-300 transform scale-100 mr-2.5">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <span class="transition-all duration-300 inline-block">Mengandung huruf besar</span>
                    </li>
                    <li id="req-number" class="flex items-center text-gray-400 transition-all duration-300">
                        <div class="icon-wrapper transition-transform duration-300 transform scale-100 mr-2.5">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <span class="transition-all duration-300 inline-block">Mengandung angka</span>
                    </li>
                    <li id="req-special" class="flex items-center text-gray-400 transition-all duration-300">
                        <div class="icon-wrapper transition-transform duration-300 transform scale-100 mr-2.5">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <span class="transition-all duration-300 inline-block">Mengandung karakter spesial (cth: !@#$%^&*)</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Konfirmasi Kata Sandi -->
        <div class="mb-5">
            <label for="password_confirmation" class="block text-xs font-semibold text-brand-text mb-1.5">Konfirmasi
                Kata Sandi</label>
            <div class="relative">
                <input id="password_confirmation" type="password" name="password_confirmation"
                    class="w-full pl-3 pr-10 py-2.5 bg-white border border-brand-border rounded-lg text-sm focus:outline-none focus:ring-1 focus:ring-brand-brown focus:border-brand-brown"
                    placeholder="Ulangi kata sandi Anda" required>
                <div
                    class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer text-gray-400 hover:text-gray-600 toggle-password" onclick="togglePasswordVisibility(this)">
                    <!-- Eye Closed Icon -->
                    <svg class="w-4 h-4 eye-closed" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                    </svg>
                    <!-- Eye Open Icon (hidden by default) -->
                    <svg class="w-4 h-4 eye-open hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Terms and Conditions -->
        <div class="flex items-start mb-6">
            <div class="flex items-center h-5">
                <input id="terms" type="checkbox" required
                    class="w-4 h-4 text-brand-brown border-brand-border rounded focus:ring-brand-brown">
            </div>
            <label for="terms" class="ml-2 text-[11px] leading-tight text-brand-text-light">
                Saya menyetujui <a href="#" class="font-semibold text-brand-brown hover:underline">Syarat &
                    Ketentuan</a> serta <a href="#" class="font-semibold text-brand-brown hover:underline">Kebijakan
                    Privasi</a>.
            </label>
        </div>

        <!-- CAPTCHA -->
        <div class="mb-6 flex justify-center">
            <div class="g-recaptcha" data-sitekey="{{ env('NOCAPTCHA_SITEKEY') }}"></div>
        </div>
        @if ($errors->has('g-recaptcha-response'))
            <p class="mb-4 text-xs text-red-500 text-center">{{ $errors->first('g-recaptcha-response') }}</p>
        @endif

        <!-- Submit Button -->
        <button type="submit"
            class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-brand-brown hover:bg-brand-brown-hover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-brown transition-colors">
            Daftar Sekarang
            <svg class="ml-2 -mr-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3">
                </path>
            </svg>
        </button>

        <!-- Footer -->
        <p class="mt-6 text-center text-xs text-brand-text-light">
            Sudah punya akun? <a href="/login" class="font-semibold text-brand-brown hover:underline">Masuk Sekarang</a>
        </p>

    </form>
    
    <!-- Toast Notification -->
    <div id="password-toast" class="fixed bottom-4 right-4 max-w-sm bg-white border-l-4 border-red-500 shadow-lg rounded-lg p-4 transform translate-y-20 opacity-0 transition-all duration-300 z-50 flex items-start pointer-events-none">
        <svg class="w-5 h-5 text-red-500 mr-3 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <div>
            <h3 class="text-sm font-bold text-gray-800">Kata Sandi Belum Kuat</h3>
            <p class="text-xs text-gray-500 mt-1">Silakan penuhi semua ketentuan kata sandi yang berwarna merah/abu-abu sebelum mendaftar.</p>
        </div>
    </div>

    <style>
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            50% { transform: translateX(5px); }
            75% { transform: translateX(-5px); }
        }
        .animate-shake {
            animation: shake 0.4s ease-in-out;
        }
    </style>

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const passwordInput = document.getElementById('password');
            
            // Elemen ketentuan password
            const reqLength = document.getElementById('req-length');
            const reqUppercase = document.getElementById('req-uppercase');
            const reqNumber = document.getElementById('req-number');
            const reqSpecial = document.getElementById('req-special');

            function updateRequirement(element, isValid) {
                const iconWrapper = element.querySelector('.icon-wrapper');
                const textSpan = element.querySelector('span');
                
                if (isValid) {
                    element.classList.remove('text-gray-400');
                    element.classList.add('text-green-500');
                    
                    textSpan.classList.add('font-medium', 'translate-x-1');
                    
                    iconWrapper.classList.remove('scale-100');
                    iconWrapper.classList.add('scale-125');
                } else {
                    element.classList.remove('text-green-500');
                    element.classList.add('text-gray-400');
                    
                    textSpan.classList.remove('font-medium', 'translate-x-1');
                    
                    iconWrapper.classList.remove('scale-125');
                    iconWrapper.classList.add('scale-100');
                }
            }

            passwordInput.addEventListener('input', function () {
                const val = this.value;
                updateRequirement(reqLength, val.length >= 8);
                updateRequirement(reqUppercase, /[A-Z]/.test(val));
                updateRequirement(reqNumber, /[0-9]/.test(val));
                updateRequirement(reqSpecial, /[^A-Za-z0-9]/.test(val));
            });

            // Validasi saat form disubmit
            const registerForm = document.getElementById('register-form');
            const criteriaCard = document.getElementById('password-criteria-card');
            const passwordToast = document.getElementById('password-toast');
            let toastTimeout;

            registerForm.addEventListener('submit', function (e) {
                const val = passwordInput.value;
                const isValid = val.length >= 8 && /[A-Z]/.test(val) && /[0-9]/.test(val) && /[^A-Za-z0-9]/.test(val);
                
                if (!isValid) {
                    e.preventDefault(); // Cegah pendaftaran
                    
                    // Tambah efek goyang (shake) dan border merah sesaat
                    passwordInput.classList.add('animate-shake', 'border-red-500');
                    if(criteriaCard) {
                        criteriaCard.classList.add('animate-shake', 'border-red-300', 'bg-red-50/50');
                    }
                    
                    setTimeout(() => {
                        passwordInput.classList.remove('animate-shake');
                        if(criteriaCard) criteriaCard.classList.remove('animate-shake');
                    }, 400);

                    // Tampilkan pop up toast
                    passwordToast.classList.remove('translate-y-20', 'opacity-0');
                    passwordToast.classList.add('translate-y-0', 'opacity-100');
                    
                    clearTimeout(toastTimeout);
                    toastTimeout = setTimeout(() => {
                        // Sembunyikan toast dan hapus warna merah setelah 4 detik
                        passwordToast.classList.remove('translate-y-0', 'opacity-100');
                        passwordToast.classList.add('translate-y-20', 'opacity-0');
                        passwordInput.classList.remove('border-red-500');
                        if(criteriaCard) criteriaCard.classList.remove('border-red-300', 'bg-red-50/50');
                    }, 4000);
                }
            });
        });
    </script>
</x-guest-layout>