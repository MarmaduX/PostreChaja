import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vercel from 'vite-plugin-vercel';

export default defineConfig({
    base: process.env.APP_URL,
    plugins: [vercel(),
    ],
});
