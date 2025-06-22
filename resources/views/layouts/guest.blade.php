{{-- resources/views/layouts/guest.blade.php --}}

@props([
    'image' => asset('assets/637201.png') // <-- GAMBAR DEFAULT JIKA TIDAK ADA YANG DIKIRIM
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>QBaca</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="icon" href="{{ asset('assets/slide1.png') }}" type="image/png">

        <!-- <link rel="stylesheet" href="{{ asset('css/custom-guest.css') }}"> -->
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    {{-- Terapkan class background di sini --}}
    <body class="font-sans text-gray-900 antialiased bg-[#E6FADD]">
    {{-- Kontainer utama dengan background kustom --}}
    <div class="min-h-screen flex items-center justify-center bg-custom-bg p-4 sm:p-6 lg:p-8">
        
        {{-- Kartu utama yang menggabungkan gambar dan form --}}
        <div class="flex w-full max-w-4xl bg-white rounded-xl shadow-2xl overflow-hidden">
            <div class="w-full md:w-1/2 p-8 sm:p-12">
                {{ $slot }}
            </div>

            <div class="hidden md:block md:w-1/2 p-4">
                {{-- UBAH BAGIAN INI --}}
                <div class="h-full w-full bg-no-repeat bg-center bg-contain" 
                    style="background-image: url('{{ $image }}');"> {{-- Gunakan variabel $image --}}
                </div>
                {{-- AKHIR DARI PERUBAHAN --}}
            </div>


        </div>
        
    </div>
</body>
</html>

