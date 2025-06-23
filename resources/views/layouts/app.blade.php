<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>QBaca</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link rel="stylesheet" href="{{ asset('css/admin-nav.css') }}">
        <link rel="icon" href="{{ asset('assets/slide1.png') }}" type="image/png">

        <script src="https://cdn.tailwindcss.com"></script>
        
        {{-- Memuat Alpine.js (cukup satu baris) --}}
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <style>
            html, body {
                height: 100%;
                margin: 0;
                background: linear-gradient(to bottom, #E6FADD, #28738B);
                background-attachment: fixed;
                background-repeat: no-repeat;
                background-size: cover;
            }
        </style>

        {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen">
            
            {{-- Logika animasi scroll dengan Alpine.js (Tidak berubah) --}}
            <div 
                x-data="{ showNav: true, lastScrollY: window.scrollY }"
                @scroll.window="
                    if (window.scrollY > lastScrollY) {
                        showNav = false;
                    } else {
                        showNav = true;
                    }
                    lastScrollY = window.scrollY;
                "
                class="fixed top-0 left-0 right-0 z-40 transition-transform duration-300"
                :class="{ 'translate-y-0': showNav, '-translate-y-full': !showNav }"
            >
                @include('layouts.navigation')
            </div>

            @if (isset($header))
                <header class="bg-[#E6FADD] shadow pt-28">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif
            
            <main class="min-h-full bg-gradient-to-b" style="background-image: linear-gradient(to bottom, #E6FADD, #28738B);">
                {{-- Padding atas untuk memberi ruang bagi navigasi yang fixed --}}
                <div class="{{ isset($header) ? '' : 'pt-32' }}"> 
                    {{ $slot }}
                </div>
            </main>
        </div>

        {{-- 
            [PERBAIKAN UTAMA] 
            Semua script notifikasi global dihapus dari sini.
            Logika notifikasi sekarang ditangani oleh setiap halaman individual
            (seperti create.blade.php atau edit.blade.php) untuk mencegah
            notifikasi yang tidak diinginkan muncul di halaman yang salah.
        --}}
    </body>
</html>
