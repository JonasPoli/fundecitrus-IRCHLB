/** @type {import('tailwindcss').Config} */
module.exports = {
    darkMode: 'selector',
    content: [
        "./assets/**/*.js",
        "./templates/**/*.html.twig",
    ],
    safelist: [
        'nav-link',
        'nav-link--active',
    ],
    theme: {
        fontFamily: {
            'body': ['Inter', 'sans-serif'],
            'sans': ['Inter', 'sans-serif'],
        },
        extend: {
            colors: {
                // ── Brand Primary (Fundecitrus Green) ──────────────
                'primary': {
                    DEFAULT: '#014040',
                    light:   '#025e5e',
                    dark:    '#002626',
                    50:  '#f0f7f7',
                    100: '#dbebeb',
                    200: '#bcd7d7',
                    300: '#92bcbc',
                    400: '#5f9999',
                    500: '#014040',
                    600: '#013636',
                    700: '#012b2b',
                    800: '#012020',
                    900: '#001818',
                },

                // ── Brand Secondary (Fundecitrus Lime Green) ────────
                'secondary': {
                    DEFAULT: '#B9D04A',
                    light:   '#cbe05c',
                    dark:    '#a3b83b',
                    50:  '#f9fceb',
                    100: '#f1f8cc',
                    200: '#e3f09d',
                    300: '#cfe462',
                    400: '#B9D04A',
                    500: '#a3b83b',
                },


                // ── Semantic Colors ───────────────────────────────
                'success': {
                    DEFAULT: '#059669',
                    light:   '#10b981',
                    dark:    '#047857',
                },
                'danger': {
                    DEFAULT: '#dc2626',
                    light:   '#ef4444',
                    dark:    '#b91c1c',
                },
                'warning': {
                    DEFAULT: '#d97706',
                    light:   '#f59e0b',
                    dark:    '#b45309',
                },
                'info': {
                    DEFAULT: '#0891b2',
                    light:   '#06b6d4',
                    dark:    '#0e7490',
                },
            },

            spacing: {
                '55vw': '55vw',
            },

            container: {
                center: true,
                padding: {
                    DEFAULT: '1rem',
                    sm: '2rem',
                },
                screens: {
                    sm:  '600px',
                    md:  '728px',
                    lg:  '984px',
                    xl:  '1240px',
                    '2xl': '1240px',
                },
            },

            backdropBlur: {
                xs: '2px',
            },

            borderOpacity: {
                '8': '0.08',
            },

            backgroundOpacity: {
                '3': '0.03',
                '8': '0.08',
            },

            animation: {
                'slide-down': 'slideDown 0.25s ease forwards',
                'fade-in':    'fadeIn 0.3s ease forwards',
            },

            keyframes: {
                slideDown: {
                    '0%':   { opacity: '0', transform: 'translateY(-8px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                fadeIn: {
                    '0%':   { opacity: '0' },
                    '100%': { opacity: '1' },
                },
            },
        },
    },
    plugins: [
        // require('@tailwindcss/forms'),   // Uncomment if needed for pub forms
        // require('@tailwindcss/typography'), // Uncomment for blog/rich text content
    ],
}
