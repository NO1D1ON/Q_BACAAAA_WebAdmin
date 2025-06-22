<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-[#28738B] leading-tight">
            {{ __('Kelola Kategori') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-transparent backdrop:blur-[75] overflow-hidden shadow-xl border-[1.8] sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-end mb-6">
                        <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg shadow-md transition-transform transform hover:scale-105">
                            <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                            </svg>
                            Tambah Kategori
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md relative mb-6" role="alert">
                             <p class="font-bold">Berhasil</p>
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif

                    {{-- [PERUBAHAN] Mengganti <table> dengan layout daftar kartu vertikal --}}

                    <div class="hidden md:grid md:grid-cols-12 gap-4 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <div class="col-span-1 text-center">No</div>
                        <div class="col-span-8">Kategori</div>
                        <div class="col-span-3 text-center">Aksi</div>
                    </div>

                    <div class="space-y-4 mt-2">
                        @forelse ($categories as $category)
                            {{-- Setiap kategori adalah sebuah kartu dengan x-data untuk modalnya sendiri --}}
                            <div x-data="{ openModal: false }" class="bg-slate-50/[25%] rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200">
                                <div class="grid grid-cols-1 md:grid-cols-12 gap-y-4 md:gap-x-4 items-center p-4">

                                    <div class="col-span-1 md:col-span-1 flex justify-center items-center">
                                        <span class="text-lg font-bold text-gray-500">{{ $loop->iteration }}</span>
                                    </div>
                                    
                                    <div class="col-span-1 md:col-span-8 flex items-center gap-x-4">
                                        <div class="flex-shrink-0">
                                            @if($category->image_path)
                                                <img src="{{ asset('storage/' . $category->image_path) }}" alt="{{ $category->name }}" class="h-16 w-16 object-cover rounded-md shadow">
                                            @else
                                                <div class="h-16 w-16 flex items-center justify-center bg-gray-200 rounded-md text-xs text-gray-500">
                                                    <svg class="w-8 h-8 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" /></svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="font-bold text-gray-800">{{ $category->name }}</div>
                                            <div class="text-sm text-gray-500 font-mono">{{ $category->slug }}</div>
                                        </div>
                                    </div>

                                    <div class="col-span-1 md:col-span-3 flex justify-center items-center gap-x-4">
                                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="text-gray-500 hover:text-blue-600" title="Edit">
                                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M2.695 14.763l-1.262 3.154a.5.5 0 00.65.65l3.155-1.262a4 4 0 001.343-.885L17.5 5.5a2.121 2.121 0 00-3-3L3.58 13.42a4 4 0 00-.885 1.343z" /></svg>
                                        </a>
                                        <button @click="openModal = true" class="text-gray-500 hover:text-red-600" title="Hapus">
                                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.58.22-2.365.468a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193v-.443A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z" clip-rule="evenodd" /></svg>
                                        </button>
                                    </div>

                                    <div x-show="openModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center overflow-auto bg-black bg-opacity-60" @click.away="openModal = false">
                                        <div class="bg-white rounded-lg shadow-xl p-6 m-4 max-w-sm w-full" @click.stop>
                                            <h3 class="text-lg font-bold text-gray-900">Konfirmasi Penghapusan</h3>
                                            <p class="mt-2 text-sm text-gray-600">Anda yakin ingin menghapus kategori **"{{ $category->name }}"**? Tindakan ini tidak dapat diurungkan.</p>
                                            <div class="mt-6 flex justify-end space-x-3">
                                                <button @click="openModal = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">Batal</button>
                                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700">Ya, Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-16 text-gray-500">
                                <p>Belum ada kategori yang ditambahkan.</p>
                            </div>
                        @endforelse
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>