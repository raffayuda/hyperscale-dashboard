import type { Config } from 'tailwindcss';

const config: Config = {
    content: ['./src/**/*.{html,js,svelte,ts}'],
    theme: {
        extend: {
            colors: {
                brand: {
                    primary: '#ffffff',
                    muted: '#a3a3a3'
                }
            },
            fontFamily: {
                sans: ['Inter', 'ui-sans-serif', 'system-ui']
            }
        }
    },
    plugins: []
};

export default config;

