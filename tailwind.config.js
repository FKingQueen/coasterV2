/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Roboto', 'sans-serif'],       // Default body font
        montserrat: ['Montserrat', 'sans-serif'], // Additional custom font
        'norwester': ['Norwester', 'sans-serif'],
        roboto: ['Roboto', 'sans-serif'],  // Add this line
        // Add any other fonts here
      },
      screens: {
        'laptop': '1500px',
        'monitor': '1900px',
      },
    },
  },
  plugins: [],
}

