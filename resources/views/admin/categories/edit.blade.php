<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Kategori') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('categories.update', $category->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div>
                            <label for="name" class="block font-medium text-sm text-gray-700">Nama Kategori</label>
                            <input type="text" name="name" id="name" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ $category->name }}" required>
                        </div>
                        <div class="mb-4">
                            <label class="block font-medium text-sm text-gray-700">Gambar Saat Ini</label>
                            @if($category->image_path)
                                <img src="{{ asset('storage/' . $category->image_path) }}" alt="{{ $category->name }}" class="h-20 mt-2 rounded">
                            @else
                                <p class="mt-2 text-gray-500">Tidak ada gambar.</p>
                            @endif
                        </div>
                        <div class="mb-4">
                            <label for="image" class="block font-medium text-sm text-gray-700">Ganti Gambar (Opsional)</label>
                            <input type="file" name="image" id="image" class="block mt-1 w-full">
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>