<script setup lang="ts">
import { Link } from '@inertiajs/vue3'

import { LaravelCollection } from '@/types/models/collection'

import { CollectionType } from '../CollectionType/Index.vue'

export interface Collection extends LaravelCollection {
  title: string
  slug: string
  meta_title: string
  meta_description: string
  og_type: string
  status: string
  content: Record<string, any>[]
}

defineProps<{
  collections: Collection[]
  collectionTypes: CollectionType[]
}>()
</script>

<template>
  <PanelLayout title="Collections">
    <div>
      <ul class="grid grid-flow-col gap-4 auto-cols-max">
        <li
          v-for="collectionType in collectionTypes"
          :key="collectionType.id"
          class="border border-black aspect-square max-w-[18rem] flex items-center justify-center"
        >
          <Link
            :href="route('admin.collection-type.show', collectionType.type)"
            class="underline p-10"
          >
            {{ collectionType.name }}
          </Link>
        </li>
      </ul>
    </div>
  </PanelLayout>
</template>

<style scoped></style>
