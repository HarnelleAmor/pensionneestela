import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/css/custom.css',
                'resources/js/app.js',
                'resources/js/homepage.js',
                'resources/js/logreg.js',
                'resources/js/customer.js',
                'resources/js/manager.js',
                'resources/js/custom.js'
            ],
            refresh: true,
        }),
    ],
});
