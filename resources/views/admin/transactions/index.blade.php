<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-[#28738B] leading-tight">
            {{ __('Riwayat Transaksi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-transparent backdrop:blur-[75] overflow-hidden shadow-xl border-[1.8] sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- [PERUBAHAN] Menghapus <table> dan menggantinya dengan layout berbasis Div --}}

                    <div class="hidden md:grid md:grid-cols-12 gap-4 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <div class="col-span-4">Pengguna</div>
                        <div class="col-span-3">Deskripsi</div>
                        <div class="col-span-2 text-right">Jumlah</div>
                        <div class="col-span-3 text-right">Tanggal</div>
                    </div>

                    <div class="space-y-4 mt-2">
                        @forelse ($transactions as $transaction)
                            {{-- [PERUBAHAN] Setiap transaksi adalah sebuah kartu --}}
                            <div class="bg-slate-50/[25%] rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200">
                                {{-- Menggunakan Grid untuk tata letak yang konsisten dan responsif --}}
                                <div class="grid grid-cols-1 md:grid-cols-12 gap-y-3 md:gap-x-4 items-center p-4">
                                    
                                    <div class="col-span-1 md:col-span-4 flex items-center gap-x-4">
                                        {{-- Avatar dengan Inisial Nama --}}
                                        <div class="h-12 w-12 flex-shrink-0 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center">
                                            <span class="text-lg font-semibold">
                                                @php
                                                    // Ambil inisial dari nama user, default 'N/A' jika user tidak ada
                                                    $userName = $transaction->user->nama ?? 'NA';
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
                                            <div class="font-bold text-gray-800">{{ $transaction->user->nama ?? 'Pengguna Dihapus' }}</div>
                                            <div class="text-sm text-gray-500">{{ $transaction->user->email ?? '' }}</div>
                                        </div>
                                    </div>

                                    <div class="col-span-1 md:col-span-3 text-sm text-gray-700">
                                        <p class="font-semibold">{{ $transaction->description }}</p>
                                        @if($transaction->type == 'Top Up')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Top Up
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 text-orange-800">
                                                Pembelian
                                            </span>
                                        @endif
                                    </div>

                                    <div class="col-span-1 md:col-span-2 md:text-right font-medium {{ $transaction->display_amount > 0 ? 'text-green-600' : 'text-red-600' }}">
                                        {{-- Label untuk mobile --}}
                                        <span class="font-bold text-gray-600 md:hidden">Jumlah: </span>
                                        {{ $transaction->display_amount > 0 ? '+' : '-' }} Rp {{ number_format(abs($transaction->display_amount), 0, ',', '.') }}
                                    </div>

                                    <div class="col-span-1 md:col-span-3 md:text-right text-sm text-gray-500">
                                        {{-- Label untuk mobile --}}
                                        <span class="font-bold text-gray-600 md:hidden">Tanggal: </span>
                                        {{ \Carbon\Carbon::parse($transaction->display_date)->format('d M Y, H:i') }}
                                    </div>

                                </div>
                            </div>
                        @empty
                            <div class="text-center py-16 text-gray-500">
                                <p>Belum ada transaksi.</p>
                            </div>
                        @endforelse
                    </div>

                    {{-- Paginasi diletakkan di luar container kartu --}}
                    <div class="mt-6">
                        {{ $transactions->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>