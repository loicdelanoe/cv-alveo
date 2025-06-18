<script setup lang="ts">
import { InertiaForm } from '@inertiajs/vue3'
import { ref } from 'vue'

import IconClose from '@/Components/Admin/Icon/IconClose.vue'
import IconGrip from '@/Components/Admin/Icon/IconGrip.vue'
import Container from '@/Components/Admin/Ui/Container.vue'
import { BlockType } from '@/Pages/Admin/Block/Create.vue'
import { PageForm } from '@/Pages/Admin/Page/Show.vue'
import { getInputCpt } from '@/utils/mapping'

import type { Block } from '@/types/models/block'

const props = defineProps<{
  blockType: BlockType
  block: Block
  index: number
  pageForm: InertiaForm<PageForm>
}>()

const block = ref<HTMLElement | null>(null)

const removeFromPage = () => {
  props.pageForm.blocks.splice(props.index, 1)
}

const draggedIndex = defineModel<number | null>('dragged', { default: null })

const dragStart = (index: number, event: DragEvent) => {
  draggedIndex.value = index

  //   event.dataTransfer?.setDragImage()
  if (block.value && event.dataTransfer) {
    event.dataTransfer.effectAllowed = 'move'

    event.dataTransfer?.setDragImage(block.value, 0, 0)
  }
}

const drop = (index: number) => {
  if (draggedIndex.value !== null) {
    const temp = props.pageForm.blocks[draggedIndex.value]

    props.pageForm.blocks.splice(draggedIndex.value, 1)
    props.pageForm.blocks.splice(index, 0, temp)

    // Update order index
    props.pageForm.blocks.forEach((item, index) => {
      item.pivot.order = index
    })

    draggedIndex.value = null
  }
}
</script>

<template>
  <Container
    @dragover.prevent
    @drop="drop(index)"
    class="flex flex-col gap-4 transition-opacity"
    :class="{ 'opacity-0': draggedIndex === index }"
    ref="block"
  >
    <div class="flex items-center gap-2">
      <div draggable="true" @dragstart="e => dragStart(index, e)" class="cursor-move">
        <IconGrip />
      </div>
      <p class="text-xl font-medium">{{ blockType.name }}</p>
      <div class="flex gap-4 ml-auto">
        <Action @click="removeFromPage" tag="button" variant="icon">
          <IconClose />
        </Action>
      </div>
    </div>
    <dl class="flex flex-col gap-4">
      <template v-for="field in blockType.fields">
        <component
          :is="getInputCpt(field.type)"
          :type="field.type"
          :name="field.name"
          :label="field.label"
          v-model="pageForm.blocks[index].content[field.name]"
          :repeater-fields="field.repeaterFields"
          :error="pageForm.errors[`content.${field.name}`]"
          :inline="field.type === 'repeater'"
        />
      </template>
    </dl>
  </Container>
</template>

<style scoped></style>
