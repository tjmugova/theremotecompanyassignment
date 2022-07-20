import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import Components from 'unplugin-vue-components/vite';
import {
    AntDesignVueResolver,
    ElementPlusResolver,
    VantResolver,
} from 'unplugin-vue-components/resolvers';
import tailwindcss from "tailwindcss";

export default defineConfig({
    plugins: [
        vue(),
        tailwindcss(),
        laravel({
            input: [
                'resources/js/app.js',
            ],
            refresh: true,
        }),
        // your plugin installation
        Components({
            resolvers: [
                AntDesignVueResolver(),
                ElementPlusResolver(),
                VantResolver(),
            ],
        })

    ],
});
