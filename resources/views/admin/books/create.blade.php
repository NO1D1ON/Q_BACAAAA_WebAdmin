<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-[#28738B] leading-tight">
            {{ __('Tambah Buku Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data"
                          x-data="{ 
                              coverPreview: null, 
                              coverName: '',
                              bookFileName: '' 
                          }">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                            
                            {{-- KOLOM KIRI: DETAIL BUKU --}}
                            <div class="space-y-6">
                                <div>
                                    <label for="title" class="block font-medium text-sm text-gray-700">Judul</label>
                                    <input type="text" name="title" id="title" class="mt-1 w-full py-2 px-4 rounded-md bg-gray-100 border-gray-300 focus:border-[#28738B] focus:ring focus:ring-[#28738B] focus:ring-opacity-50 transition" value="{{ old('title') }}" required>
                                </div>
                                
                                <div>
                                    <label for="author" class="block font-medium text-sm text-gray-700">Penulis</label>
                                    <input type="text" name="author" id="author" class="mt-1 w-full py-2 px-4 rounded-md bg-gray-100 border-gray-300 focus:border-[#28738B] focus:ring focus:ring-[#28738B] focus:ring-opacity-50 transition" value="{{ old('author') }}" required>
                                </div>

                                <div>
                                    <label for="category_id" class="block font-medium text-sm text-gray-700">Kategori</label>
                                    <select name="category_id" id="category_id" class="mt-1 w-full py-2 px-4 rounded-md bg-gray-100 border-gray-300 focus:border-[#28738B] focus:ring focus:ring-[#28738B] focus:ring-opacity-50 transition" required>
                                        <option value="">Pilih Kategori</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div>
                                    <label for="price" class="block font-medium text-sm text-gray-700">Harga</label>
                                    <input type="number" name="price" id="price" min="0" class="mt-1 w-full py-2 px-4 rounded-md bg-gray-100 border-gray-300 focus:border-[#28738B] focus:ring focus:ring-[#28738B] focus:ring-opacity-50 transition" value="{{ old('price') }}" required>
                                </div>

                                <div>
                                    <label for="description" class="block font-medium text-sm text-gray-700">Deskripsi</label>
                                    <textarea name="description" id="description" rows="5" class="mt-1 w-full py-2 px-4 rounded-md bg-gray-100 border-gray-300 focus:border-[#28738B] focus:ring focus:ring-[#28738B] focus:ring-opacity-50 transition">{{ old('description') }}</textarea>
                                </div>
                            </div>

                            {{-- KOLOM KANAN: FILE UPLOADS --}}
                            <div class="space-y-6">
                                {{-- Pratinjau Gambar Cover --}}
                                <div>
                                    <label class="block font-medium text-sm text-gray-700">Pratinjau Cover</label>
                                    <div class="mt-1 w-full h-48 bg-gray-100 rounded-lg overflow-hidden flex items-center justify-center">
                                        <template x-if="coverPreview">
                                            <img :src="coverPreview" alt="Cover Preview" class="w-full h-full object-cover">
                                        </template>
                                        <template x-if="!coverPreview">
                                            <div class="text-center p-4">
                                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true"><path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>
                                                <p class="mt-2 text-sm text-gray-500">Pratinjau cover akan muncul di sini</p>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                                
                                {{-- Input Gambar Cover --}}
                                <div>
                                    <label for="cover" class="block font-medium text-sm text-gray-700">Gambar Cover</label>
                                    <div class="mt-1">
                                        <input id="cover" name="cover" type="file" class="hidden"
                                               @change="let file = $event.target.files[0]; if (file) { coverName = file.name; let reader = new FileReader(); reader.onload = (e) => { coverPreview = e.target.result }; reader.readAsDataURL(file); }">
                                        <div class="flex items-center">
                                            <label for="cover" class="cursor-pointer bg-[#2d3748] text-white font-semibold py-2 px-4 rounded-l-md hover:bg-[#1a202c] transition whitespace-nowrap">Pilih File</label>
                                            <div class="flex-1 p-2 border border-l-0 border-gray-300 rounded-r-md bg-white truncate"><span x-text="coverName || 'Tidak ada file yang dipilih'" class="text-sm text-gray-500"></span></div>
                                        </div>
                                    </div>
                                </div>
                                
                                {{-- Input File E-book --}}
                                <div>
                                    <label for="file_path" class="block font-medium text-sm text-gray-700">File E-book (PDF, EPUB)</label>
                                    <div class="mt-1">
                                        <input id="file_path" name="file_path" type="file" class="hidden" required @change="bookFileName = $event.target.files[0] ? $event.target.files[0].name : ''">
                                        <div class="flex items-center">
                                            <label for="file_path" class="cursor-pointer bg-[#2d3748] text-white font-semibold py-2 px-4 rounded-l-md hover:bg-[#1a202c] transition whitespace-nowrap">Pilih File</label>
                                            <div class="flex-1 p-2 border border-l-0 border-gray-300 rounded-r-md bg-white truncate"><span x-text="bookFileName || 'Tidak ada file yang dipilih'" class="text-sm text-gray-500"></span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="flex items-center justify-end mt-8 border-t pt-6">
                            <a href="{{ route('admin.books.index') }}" class="text-gray-600 hover:text-gray-800 mr-4">Batal</a>
                            <button type="submit" class="inline-flex items-center px-6 py-2 bg-[#28738B] border border-transparent rounded-md font-semibold text-white hover:bg-[#1f5a6d] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#28738B] transition">
                                Simpan Buku
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Script Notifikasi SweetAlert --}}
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() { Swal.fire({ icon: 'success', title: 'Berhasil!', text: '{{ session('success') }}', position: 'center', showConfirmButton: false, timer: 2500 }); });
        </script>
    @endif
    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() { Swal.fire({ icon: 'error', title: 'Gagal!', text: '{{ $errors->first() }}', position: 'center', showConfirmButton: false, timer: 3500 }); });
        </script>
    @endif

</x-app-layout>
