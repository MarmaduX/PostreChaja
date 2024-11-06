import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vercel from 'vite-plugin-vercel';

export default defineConfig({
    server: {
        port: process.env.PORT ? parseInt(process.env.PORT) : 3000,
    },
    base: process.env.APP_URL,
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
        vercel(),
    ],
});
