import path from 'path';
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    base: '/build',
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    define: {
        'process.env': {},
    },
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/js'),
        },
    },
    build: {
        // outDir: 'public/build', // Ensure the output directory is correct
        // emptyOutDir: true,
        // manifest: true,
        rollupOptions: {
            external: [
                '/logo.png',
                '/car.webp',
                '/logos/ford.png',
                '/logos/honda.png',
                '/logos/ford.png',
                '/logos/hyundai.png',
                '/logos/kia.png',
                '/logos/mazda.png',
                '/logos/mitsubishi.png',
                '/logos/suzuki.png',
                '/logos/toyota.png',
            ],
            output: {
                chunkFileNames: 'assets/[name]-[hash].js',
                entryFileNames: 'assets/[name]-[hash].js',
                assetFileNames: 'assets/[name]-[hash][extname]',
            },
        },
    },
});
