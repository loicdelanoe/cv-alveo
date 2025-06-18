<script setup lang="ts">
import { Link } from '@inertiajs/vue3'

import PanelLayout from '@/Layouts/PanelLayout.vue'

import type { BlockType } from '../Block/Create.vue'

defineProps<{
  blockTypes: BlockType[]
}>()
</script>

<template>
  <PanelLayout title="Block Types">
    <template #action>
      <Link :href="route('admin.block-type.create')">Create block type</Link>
    </template>
    <div class="flex flex-col gap-4">
      <table class="table-auto w-full">
        <thead>
          <tr>
            <th class="p-4 border border-black text-left" scope="col">Type</th>
            <th class="p-4 border border-black text-left" scope="col">Name</th>
            <th class="p-4 border border-black text-left" scope="col">Fields</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="blockType in blockTypes" :key="blockType.id" class="relative">
            <td class="p-4 border border-black">{{ blockType.type }}</td>
            <td class="p-4 border border-black">
              <Link :href="route('admin.block-type.show', blockType.type)" class="absolute inset-0">
                <span class="sr-only">{{ blockType.name }}</span>
              </Link>
              {{ blockType.name }}
            </td>
            <td class="p-4 border border-black">
              <pre>{{ blockType.fields }}</pre>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </PanelLayout>
</template>

<style scoped></style>
