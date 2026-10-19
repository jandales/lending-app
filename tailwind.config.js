/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./node_modules/tw-elements/dist/js/**/*.js"
  ],
  theme: {
    extend: {
      colors: {
        brand: {
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
        },
        canvas: '#f3f5f9',
      },
      fontFamily: {
        sans: [
          '"Plus Jakarta Sans"',
          'ui-sans-serif',
          'system-ui',
          'sans-serif',
        ],
      },
      borderRadius: {
        '2xl': '1rem',
        '3xl': '1.5rem',
      },
      boxShadow: {
        soft: '0 2px 8px rgb(15 23 42 / 0.04)',
        card: '0 8px 24px rgb(15 23 42 / 0.06)',
        float: '0 12px 40px rgb(15 23 42 / 0.08)',
        glow: '0 8px 28px rgb(37 99 235 / 0.35)',
      },
      backgroundImage: {
        'brand-gradient': 'linear-gradient(135deg, #2563eb 0%, #0ea5e9 55%, #34d399 100%)',
        'brand-gradient-soft': 'linear-gradient(135deg, #3b82f6 0%, #22d3ee 100%)',
      },
    },
  },
  plugins: [
    require('tw-elements/dist/plugin')
  ],
}
