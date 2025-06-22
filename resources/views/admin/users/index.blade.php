<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-[#28738B] leading-tight">
            {{ __('Kelola Pengguna Aplikasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-transparent backdrop:blur-[75] overflow-hidden shadow-xl border-[1.8] sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    {{-- [PERUBAHAN] Menghapus <table> dan menggantinya dengan layout berbasis Div --}}
                    
                    <!-- Header untuk daftar (pengganti thead) -->
                    <div class="hidden md:grid md:grid-cols-12 gap-4 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <div class="col-span-4">Nama</div>
                        <div class="col-span-2">Saldo</div>
                        <div class="col-span-2">Status</div>
                        <div class="col-span-4 text-center">Aksi</div>
                    </div>

                    <!-- Container untuk daftar kartu pengguna -->
                    <div class="space-y-4 mt-2">
                        @forelse ($users as $user)
                            {{-- [PERUBAHAN] Setiap baris adalah sebuah kartu --}}
                            <div class="bg-slate-50/[25%] rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200">
                                {{-- Menggunakan Grid untuk tata letak yang konsisten dan responsif --}}
                                <div class="grid grid-cols-1 md:grid-cols-12 gap-y-4 md:gap-x-4 items-center p-4">
                                    
                                    <!-- Kolom Nama & Email -->
                                    <div class="col-span-1 md:col-span-4 flex items-center gap-x-4">
                                        {{-- Avatar dengan Inisial Nama --}}
                                        <div class="h-12 w-12 flex-shrink-0 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center">
                                            <span class="text-lg font-semibold">
                                                {{-- Mengambil inisial dari nama --}}
                                                @php
                                                    $words = explode(' ', $user->nama);
                                                    $initials = '';
                                                    foreach ($words as $word) {
                                                        $initials .= strtoupper(substr($word, 0, 1));
                                                    }
                                                    echo substr($initials, 0, 2);
                                                @endphp
                                            </span>
                                        </div>
                                        <div>
                                            <div class="font-bold text-gray-800">{{ $user->nama }}</div>
                                            <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                        </div>
                                    </div>

                                    <!-- Kolom Saldo -->
                                    <div class="col-span-1 md:col-span-2 text-sm text-gray-700">
                                        {{-- Label untuk mobile --}}
                                        <span class="font-bold md:hidden">Saldo: </span>
                                        Rp {{ number_format($user->saldo, 0, ',', '.') }}
                                    </div>

                                    <!-- Kolom Status -->
                                    <div class="col-span-1 md:col-span-2">
                                        @if($user->is_active)
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Aktif
                                            </span>
                                        @else
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Diblokir
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Kolom Aksi -->
                                    <div class="col-span-1 md:col-span-4 text-center">
                                        <form action="{{ route('admin.users.toggleStatus', $user->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="font-bold py-2 px-4 rounded-lg text-white transition-colors duration-200
                                                @if($user->is_active) bg-red-500 hover:bg-red-600 @else bg-green-500 hover:bg-green-600 @endif">
                                                {{ $user->is_active ? 'Blokir' : 'Aktifkan' }}
                                            </button>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        @empty
                            <div class="text-center py-12 text-gray-500">
                                <p>Belum ada pengguna terdaftar.</p>
                            </div>
                        @endforelse
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>