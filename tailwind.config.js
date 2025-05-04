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
                'primary': {
                    50: '#f8f8f8',
                    100: '#f0f0f0',
                    200: '#e4e4e4',
                    300: '#d1d1d1',
                    400: '#b4b4b4',
                    500: '#9a9a9a',
                    600: '#818181',
                    700: '#6a6a6a',
                    800: '#3a3a3a',
                    900: '#1a1a1a',
                    950: '#0a0a0a',
                },
                'accent': {
                    50: '#f5f5f5',
                    100: '#e0e0e0',
                    200: '#c2c2c2',
                    300: '#a3a3a3',
                    400: '#858585',
                    500: '#666666',
                    600: '#525252',
                    700: '#3d3d3d',
                    800: '#292929',
                    900: '#141414',
                    950: '#0a0a0a',
                },
                'blue': {
                    50: '#eff6ff',
                    100: '#dbeafe',
                    200: '#bfdbfe',
                    300: '#93c5fd',
                    400: '#60a5fa',
                    500: '#3b82f6',
                    600: '#2563eb',
                    700: '#1d4ed8',
                    800: '#1e40af',
                    900: '#1e3a8a',
                    950: '#172554',
                },
                'gray': {
                    50: '#f9fafb',
                    100: '#f3f4f6',
                    200: '#e5e7eb',
                    300: '#d1d5db',
                    400: '#9ca3af',
                    500: '#6b7280',
                    600: '#4b5563',
                    700: '#374151',
                    800: '#1f2937',
                    900: '#111827',
                    950: '#030712',
                },
                'teal': {
                    50: '#f0fdfa',
                    100: '#ccfbf1',
                    200: '#99f6e4',
                    300: '#5eead4',
                    400: '#2dd4bf',
                    500: '#14b8a6',
                    600: '#0d9488',
                    700: '#0f766e',
                    800: '#115e59',
                    900: '#134e4a',
                    950: '#042f2e',
                },
            },
        },
    },

    plugins: [forms],
};
