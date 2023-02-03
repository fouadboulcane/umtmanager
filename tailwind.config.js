const colors = require('tailwindcss/colors') 
 
module.exports = {
    content: [
        './resources/**/*.blade.php',
        './vendor/filament/**/*.blade.php', 
    ],
    darkMode: 'class',
    theme: {
        extend: {
            colors: { 
                danger: colors.rose,
                // primary: colors.blue,
                primary: {
                  '50': '#eff8fe',
                  '100': '#c8ecff',
                  '200': '#92d5fd',
                  '300': '#53b3f5',
                  '400': '#208ce1',
                  '500': '#086dc4',
                  '600': '#03549e',
                  '700': '#07437e',
                  '800': '#0b3764',
                  '900': '#030a11',
                },
                success: colors.green,
                warning: colors.yellow,
            }, 
            fontSize: {
                'xs': '13px',
                // 'sm': '0.85rem',
                // 'md': '0.9rem',
                // 'lg': '0.1rem',
                // 'xl': '0.1rem',
            },
            borderRadius: {
                'md': '0.2rem',
                'lg': '0.2rem',
                'xl': '0.4rem',
              }
        },
    },
    plugins: [
        require('@tailwindcss/forms'), 
        require('@tailwindcss/typography'), 
    ],
}