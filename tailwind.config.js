import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Outfit', ...defaultTheme.fontFamily.sans],
            },
            dropShadow: {
                'up': [
                    '0 -1px 3px rgb(0, 0, 0, 0.3)',
                    '0 -1px 1px rgb(0, 0, 0, 0.06)'
                ]
            },
            keyframes: {
                fadeIn: {
                    '0%': { opacity: '0' },
                    '20%': { opacity: '0' },
                    '100%': { opacity: '1' } 
                },
                scaleIn: {
                    '0%': { transform: 'scale(0)'},
                    '100%':  { transform: 'scale(1)' }
                },
                slideIn: {
                    '0%': { transform: 'translateY(-100%)' },
                    '100%': { transform: 'translateY(0)' }
                },
                slideInFadeIn: {
                    '0%': { 
                        transform: 'translateY(400%)',
                        opacity: '0'
                    },
                    '100%': { 
                        transform: 'translateY(0)',
                        opacity: '1'
                    }
                }
            },
            animation: {
                fadeBg: 'fadeIn 1.5s ease-out 1',
                fade: 'fadeIn 0.9s ease-in 1',
                scaleIn: 'scaleIn 0.7s ease-out 1',
                slideIn: 'slideIn 0.3s ease-out 1',
                slideInFadeIn: '0.6s slideInFadeIn ease-out 1',
            }
        },
    },

    plugins: [forms],
};
