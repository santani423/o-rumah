import { defineConfig } from 'vite';
import mkcert from 'vite-plugin-mkcert'
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    // server: {
    //     https: true,
    // },
    plugins: [
        // mkcert(),
        laravel({
            input: 'resources/js/app.js',
            // ssr: 'resources/js/ssr.js',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
                compilerOptions: {
                    isCustomElement: (tag) => ['vue3-simple-typeahead'].includes(tag)
                }
            },
        }),
    ],
    optimizeDeps: {
        include: [
            "vue-google-maps-community-fork",
            "fast-deep-equal",
        ],
    },
});
