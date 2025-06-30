<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Perbarui Kata Sandi') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Pastikan akun Anda menggunakan kata sandi yang panjang dan acak agar tetap aman.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        {{-- Input untuk Kata Sandi Saat Ini --}}
        <div>
            {{-- [PERUBAIKAN] Menggunakan label standar --}}
            <label for="update_password_current_password" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Kata Sandi Saat Ini') }}</label>
            {{-- [PERUBAIKAN] Menggunakan input standar dengan styling yang diinginkan --}}
            <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password" required
                   class="block w-full rounded-md shadow-sm bg-gray-100 border-transparent focus:border-indigo-500 focus:bg-white focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition duration-150 ease-in-out" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        {{-- Input untuk Kata Sandi Baru --}}
        <div>
            <label for="update_password_password" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Kata Sandi Baru') }}</label>
            <input id="update_password_password" name="password" type="password" autocomplete="new-password" required
                   class="block w-full rounded-md shadow-sm bg-gray-100 border-transparent focus:border-indigo-500 focus:bg-white focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition duration-150 ease-in-out" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        {{-- Input untuk Konfirmasi Kata Sandi Baru --}}
        <div>
            <label for="update_password_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Konfirmasi Kata Sandi Baru') }}</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required
                   class="block w-full rounded-md shadow-sm bg-gray-100 border-transparent focus:border-indigo-500 focus:bg-white focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition duration-150 ease-in-out" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>
                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11.25a.75.75 0 00-1.5 0v4.59L7.3 9.24a.75.75 0 00-1.1 1.02l3.25 3.5a.75.75 0 001.1 0l3.25-3.5a.75.75 0 10-1.1-1.02L10.75 11.34V6.75z" clip-rule="evenodd" />
                </svg>
                {{ __('Simpan') }}
            </x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="text-sm text-green-600 font-medium flex items-center gap-x-2"
                >
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                    </svg>
                    {{ __('Tersimpan.') }}
                </p>
            @endif
        </div>
    </form>
</section>