import './bootstrap'

import { createInertiaApp, Link } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { createPinia } from 'pinia'
import { createApp, createSSRApp, DefineComponent, h } from 'vue'

import Action from '@/Components/Admin/Action.vue'
import Can from '@/Components/Admin/Permission/Can.vue'

import { ZiggyVue } from '../../vendor/tightenco/ziggy'
// import clickOutside from './directives/outside'
import AdminLayout from './Layouts/AdminLayout.vue'

const appName = import.meta.env.VITE_APP_NAME || 'Laravel'
const pinia = createPinia()

createInertiaApp({
  title: title => `${title} - ${appName}`,
  resolve: async name => {
    let page = await resolvePageComponent(
      `./Pages/${name}.vue`,
      import.meta.glob<DefineComponent>('./Pages/**/*.vue')
    )

    page.default.layout = name.startsWith('Admin/') ? AdminLayout : undefined

    return page
  },
  setup({ el, App, props, plugin }) {
    const app = createApp({ render: () => h(App, props) })
      //   .directive('click-outside', clickOutside)
      .use(plugin)
      .use(ZiggyVue, {
        ...props.initialPage.props.ziggy,
        location: new URL(props.initialPage.props.ziggy.location),
      })
      .use(pinia)
      .component('AdminLayout', AdminLayout)
      .component('Link', Link)
      .component('Action', Action)
      .component('Can', Can)

    if (import.meta.env.VITE_APP_DEBUG === 'true') {
      if (typeof window !== 'undefined') {
        if (el.hasChildNodes()) {
          console.log('[CLIENT] Hydrated from SSR')
        } else {
          console.log('[CLIENT] Rendered on client only')
        }
      }
    }

    app.mount(el)
  },
  progress: {
    color: '#4B5563',
  },
})
