{{-- ========================================================================================= --}}
{{-- [FITUR AUTH] HALAMAN LOGIN PENGGUNA                                                       --}}
{{-- Fungsi: Form masukan email & password, proteksi Google reCAPTCHA, & opsi Remember Me      --}}
{{-- ========================================================================================= --}}
<x-guest-layout>
    <div class="mb-8">
        <h2 class="font-heading text-3xl font-bold text-brand-text mb-2">Selamat Datang</h2>
        <p class="text-sm text-brand-text-light">Masuk untuk melanjutkan pesanan atau kelola toko Anda.</p>
    </div>

    @if (session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg text-sm flex items-start">
            <svg class="w-5 h-5 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <form method="POST" action="/login">
        @csrf

        <!-- Email -->
        <div class="mb-4">
            <label for="email" class="block text-xs font-semibold text-brand-text mb-1.5">Email</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                    class="w-full pl-10 pr-3 py-2.5 bg-white border border-brand-border rounded-lg text-sm focus:outline-none focus:ring-1 focus:ring-brand-brown focus:border-brand-brown @error('email') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                    placeholder="nama@email.com" required autofocus>
            </div>
            @error('email')
                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-5">
            <div class="flex justify-between items-center mb-1.5">
                <label for="password" class="block text-xs font-semibold text-brand-text">Kata Sandi</label>
                <a href="#" class="text-[11px] font-medium text-brand-brown hover:underline">Lupa Sandi?</a>
            </div>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                        </path>
                    </svg>
                </div>
                <input id="password" type="password" name="password"
                    class="w-full pl-10 pr-10 py-2.5 bg-white border border-brand-border rounded-lg text-sm tracking-widest focus:outline-none focus:ring-1 focus:ring-brand-brown focus:border-brand-brown"
                    placeholder="••••••••" required>
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer text-gray-400 hover:text-gray-600 toggle-password"
                    onclick="togglePasswordVisibility(this)">
                    <!-- Eye Closed Icon -->
                    <svg class="w-4 h-4 eye-closed" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21">
                        </path>
                    </svg>
                    <!-- Eye Open Icon (hidden by default) -->
                    <svg class="w-4 h-4 eye-open hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                        </path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Remember Me -->
        <div class="flex items-center mb-6">
            <input id="remember" type="checkbox" name="remember"
                class="w-4 h-4 text-brand-brown border-brand-border rounded focus:ring-brand-brown">
            <label for="remember" class="ml-2 block text-xs text-brand-text-light">
                Ingat saya untuk sesi berikutnya
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
            Masuk Ke Akun
            <svg class="ml-2 -mr-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3">
                </path>
            </svg>
        </button>

        <!-- Footer -->
        <p class="mt-8 text-center text-xs text-brand-text-light">
            Belum punya akun? <a href="/register" class="font-semibold text-brand-brown hover:underline">Daftar
                Sekarang</a>
        </p>

    </form>

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</x-guest-layout>