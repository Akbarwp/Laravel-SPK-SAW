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
                plusJakartaSans: ['Plus Jakarta Sans'],
                spaceGrotesk: ['Space Grotesk'],
            },
            colors: {
                'background-cover': '#7F8A56',
                'background-cover-dark': '#1D2955',

                'background': '#FFFFFF',
                'background-dark': '#1D2955',

                'sidebar-background': '#F2F0E7',
                'sidebar-primary': '#7F8A56',
                'sidebar-background-dark': '#D8CAA7',
                'sidebar-primary-dark': '#1D2955',

                'primary-color': '#7F8A56',
                'secondary-color': '#F2F0E7',
                'primary-color-dark': '#1D2955',
                'secondary-color-dark': '#D8CAA7',
            },
        },
    },

    plugins: [
        forms,
        require('daisyui'),
    ],
};
