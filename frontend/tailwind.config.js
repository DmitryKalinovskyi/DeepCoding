/** @type {import('tailwindcss').Config} */
export default {
  important: true,
  content: ['./src/**/*.{js,jsx,ts,tsx}'],
  theme: {
    extend: {
      height: {
        'footer': "var(--footer-size)",
        'header': "var(--header-size)",
        'tinyHeader': "var(--tiny-header-size)"
      }
    },
    container:{
      center: true
    },
    fontSize: {
      sm: '0.8rem',
      base: '1rem',
      lg: [	"1.125rem", "1.75rem"],
      xl: '1.25rem',
      '2xl': '1.563rem',
      '3xl': '1.953rem',
      '4xl': '2.441rem',
      '5xl': '3.052rem',
    }
  },
  plugins: [],
}

