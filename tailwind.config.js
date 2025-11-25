/** @type {import('tailwindcss').Config} */
const defaultTheme = require("tailwindcss/defaultTheme")
export default {
  darkMode: 'class',
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./node_modules/flowbite/**/*.js",
    "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
  ],
  theme: {
    extend: {
      fontFamily: {
        body: [
        'Inter', 
        'ui-sans-serif', 
        'system-ui', 
        '-apple-system', 
        'system-ui', 
        'Segoe UI', 
        'Roboto', 
        'Helvetica Neue', 
        'Arial', 
        'Noto Sans', 
        'sans-serif', 
        'Apple Color Emoji', 
        'Segoe UI Emoji', 
        'Segoe UI Symbol', 
        'Noto Color Emoji'
      ],
        sans: ["Inter var", ...defaultTheme.fontFamily.sans],
      },
      colors: {
        primary: {"50":"#eff6ff","100":"#dbeafe","200":"#bfdbfe","300":"#93c5fd","400":"#60a5fa","500":"#3b82f6","600":"#2563eb","700":"#1d4ed8","800":"#1e40af","900":"#1e3a8a","950":"#172554"}
      }
    },
  },
  plugins: [
    require('flowbite-typography'),
    require("flowbite/plugin")
  ],
  safelist: ['bg-red-100', 'text-red-800', 'bg-yellow-100', 'text-yellow-800', 'bg-green-100', 'text-green-800', 'bg-blue-100', 'text-blue-800', 'bg-cyan-100', 'text-cyan-800', 'bg-stone-100', 'text-stone-800', 'bg-purple-100', 'text-purple-800', 'bg-pink-100', 'text-pink-800', 'bg-lime-100', 'text-lime-800'],
}