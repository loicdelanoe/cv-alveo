import { InertiaForm, router, usePage } from '@inertiajs/vue3'
import { Ref } from 'vue'

import { Menu } from '@/types/models/menu'

// TODO: Type form
export const deleteItem = (route: string, message: string, form?: InertiaForm<any>) => {
  if (confirm(message)) {
    if (form) {
      form.delete(route, {
        preserveScroll: true,
        preserveState: false,
      })
    } else {
      router.delete(route)
    }
  }
}

export const getMenu = (slug: string): Menu | null => {
  const menus = usePage().props.menus as Menu[]

  const menu = menus.find((menu: { slug: string }) => menu.slug === slug)

  if (!menu) {
    console.error(`Menu with slug "${slug}" not found.`)
    return null
  }

  return menu
}

export const getRoute = (href: string): string => {
    const basePath = usePage().props.ziggy.url

    return `${basePath}/${href}`
}
