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
        
        {{-- [PERBAIKAN] Hapus atribut 'defer' agar Alpine.js langsung dimuat --}}
        <script src="//cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            
            <div class="fixed top-0 left-0 right-0 z-40">
                @include('layouts.navigation')
            </div>

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow pt-28">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif
            
            <!-- Page Content -->
            <main>
                <div class="{{ isset($header) ? '' : 'pt-24' }}"> 
                    {{ $slot }}
                </div>
            </main>
        </div>

        <!-- Script untuk notifikasi global -->
        @if ($errors->any())
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        text: '{{ $errors->first() }}',
                        timer: 3000,
                        timerProgressBar: true,
                        showConfirmButton: false,
                        didClose: () => {
                            window.history.back();
                        }
                    });
                });
            </script>
        @endif
        
        @if (session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: '{{ session('success') }}',
                        timer: 2000,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });
                });
            </script>
        @endif
    </body>
</html>
