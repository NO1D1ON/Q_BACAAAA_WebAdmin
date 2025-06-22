{{-- 
    Tidak ada perubahan baru di file ini.
    File ini hanya berisi struktur HTML dari navigasi.
    Logika show/hide saat scroll sudah ditangani oleh app.blade.php
--}}
<nav x-data="{ open: false }" class="bg-transparent">
    {{-- Kontainer utama yang memberi padding dan menempatkan navigasi di atas --}}
    <div class="p-4">
        {{-- Navigasi utama dengan style "glassmorphism" HANYA PADA LAYAR LEBAR (lg) --}}
        <div class="relative max-w-7xl mx-auto lg:bg-white/70 lg:backdrop-blur-xl lg:rounded-xl lg:shadow-lg lg:ring-1 lg:ring-black/5">
            <div class="flex items-center justify-between h-20 px-6">
                
                {{-- Logo kini hanya tampil pada layar besar (lg ke atas) --}}
                <div class="hidden lg:flex flex-shrink-0">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-x-3">
                        <div class="h-12 w-15 overflow-hidden flex items-center justify-center">
                            <img src="{{ asset('assets/slide1.png') }}" alt="Q Baca" class="h-full w-full object-cover">
                        </div>
                    </a>
                </div>

                {{-- Menu Navigasi - Muncul di layar besar (lg) ke atas --}}
                <div class="hidden lg:flex items-center justify-center">
                    <div class="flex items-center space-x-2 bg-white/80 p-2 rounded-xl shadow-inner ring-1 ring-[#28738B]">          
                        {{-- Dashboard --}}
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-x-2 px-4 py-2 rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-[#28738B] text-white shadow' : 'text-gray-600 hover:bg-gray-900/10' }}">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m4 12 8-8 8 8M6 10.5V19a1 1 0 0 0 1 1h3v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h3a1 1 0 0 0 1-1v-8.5"/>
                            </svg>
                            <span>Dashboard</span>
                        </a>

                        {{-- Kategori --}}
                        <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-x-2 px-4 py-2 rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.categories.*') ? 'bg-[#28738B] text-white shadow' : 'text-gray-600 hover:bg-gray-900/10' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5"><path fill-rule="evenodd" d="M5.75 2a.75.75 0 01.75.75V4h7V2.75a.75.75 0 011.5 0V4h.25A2.75 2.75 0 0118 6.75v8.5A2.75 2.75 0 0115.25 18H4.75A2.75 2.75 0 012 15.25v-8.5A2.75 2.75 0 014.75 4H5V2.75A.75.75 0 015.75 2zM4.5 8.5v6.75c0 .138.112.25.25.25h10.5a.25.25 0 00.25-.25V8.5h-11z" clip-rule="evenodd" /></svg>
                            <span>Kategori</span>
                        </a>
                        
                        {{-- Buku --}}
                        <a href="{{ route('admin.books.index') }}" class="flex items-center gap-x-2 px-4 py-2 rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.books.*') ? 'bg-[#28738B] text-white shadow' : 'text-gray-600 hover:bg-gray-900/10' }}">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v13H7a2 2 0 0 0-2 2Zm0 0a2 2 0 0 0 2 2h12M9 3v14m7 0v4"/>
                            </svg>
                            <span>Buku</span>
                        </a>

                        {{-- Pengguna --}}
                        <a href="{{ route('admin.users.index') }}" class="flex items-center gap-x-2 px-4 py-2 rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.users.index') ? 'bg-[#28738B] text-white shadow' : 'text-gray-600 hover:bg-gray-900/10' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                <path d="M10 8a3 3 0 100-6 3 3 0 000 6zM3.465 14.493a1.23 1.23 0 00.41 1.412A9.957 9.957 0 0010 18c2.31 0 4.438-.784 6.131-2.095a1.23 1.23 0 00.41-1.412A9.957 9.957 0 0010 12c-2.31 0-4.438.784-6.131 2.095z" />
                            </svg>
                            <span>Pengguna</span>
                        </a>

                        {{-- Transaksi --}}
                        <a href="{{ route('admin.transactions.index') }}" class="flex items-center gap-x-2 px-4 py-2 rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.transactions.index') ? 'bg-[#28738B] text-white shadow' : 'text-gray-600 hover:bg-gray-900/10' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                <path d="M2.25 4.25a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H3a.75.75 0 01-.75-.75zM18.5 7.25a.75.75 0 00-.75.75v5.5a.75.75 0 001.5 0v-5.5a.75.75 0 00-.75-.75zM3.25 8a.75.75 0 01.75-.75h.01a.75.75 0 010 1.5H4a.75.75 0 01-.75-.75zM5.25 8a.75.75 0 01.75-.75h.01a.75.75 0 010 1.5H6a.75.75 0 01-.75-.75zM7.25 8a.75.75 0 01.75-.75h.01a.75.75 0 010 1.5H8a.75.75 0 01-.75-.75zM9.25 8a.75.75 0 01.75-.75h.01a.75.75 0 010 1.5H10a.75.75 0 01-.75-.75z" />
                                <path fill-rule="evenodd" d="M1.5 15.25a.75.75 0 01.75-.75h15.5a.75.75 0 010 1.5H2.25a.75.75 0 01-.75-.75zM1.5 18a.75.75 0 01.75-.75h15.5a.75.75 0 010 1.5H2.25a.75.75 0 01-.75-.75z" clip-rule="evenodd" />
                            </svg>
                            <span>Transaksi</span>
                        </a>

                        {{-- Top-up --}}
                        <a href="{{ route('admin.topups.index') }}" class="flex items-center gap-x-2 px-4 py-2 rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.topups.index') ? 'bg-[#28738B] text-white shadow' : 'text-gray-600 hover:bg-gray-900/10' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11.25a.75.75 0 00-1.5 0v2.5h-2.5a.75.75 0 000 1.5h2.5v2.5a.75.75 0 001.5 0v-2.5h2.5a.75.75 0 000-1.5h-2.5v-2.5z" clip-rule="evenodd" />
                            </svg>
                            <span>Top-up</span>
                        </a>

                    </div>
                </div>

                <div class="hidden lg:flex items-center gap-x-2">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="p-2 rounded-full text-gray-600 hover:bg-white hover:shadow-md transition-all focus:outline-none">
                                <span class="sr-only">Open user menu</span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-6 h-6">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-5.5-2.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0zM10 12a5.99 5.99 0 00-4.793 2.39A6.483 6.483 0 0010 16.5a6.483 6.483 0 004.793-2.11A5.99 5.99 0 0010 12z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="px-4 py-2 text-sm text-gray-700">
                                <div class="font-bold">{{ Auth::guard('web')->user()->name }}</div>
                                <div class="text-gray-500">{{ Auth::guard('web')->user()->email }}</div>
                            </div>
                            <hr class="my-1">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>

                {{-- Tombol hamburger - hanya tampil di layar kecil --}}
                <div class="flex lg:hidden ml-auto">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-gray-700 hover:bg-gray-100 focus:outline-none">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

            </div>
        </div>
    </div>

    {{-- Menu dropdown untuk hamburger --}}
    <div :class="{'block': open, 'hidden': ! open}" class="hidden lg:hidden bg-white shadow-md rounded-b-lg mx-4">
        <div class="pt-2 pb-3 space-y-1 px-2">
            <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')">
                {{ __('Kategori') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.books.index')" :active="request()->routeIs('admin.books.*')">
                {{ __('Buku') }}
            </x-responsive-nav-link>
            
            <x-responsive-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.index')">
                {{ __('Pengguna') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.transactions.index')" :active="request()->routeIs('admin.transactions.index')">
                {{ __('Transaksi') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.topups.index')" :active="request()->routeIs('admin.topups.index')">
                {{ __('Top-up') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('logout')" :active="request()->routeIs('logout')">
                {{ __('Log Out') }}
            </x-responsive-nav-link>
        </div>
    </div>
</nav>