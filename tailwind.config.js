import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    safelist: [
        'grid',
        'grid-cols-8',
        'gap-2',
        'border',
        'border-gray-200',
        'rounded-lg',
        'p-2',
        'px-4',
        'py-2',
        'mb-2',
        'mb-3',
        'text-sm',
        'font-medium',
        'rounded-full',
        'w-full',
    ],
 
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
