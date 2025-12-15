import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { loadEnv } from 'vite';

export default defineConfig(({ mode }) => {
    // Cargar variables de entorno del archivo .env
    const env = loadEnv(mode, process.cwd(), '');

    return {
        plugins: [
            laravel({
                input: [
                    'resources/sass/app.scss',
                    'resources/js/app.js',
                ],
                refresh: true,
            }),
        ],
        server: {
            hmr: {
                host: env.APP_URL ? new URL(env.APP_URL).hostname : 'localhost',
            },
        },
        define: {
            'process.env': env, // Asegúrate de que las variables de entorno estén disponibles en el código
        },
    };
});
