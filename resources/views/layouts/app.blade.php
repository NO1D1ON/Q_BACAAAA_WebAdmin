<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>QBaca</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

         <link rel="stylesheet" href="{{ asset('css/admin-nav.css') }}">
        <link rel="icon" href="{{ asset('assets/slide1.png') }}" type="image/png">

        <!-- Scripts -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="font-sans antialiased">
        {{-- Wrapper utama dengan logika scroll dari Alpine.js --}}
        <div x-data="{
                showNav: true,
                lastScrollY: window.scrollY,
                handleScroll() {
                    if (window.scrollY > this.lastScrollY) { // Scrolling ke bawah
                        this.showNav = false;
                    } else { // Scrolling ke atas
                        this.showNav = true;
                    }
                    this.lastScrollY = window.scrollY;
                }
            }"
            @scroll.window="handleScroll()" 
            class="min-h-screen bg-gray-100">
            
            {{-- Wrapper untuk Navigasi yang bisa hide/show --}}
            <div x-show="showNav" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="-translate-y-full"
                 x-transition:enter-end="translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="translate-y-0"
                 x-transition:leave-end="-translate-y-full"
                 class="fixed top-0 left-0 right-0 z-40">
                @include('layouts.navigation')
            </div>

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow pt-20"> {{-- Tambahkan padding-top agar tidak tertutup nav --}}
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{-- Tambahkan padding-top di sini jika halaman tidak punya header --}}
                <div class="{{ isset($header) ? '' : 'pt-20' }}"> 
                    {{ $slot }}
                </div>
            </main>
        </div>
    </body>
</html>
