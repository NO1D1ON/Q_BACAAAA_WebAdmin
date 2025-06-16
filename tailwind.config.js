import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
    extend: {
        fontFamily: {
            sans: ['Figtree', ...defaultTheme.fontFamily.sans],
        },
        // V V V -- TAMBAHKAN BLOK KODE DI BAWAH INI -- V V V
        colors: {
            'primary': '#E6FADD',    // Warna Hijau Muda
            'secondary': '#28738B',  // Warna Biru Tua/Teal
            'accent': {
                'DEFAULT': '#FF7601', // Warna Oranye Terang
                'light': '#F3A26D',   // Warna Oranye Lembut
            },
        },
        // ^ ^ ^ -- BATAS AKHIR KODE YANG DITAMBAHKAN -- ^ ^ ^
    },
},

    plugins: [forms],
};
