require('./bootstrap');

import { createApp, h } from 'vue';
import { createInertiaApp, Link } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import CKEditor from '@ckeditor/ckeditor5-vue';
import directives from "./Directives";

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'LaraVue3';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin).use(CKEditor).use(directives)
            .component("Link", Link)
            .mixin({ methods: { route } })
            .mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });
