<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-[#28738B] leading-tight">
            {{ __('Persetujuan Top Up') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-transparent backdrop:blur-[75] overflow-hidden shadow-xl border-[1.8] sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- Menampilkan pesan sukses setelah redirect --}}
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    {{-- [PERUBAHAN] Menghapus <table> dan menggantinya dengan layout berbasis Div --}}
                    
                    <div class="hidden md:grid md:grid-cols-12 gap-4 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <div class="col-span-4">Pengguna</div>
                        <div class="col-span-3">Nominal</div>
                        <div class="col-span-3">Tanggal Permintaan</div>
                        <div class="col-span-2 text-center">Aksi</div>
                    </div>

                    <div class="space-y-4 mt-2">
                        @forelse ($topUps as $topUp)
                            {{-- [PERUBAHAN] Setiap permintaan top up adalah sebuah kartu --}}
                            <div class="bg-slate-50/[25%] rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200">
                                <div class="grid grid-cols-1 md:grid-cols-12 gap-y-4 md:gap-x-4 items-center p-4">
                                    
                                    <div class="col-span-1 md:col-span-4 flex items-center gap-x-4">
                                        {{-- Avatar dengan Inisial Nama --}}
                                        <div class="h-12 w-12 flex-shrink-0 rounded-full bg-teal-100 text-teal-600 flex items-center justify-center">
                                            <span class="text-lg font-semibold">
                                                @php
                                                    $userName = $topUp->user->nama ?? 'NA';
                                                    $words = explode(' ', $userName);
                                                    $initials = '';
                                                    foreach ($words as $word) {
                                                        $initials .= strtoupper(substr($word, 0, 1));
                                                    }
                                                    echo substr($initials, 0, 2);
                                                @endphp
                                            </span>
                                        </div>
                                        <div>
                                            <div class="font-bold text-gray-800">{{ $topUp->user->nama ?? 'Pengguna Dihapus' }}</div>
                                            <div class="text-sm text-gray-500">{{ $topUp->user->email ?? '' }}</div>
                                        </div>
                                    </div>

                                    <div class="col-span-1 md:col-span-3">
                                        {{-- Label untuk mobile --}}
                                        <span class="font-bold text-gray-600 md:hidden">Nominal: </span>
                                        <span class="font-bold text-lg text-gray-800">
                                            Rp {{ number_format($topUp->nominal, 0, ',', '.') }}
                                        </span>
                                    </div>

                                    <div class="col-span-1 md:col-span-3 text-sm text-gray-500">
                                        {{-- Label untuk mobile --}}
                                        <span class="font-bold text-gray-600 md:hidden">Tanggal: </span>
                                        {{ \Carbon\Carbon::parse($topUp->waktu_permintaan_topup)->format('d M Y, H:i') }}
                                    </div>

                                    <div class="col-span-1 md:col-span-2 flex justify-center items-center gap-x-3">
                                        {{-- Tombol Setujui --}}
                                        <form action="{{ route('admin.topups.approve', $topUp->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-white bg-green-500 hover:bg-green-600 font-bold py-2 px-4 rounded-lg transition-colors duration-200">Setujui</button>
                                        </form>

                                        {{-- Tombol Tolak --}}
                                        <form action="{{ route('admin.topups.reject', $topUp->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-white bg-red-500 hover:bg-red-600 font-bold py-2 px-4 rounded-lg transition-colors duration-200">Tolak</button>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        @empty
                            <div class="text-center py-16 text-gray-500">
                                <p>Tidak ada permintaan top-up yang menunggu persetujuan.</p>
                            </div>
                        @endforelse
                    </div>

                    {{-- Paginasi --}}
                    <div class="mt-6">
                        {{ $topUps->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>