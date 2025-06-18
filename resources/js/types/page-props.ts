import { BlockType } from '@/Pages/Admin/Block/Create.vue'

import { PageProps } from '.'

type ItemType = {
  name: string
  type: string
}

type Navigation = {
  blockTypes: ItemType[]
  collectionTypes: ItemType[]
}

export interface CPageProps extends PageProps {
  navigation: Navigation
}
