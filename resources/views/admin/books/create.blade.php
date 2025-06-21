<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Buku Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="title" class="block font-medium text-sm text-gray-700">Judul</label>
                            <input type="text" name="title" id="title" class="block mt-1 w-full rounded-md shadow-sm" required>
                        </div>
                        
                        <div class="mb-4">
                            <label for="author" class="block font-medium text-sm text-gray-700">Penulis</label>
                            <input type="text" name="author" id="author" class="block mt-1 w-full rounded-md shadow-sm" required>
                        </div>

                        <div class="mb-4">
                            <label for="category_id" class="block font-medium text-sm text-gray-700">Kategori</label>
                            <select name="category_id" id="category_id" class="block mt-1 w-full rounded-md shadow-sm" required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label for="price" class="block font-medium text-sm text-gray-700">Harga</label>
                            <input type="number" name="price" id="price" class="block mt-1 w-full rounded-md shadow-sm" required>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block font-medium text-sm text-gray-700">Deskripsi</label>
                            <textarea name="description" id="description" rows="4" class="block mt-1 w-full rounded-md shadow-sm"></textarea>
                        </div>
                        
                        <div class="mb-4">
                            <label for="cover" class="block font-medium text-sm text-gray-700">Gambar Cover</label>
                            <input type="file" name="cover" id="cover" class="block mt-1 w-full">
                        </div>

                        <div class="mb-4">
                            <label for="file_path" class="block font-medium text-sm text-gray-700">File E-book (EPUB, PDF, dll)</label>
                            <input type="file" name="file_path" id="file_path" class="block mt-1 w-full" required>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>