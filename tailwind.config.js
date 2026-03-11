import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                etelka: ['Etelka', 'sans-serif'],
            },
            colors: {
                'bals-blue': '#0095DA',
                'bals-red': '#ED1C24',
                'bals-black': '#000000',
                'bals-light-grey': '#B3B3B3',
            },
        },
    },
    plugins: [],
};