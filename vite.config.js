import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
<<<<<<< HEAD
                'resources/js/app.tsx',
=======
                'resources/js/app.js',
<<<<<<< HEAD
>>>>>>> 3c117fd (Add Cart functionality and update Bootstrap version)
=======
>>>>>>> 5c848fc (Add Cart functionality and update Bootstrap version)
>>>>>>> 2d4f65f (Add Cart functionality and update Bootstrap version)
                'resources/js/bootstrap.js',
            ],
            refresh: true,
        }),
        react(),
    ],
});
