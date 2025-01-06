import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    darkMode: 'class',

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'spring-wood': '#F2F0E7',
                'avocado': '#7F8A56',
                'regal-blue': '#1D2955',
                'akaroa': '#D8CAA7',
                'rose': '#AC274F',
            },
        },
    },

    plugins: [
        forms,
        require('daisyui'),
    ],
};
