import { Collection } from '@/Pages/Admin/Collection/Index.vue'

import { Page } from './page'

export interface Menu extends Collection {
  name: string
  slug: string
  pages: Page[]
  actions: Action[]
  active: boolean
}

type Action = { id: number; label: string; value?: string }
