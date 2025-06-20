<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-end mb-4">
                        <a href="{{ route('admin.books.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Tambah Buku
                        </a>
                    </div>
                    
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cover</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penulis</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rating</th>
                                {{-- [PERBAIKAN #1] Tambahkan header untuk kolom Aksi --}}
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider align-middle">Aksi</th>

                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($books as $book)
                                {{-- [PERBAIKAN #2] Bungkus baris dengan x-data untuk modal --}}
                                <tr x-data="{ openModal: false }">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($book->cover)
                                            <img src="{{ asset('storage/' . $book->cover) }}" alt="Cover Buku" class="h-16 w-12 object-cover rounded shadow">
                                        @else
                                            <div class="h-16 w-12 flex items-center justify-center bg-gray-200 rounded text-xs text-gray-500">No Image</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $book->title }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $book->penulis }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $book->category->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 text-yellow-400 me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                                <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 6.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                                            </svg>
                                            <span class="font-bold">{{ $book->rating }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('admin.books.edit', $book->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                        
                                        {{-- [PERBAIKAN #3] Ganti tombol hapus untuk memicu modal --}}
                                        <button @click="openModal = true" class="text-red-600 hover:text-red-900 ml-4">Hapus</button>

                                        {{-- Modal Konfirmasi Penghapusan --}}
                                        <div x-show="openModal" x-cloak 
                                             class="fixed inset-0 z-50 flex items-center justify-center overflow-auto bg-black bg-opacity-50"
                                             @click.away="openModal = false">
                                            <div class="bg-white rounded-lg shadow-xl p-6 m-4 max-w-sm" @click.stop>
                                                <h3 class="text-lg font-bold text-gray-900 text-left">Konfirmasi Penghapusan</h3>
                                                <p class="mt-2 text-sm text-gray-600 text-left">Anda yakin ingin menghapus buku ini?</p>
                                                <div class="mt-4 flex justify-end space-x-2">
                                                    <button @click="openModal = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">
                                                        Batal
                                                    </button>
                                                    <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700">
                                                            Ya, Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                                        Belum ada buku.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
