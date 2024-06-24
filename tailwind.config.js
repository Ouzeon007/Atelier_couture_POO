/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./Public/index.php",
    "./Public/*.{html,js}"
  ],
  theme: {
    extend: {},
  },
  plugins: [
    require('tailwind-scrollbar'),
  ],
}

