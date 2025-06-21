<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Kategori') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-end mb-4">
                        <a href="{{ route('admin.categories.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Tambah Kategori
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
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Slug</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Gambar</th>
                                <th scope="col" class="relative px-6 py-3 text-center">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($categories as $category)
                                {{-- [PERBAIKAN] Bungkus setiap baris dengan x-data untuk modalnya sendiri --}}
                                <tr x-data="{ openModal: false }">
                                    <td class="px-6 py-4 whitespace-nowrap text-center">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">{{ $category->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap align-middle text-center">{{ $category->slug }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center align-middle">
                                        @if($category->image_path)
                                            <img src="{{ asset('storage/' . $category->image_path) }}" alt="{{ $category->name }}"
                                                class="h-10 w-16 object-cover rounded inline-block">
                                        @else
                                            <span class="text-xs text-gray-500">No Image</span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                        
                                        {{-- [PERBAIKAN] Tombol Hapus sekarang memicu modal Alpine.js --}}
                                        <button @click="openModal = true" class="text-red-600 hover:text-red-900 ml-4">Hapus</button>

                                        {{-- [MODAL KONFIRMASI] --}}
                                        <div x-show="openModal" x-cloak 
                                             class="fixed inset-0 z-50 flex items-center justify-center overflow-auto bg-black bg-opacity-50"
                                             @click.away="openModal = false">
                                            <div class="bg-white rounded-lg shadow-xl p-6 m-4 max-w-sm" @click.stop>
                                                <h3 class="text-lg font-bold text-gray-900 text-left">Konfirmasi Penghapusan</h3>
                                                <p class="mt-2 text-sm text-gray-600 text-left">Anda yakin ingin menghapus kategori ini?</p>
                                                <div class="mt-4 flex justify-end space-x-2">
                                                    <button @click="openModal = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">
                                                        Batal
                                                    </button>
                                                    {{-- Form penghapusan sekarang ada di dalam tombol konfirmasi --}}
                                                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline">
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
                                    <td colspan="5" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                                        Belum ada kategori.
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