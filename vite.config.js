import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
mix.js('resources/js/product-selection.js', 'public/js')

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js', 'resources/js/product-selection.js'],
            refresh: true,
        }),
    ],
});
