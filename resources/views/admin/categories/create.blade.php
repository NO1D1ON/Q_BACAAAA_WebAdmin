<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-[#28738B] leading-tight">
            {{ __('Tambah Kategori Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data"
                          x-data="{ filePreview: null, fileName: '' }">
                        @csrf
                        
                        <div class="space-y-6">
                            {{-- Input Nama Kategori --}}
                            <div>
                                <label for="name" class="block font-medium text-sm text-gray-700 pb-2">Nama Kategori</label>
                                <input type="text" name="name" id="name" class="w-full py-2 px-4 rounded-md bg-gray-100 border-gray-300 focus:border-[#28738B] focus:ring focus:ring-[#28738B] focus:ring-opacity-50 transition" value="{{ old('name') }}" required>
                            </div>
                            
                            {{-- Pratinjau Gambar --}}
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Pratinjau Gambar</label>
                                <div class="mt-2 w-full h-48 bg-gray-100 rounded-lg overflow-hidden flex items-center justify-center">
                                    <template x-if="filePreview">
                                        <img :src="filePreview" alt="Image Preview" class="w-full h-full object-cover">
                                    </template>
                                    <template x-if="!filePreview">
                                        <div class="text-center p-4">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <p class="mt-2 text-sm text-gray-500">Pratinjau akan muncul di sini</p>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            {{-- Area Upload Gambar --}}
                            <div>
                                <label for="image" class="block font-medium text-sm text-gray-700">Gambar Kategori</label>
                                <div class="mt-2">
                                    <input id="image" name="image" type="file" class="hidden" required
                                           @change="let file = $event.target.files[0];
                                                    if (file) {
                                                        fileName = file.name;
                                                        let reader = new FileReader();
                                                        reader.onload = (e) => { filePreview = e.target.result };
                                                        reader.readAsDataURL(file);
                                                    }">
                                    <div class="flex items-center">
                                        <label for="image" class="cursor-pointer bg-[#2d3748] text-white font-semibold py-2 px-4 rounded-l-md hover:bg-[#1a202c] transition whitespace-nowrap">
                                            Pilih File
                                        </label>
                                        <div class="flex-1 p-2 border border-l-0 border-gray-300 rounded-r-md bg-white truncate">
                                            <span x-text="fileName || 'Tidak ada file yang dipilih'" class="text-sm text-gray-500"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="flex items-center justify-end mt-8 border-t pt-6">
                            <a href="{{ route('admin.categories.index') }}" class="text-gray-600 hover:text-gray-800 mr-4">Batal</a>
                            <button type="submit" class="inline-flex items-center px-6 py-2 bg-[#28738B] border border-transparent rounded-md font-semibold text-white hover:bg-[#1f5a6d] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#28738B] transition">
                                Simpan Kategori
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- [MODIFIKASI] Script Notifikasi SweetAlert ditambahkan di sini --}}
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success', // Ikon centang
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    position: 'center', // Muncul di tengah
                    showConfirmButton: false, // Tombol OK disembunyikan
                    timer: 2500 // Hilang setelah 2.5 detik
                });
            });
        </script>
    @endif
    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error', // Ikon silang
                    title: 'Gagal!',
                    text: '{{ $errors->first() }}', // Menampilkan pesan error pertama
                    position: 'center', // Muncul di tengah
                    showConfirmButton: false, // Tombol OK disembunyikan
                    timer: 3500 // Hilang setelah 3.5 detik
                });
            });
        </script>
    @endif

</x-app-layout>
