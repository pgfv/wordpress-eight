const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    content: ['./**/*.php'],
    darkMode: 'media', // or 'class'
    theme: {
        extend: {
            typography: {
                DEFAULT: {
                    css: {
                        color: null,
                        strong: {
                            color: null,
                        },
                        h1: {
                            color: null,
                        },
                        h2: {
                            color: null,
                        },
                        h3: {
                            color: null,
                        },
                        h4: {
                            color: null,
                        },
                        h5: {
                            color: null,
                        },
                        h6: {
                            color: null,
                        },
                        figure: {
                            marginTop: null,
                            marginBottom: null,
                        },
                        img: {
                            marginTop: null,
                            marginBottom: null,
                        }
                    }
                }
            }
        },
    },
    variants: {
        extend: {},
    },
    plugins: [
        require('@tailwindcss/typography')
    ],
}
