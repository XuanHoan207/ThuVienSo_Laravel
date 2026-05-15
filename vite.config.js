import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/author-detail.css',
                'resources/css/authors.css',
                'resources/css/books-detail.css',
                'resources/css/books.css',
                'resources/css/history.css',
                'resources/css/login.css',
                'resources/css/my-account.css',
                'resources/css/notifications.css',
                'resources/css/recharge.css',
                'resources/css/style.css',
                'resources/css/upload-book.css',
                'resources/js/app.js',
                'resources/js/authors.js',
                'resources/js/books-detail.js',
                'resources/js/books.js',
                'resources/js/bootstrap.js',
                'resources/js/cart.js',
                'resources/js/contact.js',
                'resources/js/history.js',
                'resources/js/login.js',
                'resources/js/notifications.js',
                'resources/js/recharge.js',
                'resources/js/script.js',
                'resources/js/upload-book.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
