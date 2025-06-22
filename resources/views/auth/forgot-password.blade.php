<x-guest-layout :image="asset('assets/lupaPassword.png')">
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Sekalipun manusia diberi akal luar biasa untuk menyimpan pengetahuan semesta, tetap saja satu kata sandi bisa terlupa. Tak apa, masukkan email untuk mengubah kata sandi') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="w-full pl-10 py-2 rounded-md bg-[#E6FADD] text-gray-800 focus:ring-0 focus:outline-none" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="w-full flex justify-center py-3 px-4 border border-transparent font-semibold rounded-md text-white bg-[#28738B] hover:bg-custom-primary-hover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-custom-primary transition-colors duration-300">>
                {{ __('Kirim Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
