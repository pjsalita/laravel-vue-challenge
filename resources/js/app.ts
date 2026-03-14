import { createInertiaApp } from '@inertiajs/vue3';
import Aura from '@primeuix/themes/aura';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createPinia } from 'pinia';
import PrimeVue from 'primevue/config';
import ToastService from 'primevue/toastservice';
import { createApp, h } from 'vue';
import type { DefineComponent } from 'vue';

import '../css/app.css';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
  title: (title) => (title ? `${title} - ${appName}` : appName),
  resolve: (name) =>
    resolvePageComponent(
      `./pages/${name}.vue`,
      import.meta.glob<DefineComponent>('./pages/**/*.vue'),
    ),
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(createPinia())
      .use(plugin)
      .use(PrimeVue, {
        theme: {
          preset: Aura,
          options: {
            darkModeSelector: false,
          },
        },
      })
      .use(ToastService)
      .mount(el);
  },
  progress: {
    color: '#4B5563',
  },
});
