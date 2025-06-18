<script setup lang="ts">
import { Link } from '@inertiajs/vue3'

import PanelLayout from '@/Layouts/PanelLayout.vue'
import { Field } from '@/stores/field'

export interface CollectionType {
  id: number
  name: string
  type: string
  fields: Field[]
}

defineProps<{
  collectionTypes: CollectionType[]
}>()
</script>

<template>
  <PanelLayout title="Collection types">
    <template #action>
      <Link :href="route('admin.collection-type.create')">Create collection type</Link>
    </template>
    <div>
      <pre>{{ collectionTypes }}</pre>
    </div>
  </PanelLayout>
</template>

<style scoped></style>
