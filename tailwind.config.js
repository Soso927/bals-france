import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
 theme: { extend: { fontFamily: { etelka: ['Etelka Narrow Text Pro', 'sans-serif'], }, }, }, plugins: [], }
