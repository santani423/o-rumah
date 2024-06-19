import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp, router } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import mitt from 'mitt';
import NProgress from 'nprogress';
import VueGoogleMaps from 'vue-google-maps-community-fork'

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';
const emitter = mitt();

let timeout = null

router.on('start', () => {
    timeout = setTimeout(() => NProgress.start(), 250)
})

router.on('progress', (event) => {
    if (NProgress.isStarted() && event.detail.progress.percentage) {
        NProgress.set((event.detail.progress.percentage / 100) * 0.9)
    }
})

router.on('finish', (event) => {
    clearTimeout(timeout)
    if (!NProgress.isStarted()) {
        return
    } else if (event.detail.visit.completed) {
        NProgress.done()
    } else if (event.detail.visit.interrupted) {
        NProgress.set(0)
    } else if (event.detail.visit.cancelled) {
        NProgress.done()
        NProgress.remove()
    }
})

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(VueGoogleMaps, {
                load: {
                    key: 'AIzaSyDVQm2f1a3BN9nCwujD1tGyOXk9-ATjd_g',
                    libraries: 'places',
                }
            })
            .use(ZiggyVue, Ziggy)
        app.config.globalProperties.emitter = emitter
        app.mount(el)
    },
    progress: false
});
