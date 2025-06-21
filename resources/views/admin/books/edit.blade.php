<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{-- Menggunakan judul buku yang sedang diedit --}}
            {{ __('Edit Buku: ') }} {{ $book->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- Form ini akan mengirim data ke fungsi 'update' di BookController --}}
                    <form action="{{ route('admin.books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        {{-- Method PUT/PATCH wajib untuk proses update di Laravel --}}
                        @method('PUT')
                        
                        <!-- Judul -->
                        <div class="mb-4">
                            <label for="title" class="block font-medium text-sm text-gray-700">Judul</label>
                            {{-- Mengisi nilai input dengan data lama --}}
                            <input type="text" name="title" id="title" class="block mt-1 w-full rounded-md shadow-sm" value="{{ old('title', $book->title) }}" required>
                        </div>
                        
                        <!-- Penulis -->
                        <div class="mb-4">
                            <label for="author" class="block font-medium text-sm text-gray-700">Penulis</label>
                             {{-- Mengisi nilai input dengan data lama --}}
                            <input type="text" name="author" id="author" class="block mt-1 w-full rounded-md shadow-sm" value="{{ old('author', $book->penulis) }}" required>
                        </div>

                        <!-- Kategori -->
                        <div class="mb-4">
                            <label for="category_id" class="block font-medium text-sm text-gray-700">Kategori</label>
                            <select name="category_id" id="category_id" class="block mt-1 w-full rounded-md shadow-sm" required>
                                @foreach ($categories as $category)
                                    {{-- Memilih kategori yang sesuai dengan data lama --}}
                                    <option value="{{ $category->id }}" @if($category->id == old('category_id', $book->category_id)) selected @endif>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Harga -->
                        <div class="mb-4">
                            <label for="price" class="block font-medium text-sm text-gray-700">Harga</label>
                            <input type="number" name="price" id="price" class="block mt-1 w-full rounded-md shadow-sm" value="{{ old('price', $book->harga) }}" required>
                        </div>
                        
                        <!-- Rating -->
                        <div class="mb-4">
                            <label for="rating" class="block font-medium text-sm text-gray-700">Rating</label>
                            <input type="number" name="rating" id="rating" step="0.1" min="0" max="5" class="block mt-1 w-full rounded-md shadow-sm" value="{{ old('rating', $book->rating) }}">
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-4">
                            <label for="description" class="block font-medium text-sm text-gray-700">Deskripsi</label>
                            <textarea name="description" id="description" rows="4" class="block mt-1 w-full rounded-md shadow-sm">{{ old('description', $book->deskripsi) }}</textarea>
                        </div>
                        
                        <!-- Gambar Cover Saat Ini -->
                        <div class="mb-4">
                            <label class="block font-medium text-sm text-gray-700">Cover Saat Ini</label>
                            @if($book->cover)
                                <img src="{{ asset('storage/' . $book->cover) }}" alt="Cover" class="h-40 mt-2 rounded">
                            @else
                                <p class="mt-2 text-gray-500">Tidak ada gambar cover.</p>
                            @endif
                        </div>
                        
                        <!-- Ganti Gambar Cover -->
                        <div class="mb-4">
                            <label for="cover" class="block font-medium text-sm text-gray-700">Ganti Gambar Cover (Opsional)</label>
                            <input type="file" name="cover" id="cover" class="block mt-1 w-full">
                        </div>

                        <!-- File E-book Saat Ini -->
                        <div class="mb-4">
                            <label class="block font-medium text-sm text-gray-700">File E-book Saat Ini</label>
                             @if($book->file_path)
                                <p class="mt-2 text-indigo-600">{{ $book->file_path }}</p>
                            @else
                                <p class="mt-2 text-gray-500">Tidak ada file e-book.</p>
                            @endif
                        </div>

                        <!-- Ganti File E-book -->
                        <div class="mb-4">
                            <label for="file_path" class="block font-medium text-sm text-gray-700">Ganti File E-book (Opsional)</label>
                            <input type="file" name="file_path" id="file_path" class="block mt-1 w-full">
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.books.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Batal</a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update Buku
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
