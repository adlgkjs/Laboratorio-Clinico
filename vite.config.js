import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue'

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue(),
    ],
    server: {
        historyApiFallback: true, 
        hmr: true,
        //Agregue este codigo
        proxy: {
            '/login': 'http://localhost:8000',
            '/logout': 'http://localhost:8000',
            '/user': 'http://localhost:8000',
          },
        //End codigo agregado
    },
    resolve: {
        alias: {
            'vue': 'vue/dist/vue.esm-bundler.js',
        },
    },
});
