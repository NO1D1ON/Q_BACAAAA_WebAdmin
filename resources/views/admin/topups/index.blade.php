<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Persetujuan Top Up') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- Menampilkan pesan sukses setelah redirect --}}
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Pengguna</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Nominal</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Permintaan</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($topUps as $topUp)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">{{ $topUp->user->nama ?? 'Pengguna Tidak Ditemukan' }}</td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-center">Rp {{ number_format($topUp->nominal, 0, ',', '.') }}</td>
                                    
                                    {{-- [PERBAIKAN UTAMA] Ganti 'created_at' menjadi 'waktu_permintaan_topup' --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        {{-- Carbon akan secara otomatis mem-parse kolom timestamp ini --}}
                                        {{ \Carbon\Carbon::parse($topUp->waktu_permintaan_topup)->format('d M Y, H:i') }}
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        {{-- Tombol Setujui --}}
                                        <form action="{{ route('admin.topups.approve', $topUp->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-white bg-green-500 hover:bg-green-700 font-bold py-1 px-3 rounded">Setujui</button>
                                        </form>

                                        {{-- Tombol Tolak --}}
                                        <form action="{{ route('admin.topups.reject', $topUp->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-white bg-red-500 hover:bg-red-700 font-bold py-1 px-3 rounded ml-2">Tolak</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                                        Tidak ada permintaan top-up yang menunggu persetujuan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- Menampilkan link paginasi --}}
                    <div class="mt-6">
                        {{ $topUps->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>