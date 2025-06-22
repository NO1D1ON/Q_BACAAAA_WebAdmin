<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-[#28738B] leading-tight">
            {{ __('Kelola Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-transparent backdrop:blur-[75] overflow-hidden shadow-xl border-[1.8] sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-end mb-6">
                        <a href="{{ route('admin.books.create') }}" class="inline-flex items-center bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg shadow-md transition-transform transform hover:scale-105">
                            <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                            </svg>
                            Tambah Buku
                        </a>
                    </div>
                    
                    @if (session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md relative mb-6" role="alert">
                            <p class="font-bold">Berhasil</p>
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif

                    {{-- [PERBAIKAN] Menggunakan layout daftar kartu vertikal, bukan grid galeri --}}

                    <div class="hidden md:grid md:grid-cols-12 gap-4 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <div class="col-span-5">Buku</div>
                        <div class="col-span-2">Kategori</div>
                        <div class="col-span-2">Rating</div>
                        <div class="col-span-3 text-center">Aksi</div>
                    </div>

                    <div class="space-y-4 mt-2">
                        @forelse ($books as $book)
                            {{-- Setiap buku adalah sebuah kartu dengan x-data untuk modalnya sendiri --}}
                            <div x-data="{ openModal: false }" class="bg-slate-50/[25%] rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200">
                                <div class="grid grid-cols-1 md:grid-cols-12 gap-y-4 md:gap-x-4 items-center p-4">
                                    
                                    <div class="col-span-1 md:col-span-5 flex items-center gap-x-4">
                                        <div class="flex-shrink-0">
                                            @if($book->cover)
                                                <img src="{{ asset('storage/' . $book->cover) }}" alt="Cover Buku" class="h-20 w-14 object-cover rounded shadow">
                                            @else
                                                <div class="h-20 w-14 flex items-center justify-center bg-gray-200 rounded text-xs text-gray-500">No Image</div>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="font-bold text-gray-800">{{ $book->title }}</div>
                                            <div class="text-sm text-gray-600">{{ $book->penulis }}</div>
                                        </div>
                                    </div>

                                    <div class="col-span-1 md:col-span-2 text-sm text-gray-700">
                                        <span class="font-bold md:hidden">Kategori: </span>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800">{{ $book->category->name ?? 'N/A' }}</span>
                                    </div>

                                    <div class="col-span-1 md:col-span-2 flex items-center">
                                        <span class="font-bold md:hidden mr-2">Rating: </span>
                                        <svg class="w-5 h-5 text-yellow-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20"><path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 6.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/></svg>
                                        <span class="ml-1 font-bold">{{ number_format($book->rating, 1) }}</span>
                                    </div>

                                    <div class="col-span-1 md:col-span-3 flex justify-center items-center gap-x-4">
                                        <a href="{{ route('admin.books.edit', $book->id) }}" class="text-gray-500 hover:text-blue-600" title="Edit">
                                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M2.695 14.763l-1.262 3.154a.5.5 0 00.65.65l3.155-1.262a4 4 0 001.343-.885L17.5 5.5a2.121 2.121 0 00-3-3L3.58 13.42a4 4 0 00-.885 1.343z" /></svg>
                                        </a>
                                        <button @click="openModal = true" class="text-gray-500 hover:text-red-600" title="Hapus">
                                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.58.22-2.365.468a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193v-.443A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z" clip-rule="evenodd" /></svg>
                                        </button>
                                    </div>

                                    <div x-show="openModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center overflow-auto bg-black bg-opacity-60" @click.away="openModal = false">
                                        <div class="bg-white rounded-lg shadow-xl p-6 m-4 max-w-sm w-full" @click.stop>
                                            <h3 class="text-lg font-bold text-gray-900">Konfirmasi Penghapusan</h3>
                                            <p class="mt-2 text-sm text-gray-600">Anda yakin ingin menghapus buku **"{{ $book->title }}"**? Tindakan ini tidak dapat diurungkan.</p>
                                            <div class="mt-6 flex justify-end space-x-3">
                                                <button @click="openModal = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">Batal</button>
                                                <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST">
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
                            <div class="text-center py-16 text-gray-500 col-span-full">
                                <p>Belum ada buku yang ditambahkan.</p>
                            </div>
                        @endforelse
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>