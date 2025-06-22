<nav x-data="{ open: false }" class="bg-gray-100">
    {{-- Kontainer utama yang memberi padding dan menempatkan navigasi di atas --}}
    <div class="p-4">
        {{-- Navigasi utama dengan style "glassmorphism" yang Anda inginkan --}}
        <div class="relative max-w-7xl mx-auto bg-white/70 backdrop-blur-xl rounded-xl shadow-lg ring-1 ring-black/5">
            <div class="flex items-center justify-between h-20 px-6">
                
                <div class="flex-shrink-0">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-x-3">
                        {{-- Ganti dengan logo Anda. Saya gunakan ikon sementara --}}
                        <div class="h-10 w-10 bg-yellow-400 rounded-full flex items-center justify-center">
                             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-white">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                            </svg>
                        </div>
                        <span class="text-xl font-bold text-gray-800 hidden sm:inline">Gotrips</span>
                    </a>
                </div>

                {{-- Muncul di layar besar (lg) ke atas --}}
                <div class="hidden lg:flex items-center justify-center">
                    <div class="flex items-center space-x-2 bg-white/80 p-2 rounded-xl shadow-inner ring-1 ring-black/5">                
                        {{-- Dashboard --}}
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-x-2 px-4 py-2 rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-800 text-white shadow' : 'text-gray-600 hover:bg-gray-900/10' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5"><path d="M7 3.5A1.5 1.5 0 018.5 2h3A1.5 1.5 0 0113 3.5v1.864c.343.22.65.492.906.812C14.5 7 14 8.5 14 8.5V11a1 1 0 11-2 0V8.5c0-.994.49-2.223.882-2.926.345-.61.42-1.2.112-1.748l-.096-.174A1.53 1.53 0 0010 3.5h-1A1.5 1.5 0 007.5 5v1.503a1.493 1.493 0 00-1.071.954L5.5 9.5a1 1 0 01-1 1H3a1 1 0 110-2h1.5a.5.5 0 00.447-.276l.11-.221A3.5 3.5 0 017 3.5zM15.5 11.5a1 1 0 011 1v2.053a.5.5 0 01-.354.47l-1.546.813a2.5 2.5 0 11-4.2-2.113V13a1 1 0 112 0v1.07a.5.5 0 00.28.455l.842.443a.5.5 0 00.648-.443V12.5a1 1 0 011-1z" /></svg>
                            <span>Dashboard</span>
                        </a>

                        {{-- Kategori --}}
                        <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-x-2 px-4 py-2 rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.categories.*') ? 'bg-gray-800 text-white shadow' : 'text-gray-600 hover:bg-gray-900/10' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5"><path fill-rule="evenodd" d="M5.75 2a.75.75 0 01.75.75V4h7V2.75a.75.75 0 011.5 0V4h.25A2.75 2.75 0 0118 6.75v8.5A2.75 2.75 0 0115.25 18H4.75A2.75 2.75 0 012 15.25v-8.5A2.75 2.75 0 014.75 4H5V2.75A.75.75 0 015.75 2zM4.5 8.5v6.75c0 .138.112.25.25.25h10.5a.25.25 0 00.25-.25V8.5h-11z" clip-rule="evenodd" /></svg>
                            <span>Kategori</span>
                        </a>
                        
                        {{-- Buku --}}
                        <a href="{{ route('admin.books.index') }}" class="flex items-center gap-x-2 px-4 py-2 rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.books.*') ? 'bg-gray-800 text-white shadow' : 'text-gray-600 hover:bg-gray-900/10' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5"><path d="M3.5 2.75a.75.75 0 00-1.5 0v14.5a.75.75 0 001.5 0v-14.5zM4.25 2A2.25 2.25 0 002 4.25v11.5A2.25 2.25 0 004.25 18h11.5A2.25 2.25 0 0018 15.75V4.25A2.25 2.25 0 0015.75 2H4.25z" /></svg>
                            <span>Buku</span>
                        </a>

                        {{-- [BARU] Pengguna --}}
                        <a href="{{ route('admin.users.index') }}" class="flex items-center gap-x-2 px-4 py-2 rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.users.index') ? 'bg-gray-800 text-white shadow' : 'text-gray-600 hover:bg-gray-900/10' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                <path d="M10 8a3 3 0 100-6 3 3 0 000 6zM3.465 14.493a1.23 1.23 0 00.41 1.412A9.957 9.957 0 0010 18c2.31 0 4.438-.784 6.131-2.095a1.23 1.23 0 00.41-1.412A9.957 9.957 0 0010 12c-2.31 0-4.438.784-6.131 2.095z" />
                            </svg>
                            <span>Pengguna</span>
                        </a>

                        {{-- [BARU] Transaksi --}}
                        <a href="{{ route('admin.transactions.index') }}" class="flex items-center gap-x-2 px-4 py-2 rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.transactions.index') ? 'bg-gray-800 text-white shadow' : 'text-gray-600 hover:bg-gray-900/10' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                <path d="M2.25 4.25a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H3a.75.75 0 01-.75-.75zM18.5 7.25a.75.75 0 00-.75.75v5.5a.75.75 0 001.5 0v-5.5a.75.75 0 00-.75-.75zM3.25 8a.75.75 0 01.75-.75h.01a.75.75 0 010 1.5H4a.75.75 0 01-.75-.75zM5.25 8a.75.75 0 01.75-.75h.01a.75.75 0 010 1.5H6a.75.75 0 01-.75-.75zM7.25 8a.75.75 0 01.75-.75h.01a.75.75 0 010 1.5H8a.75.75 0 01-.75-.75zM9.25 8a.75.75 0 01.75-.75h.01a.75.75 0 010 1.5H10a.75.75 0 01-.75-.75z" />
                                <path fill-rule="evenodd" d="M1.5 15.25a.75.75 0 01.75-.75h15.5a.75.75 0 010 1.5H2.25a.75.75 0 01-.75-.75zM1.5 18a.75.75 0 01.75-.75h15.5a.75.75 0 010 1.5H2.25a.75.75 0 01-.75-.75z" clip-rule="evenodd" />
                            </svg>
                            <span>Transaksi</span>
                        </a>

                        {{-- [BARU] Top-up --}}
                        <a href="{{ route('admin.topups.index') }}" class="flex items-center gap-x-2 px-4 py-2 rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.topups.index') ? 'bg-gray-800 text-white shadow' : 'text-gray-600 hover:bg-gray-900/10' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11.25a.75.75 0 00-1.5 0v2.5h-2.5a.75.75 0 000 1.5h2.5v2.5a.75.75 0 001.5 0v-2.5h2.5a.75.75 0 000-1.5h-2.5v-2.5z" clip-rule="evenodd" />
                            </svg>
                            <span>Top-up</span>
                        </a>

                    </div>
                </div>

                <div class="hidden sm:flex items-center gap-x-2">
                    <button class="p-2 rounded-full text-gray-600 hover:bg-white hover:shadow-md transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
                    </button>
                    <button class="p-2 rounded-full text-gray-600 hover:bg-white hover:shadow-md transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" /></svg>
                    </button>

                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            {{-- [MODIFIKASI] Trigger dropdown sekarang hanya ikon profil --}}
                            <button class="p-2 rounded-full text-gray-600 hover:bg-white hover:shadow-md transition-all focus:outline-none">
                                <span class="sr-only">Open user menu</span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-6 h-6"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-5.5-2.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0zM10 12a5.99 5.99 0 00-4.793 2.39A6.483 6.483 0 0010 16.5a6.483 6.483 0 004.793-2.11A5.99 5.99 0 0010 12z" clip-rule="evenodd" /></svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            {{-- Konten dropdown tidak berubah --}}
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

                <div class="-me-2 flex items-center lg:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-700 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

            </div>
        </div>
    </div>

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
            
            {{-- [BARU] Link responsif lainnya ditambahkan di sini --}}
            <x-responsive-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.index')">
                {{ __('Pengguna') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.transactions.index')" :active="request()->routeIs('admin.transactions.index')">
                {{ __('Transaksi') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.topups.index')" :active="request()->routeIs('admin.topups.index')">
                {{ __('Top-up') }}
            </x-responsive-nav-link>
        </div>
    </div>
</nav>