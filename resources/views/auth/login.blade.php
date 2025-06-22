<x-guest-layout :image="asset('assets/8637201.png')">
    {{-- Header Form --}}
    <div class="mb-8 text-center">
        <h2 class="mt-4 text-2xl font-bold" style="color: #28738B;">
            Halo!
        </h2>
        <p class="text-sm text-gray-500">Masuk Untuk Melanjutkan</p>
    </div>

    {{-- Tambahkan pembungkus agar lebarnya seragam --}}
    <div class="w-full max-w-md mx-auto space-y-6">
        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            {{-- Input Email --}}
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="h-5 w-5 text-[#28738B]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M3 4a2 2 0 00-2 2v1.161l8.441 4.221a1.25 1.25 0 001.118 0L19 7.161V6a2 2 0 00-2-2H3z" />
                        <path d="M19 8.839l-7.77 3.885a2.75 2.75 0 01-2.46 0L1 8.839V14a2 2 0 002 2h14a2 2 0 002-2V8.839z" />
                    </svg>
                </div>
                <x-text-input id="email"
                              name="email"
                              type="email"
                              class="w-full pl-10 py-2 rounded-md bg-[#E6FADD] text-gray-800 focus:ring-0 focus:outline-none"
                              :value="old('email')"
                              required
                              autofocus
                              autocomplete="username"
                              placeholder="Email" />
                
                {{-- [PERBAIKAN] Hapus pesan error lama dari sini --}}
                {{-- <x-input-error :messages="$errors->get('email')" class="mt-2" /> --}}
            </div>

            {{-- Input Password --}}
            <div class="relative">
                 <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="h-5 w-5 text-[#28738B]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd" />
                    </svg>
                </div>
                <x-text-input id="password"
                              name="password"
                              type="password"
                              class="w-full pl-10 py-2 rounded-md bg-[#E6FADD] text-gray-800 focus:ring-0 focus:outline-none"
                              required
                              autocomplete="current-password"
                              placeholder="Password" />
                
                {{-- [PERBAIKAN] Hapus pesan error lama dari sini --}}
                {{-- <x-input-error :messages="$errors->get('password')" class="mt-2" /> --}}
            </div>

            {{-- Remember Me & Forgot Password --}}
            <div class="flex items-center justify-between">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me"
                           type="checkbox"
                           class="rounded border-gray-300 text-custom-primary shadow-sm focus:ring-custom-primary"
                           name="remember">
                    <span class="ms-2 text-sm text-gray-600">{{ __('Ingat Saya') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-sm text-gray-600 hover:text-gray-900 hover:underline rounded-md"
                       href="{{ route('password.request') }}">
                        {{ __('Lupa Password?') }}
                    </a>
                @endif
            </div>

            {{-- Tombol Log In --}}
            <div class="pt-4">
                <button type="submit"
                        class="w-full flex justify-center py-3 px-4 border border-transparent font-semibold rounded-md text-white bg-[#28738B] hover:bg-opacity-80 focus:outline-none transition-colors duration-300">
                    {{ __('Masuk') }}
                </button>
            </div>
        </form>
    </div>

    {{-- [PERBAIKAN UTAMA] Tambahkan script untuk SweetAlert2 di sini --}}
    @if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Login Gagal',
                html: 'Email atau password yang Anda masukkan salah.<br>Silakan coba lagi.',
                confirmButtonText: 'OK',
                confirmButtonColor: '#28738B',

                // Tambahkan class untuk kontrol ukuran tombol
                customClass: {
                    confirmButton: 'py-2 px-6 text-base rounded-md'
                }
            });
        });
    </script>
    @endif
</x-guest-layout>
