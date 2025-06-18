<script setup lang="ts">
import BlockCreate from '@/Components/Admin/Form/Block/BlockCreate.vue'
import PanelLayout from '@/Layouts/PanelLayout.vue'
import { Field } from '@/stores/field'

export interface BlockType {
  id: number
  name: string
  type: string
  fields: Field[]
  created_at: Date
  updated_at: Date
}

const { blockType } = defineProps<{
  blockType: BlockType
}>()
</script>

<template>
  <PanelLayout :title="`Create ${blockType.name} Block`">
    <div>
      <BlockCreate :blockType="blockType" />
    </div>
  </PanelLayout>
</template>

<style scoped></style>
