{{-- ========================================================================================= --}}
{{-- [LAYOUT AUTH/GUEST] TEMPLATE UTAMA AUTENTIKASI                                            --}}
{{-- Fungsi: Pembungkus halaman Login & Register beserta integrasi Google reCAPTCHA            --}}
{{-- ========================================================================================= --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'The Bread House') }}</title>

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-brand-text antialiased bg-brand-light">
    
    <div class="min-h-screen flex">
        
        <!-- Left Side: Image Banner -->
        <div class="hidden lg:flex lg:w-5/12 relative bg-brand-brown">
            <!-- Background Image Placeholder (Replace with actual bakery image) -->
            <img src="https://images.unsplash.com/photo-1509440159596-0249088772ff?q=80&w=1472&auto=format&fit=crop" 
                 alt="Bakery Kitchen" 
                 class="absolute inset-0 w-full h-full object-cover opacity-60 mix-blend-overlay">
            
            <div class="relative z-10 flex flex-col justify-center items-center text-center px-12 text-white">
                <h1 class="font-heading text-5xl font-bold mb-4 tracking-wide">{{ config('app.name', 'The Bread House') }}</h1>
                <p class="text-lg text-white/90 font-light mb-8 max-w-sm">
                    Kelezatan yang lahir dari ketulusan dan bahan pilihan terbaik. Selamat datang kembali di dapur kami.
                </p>
                
                <!-- Decorative Icons (Using simple SVGs as placeholder) -->
                <div class="flex space-x-4 opacity-80">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418"></path></svg>
                </div>
            </div>
        </div>

        <!-- Right Side: Form Area -->
        <div class="w-full lg:w-7/12 flex flex-col justify-center items-center p-8 sm:p-12">
            
            <div class="w-full max-w-md bg-brand-cream rounded-[24px] border border-brand-border p-8 sm:p-10 shadow-sm relative">
                {{ $slot }}
            </div>
            
            <div class="mt-8 text-center text-sm text-brand-text-light">
                &copy; {{ date('Y') }} {{ config('app.name', 'The Bread House') }}. Dibuat dengan cinta untuk pecinta roti.
            </div>
        </div>
        
    </div>

    <script>
        function togglePasswordVisibility(el) {
            const input = el.closest('.relative').querySelector('input');
            const eyeOpenIcon = el.querySelector('.eye-open');
            const eyeClosedIcon = el.querySelector('.eye-closed');
            
            if (input.type === 'password') {
                input.type = 'text';
                if (eyeOpenIcon) eyeOpenIcon.classList.remove('hidden');
                if (eyeClosedIcon) eyeClosedIcon.classList.add('hidden');
            } else {
                input.type = 'password';
                if (eyeOpenIcon) eyeOpenIcon.classList.add('hidden');
                if (eyeClosedIcon) eyeClosedIcon.classList.remove('hidden');
            }
        }
    </script>
</body>
</html>
