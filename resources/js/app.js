import '../css/app.css';
import './bootstrap';

import { createInertiaApp, router } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

const appName = import.meta.env.VITE_APP_NAME || 'Alumco';
// Agregamos tu ID directamente como respaldo por si Vite no está inyectando el .env
const gaId = import.meta.env.VITE_GOOGLE_ANALYTICS_ID || 'G-819EJWM2BG';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});

// Listener GLOBAL de Inertia (movido fuera de createInertiaApp)
if (gaId) {
    console.log('GA ID cargado correctamente:', gaId); // Para verificar que el ID exista

    router.on('navigate', (event) => {
        console.log('Navegación de Inertia detectada hacia:', event.detail.page.url); 
        
        if (typeof window.gtag !== 'undefined') {
            console.log('Enviando datos a Google Analytics...');
            window.gtag('config', gaId, {
                page_path: event.detail.page.url
            });
        } else {
            console.warn('gtag no está definido durante la navegación.');
        }
    });
} else {
    console.warn('No se encontró el ID de Google Analytics en las variables de entorno.');
}