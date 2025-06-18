<script setup lang="ts">
import { InertiaForm } from '@inertiajs/vue3'

import Block from '@/Components/Admin/Form/Page/Block.vue'
import { BlockType } from '@/Pages/Admin/Block/Create.vue'
import { PageForm } from '@/Pages/Admin/Page/Show.vue'
import { Block as TBlock } from '@/types/models/block'

defineProps<{
  blockTypes: BlockType[]
  blocks: TBlock[]
  pageForm: InertiaForm<PageForm>
}>()
</script>

<template>
  <div v-for="(block, index) in blocks" :key="block.id">
    <Block :block-type="block.block_type" :block="block" :page-form="pageForm" :index="index" />
  </div>
</template>

<style scoped></style>
