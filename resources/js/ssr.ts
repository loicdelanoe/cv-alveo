import { createInertiaApp, Link } from '@inertiajs/vue3'
import createServer from '@inertiajs/vue3/server'
import { renderToString } from '@vue/server-renderer'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { createPinia } from 'pinia'
import { createApp, createSSRApp, DefineComponent, h } from 'vue'
import { route as ziggyRoute } from 'ziggy-js'

import Action from './Components/Admin/Action.vue'
import Can from './Components/Admin/Permission/Can.vue'
import AdminLayout from './Layouts/AdminLayout.vue'

const appName = import.meta.env.VITE_APP_NAME || 'Laravel'
const pinia = createPinia()

createServer(page =>
  createInertiaApp({
    page,
    render: renderToString,
    title: title => `${title} - ${appName}`,
    resolve: async name => {
      let page = await resolvePageComponent(
        `./Pages/${name}.vue`,
        import.meta.glob<DefineComponent>('./Pages/**/*.vue')
      )

      page.default.layout = name.startsWith('Admin/') ? AdminLayout : undefined

      return page
    },
    setup({ App, props, plugin }) {
      const app = createSSRApp({ render: () => h(App, props) })

      // Configure Ziggy for SSR...
      const ziggyConfig = {
        ...page.props.ziggy,
        location: new URL(page.props.ziggy.location),
      }

      // Create route function...
      const route = (name: string, params?: any, absolute?: boolean) =>
        ziggyRoute(name, params, absolute, ziggyConfig)

      // Make route function available globally...
      app.config.globalProperties.route = route

      // Make route function available globally for SSR...
      if (typeof window === 'undefined') {
        global.route = route
      }

      app.use(plugin)
      app.use(pinia)
      app.component('AdminLayout', AdminLayout)
      app.component('Link', Link)
      app.component('Action', Action)
      app.component('Can', Can)

      // Debug
      if (import.meta.env.VITE_APP_DEBUG === 'true') {
        console.log('[SSR] Inertia is running in SSR mode')
      }

      return app
    },
  })
)
