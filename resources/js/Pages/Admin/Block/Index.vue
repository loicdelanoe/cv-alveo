<script setup lang="ts">
import { Link } from '@inertiajs/vue3'

import PanelLayout from '@/Layouts/PanelLayout.vue'
import { Block } from '@/types/models/block'

import { BlockType } from './Create.vue'

defineProps<{
  blocks: Block[]
  blockTypes: BlockType[]
}>()
</script>

<template>
  <PanelLayout title="Blocks">
    <div>
      <ul>
        <li v-for="blockType in blockTypes" :key="blockType.id">
          <Link :href="route('admin.block-type.show', blockType.type)" class="underline">
            {{ blockType.name }}
          </Link>
        </li>
      </ul>
    </div>
  </PanelLayout>
</template>

<style scoped></style>
