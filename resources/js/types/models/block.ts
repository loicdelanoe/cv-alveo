import { BlockType } from '@/Pages/Admin/Block/Create.vue'

import { LaravelCollection } from './collection'
import { Page } from './page'

export interface Block extends LaravelCollection {
  block_type_id: number
  content: Record<string, any>
  order: number
  block_type: BlockType
  pages: Page[]
  pivot: {
    order: number
  }
}
