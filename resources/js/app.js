import './bootstrap';
import 'vue3-toastify/dist/index.css'
import '../css/app.css';
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

import Vue3Toastify from 'vue3-toastify'

const appName = import.meta.env.VITE_APP_NAME || 'Webtra Web Solutions';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) });
        app.use(plugin);
        app.use(ZiggyVue);
        app.use(Vue3Toastify)
        app.mount(el);
    },
    progress: {
        color: '#3B82F6',
    },
});