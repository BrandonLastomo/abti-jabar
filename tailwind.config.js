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
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                heading: ['"Bricolage Grotesque"', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: '#DC2626',
                'on-primary': '#FFFFF0',
                success: '#80ED99',
                warning: '#FFEE32',
                danger: '#EF233C',
                // Additional background/surface colors from the design system
                background: '#F8F9FA',
                card: '#FFFFFF',
            }
        },
    },

    plugins: [forms],
};
