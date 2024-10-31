import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'status': {
                  'planted-bg': '#d1fae5',      // Equivalent to bg-emerald-100
                  'planted-text': '#047857',    // Equivalent to text-emerald-700
                  'growing-bg': '#ede9fe',      // Equivalent to bg-violet-100
                  'growing-text': '#5b21b6',    // Equivalent to text-violet-700
                  'harvested-bg': '#e0f2fe',    // Equivalent to bg-sky-100
                  'harvested-text': '#0369a1',  // Equivalent to text-sky-700
                  'failed-bg': '#fee2e2',       // Equivalent to bg-red-100
                  'failed-text': '#b91c1c'      // Equivalent to text-red-700
                }
            },
        },
    },

    plugins: [forms, typography],
};
