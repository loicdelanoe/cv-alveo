import { Block } from './block'
import { LaravelCollection } from './collection'

export interface Page extends LaravelCollection {
  title: string
  slug: string
  meta_title: string
  meta_description: string
  og_type: string
  status: string
  is_home: boolean
  blocks: Block[]
  pivot: {
    order: number
  }
  collections: any[]
}
