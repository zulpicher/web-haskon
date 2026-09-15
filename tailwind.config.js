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

            colors: {
                haskon: {
                    background: '#ffffff',
                    surface: '#f8f9fa',
                    dark: '#212529',

                    primary: '#212529',
                    accent: '#c9a84c',
                    'accent-soft': '#fff3dc',

                    text: '#212529',
                    muted: '#6c757d',
                    inverted: '#ffffff',

                    border: '#e9ecef',

                    success: '#2b8a3e',
                    danger: '#c92a2a',
                },
            },
        },
    },

    plugins: [forms],
};
