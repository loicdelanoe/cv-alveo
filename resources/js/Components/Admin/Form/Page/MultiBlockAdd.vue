<script setup lang="ts">
import { InertiaForm } from '@inertiajs/vue3'
import axios from 'axios'
import { computed, ref } from 'vue'

import BlockTypeSelector from '@/Components/Admin/BlockTypeSelector.vue'
import CheckboxInput from '@/Components/Admin/Form/CheckboxInput.vue'
import { BlockType } from '@/Pages/Admin/Block/Create.vue'
import { PageForm } from '@/Pages/Admin/Page/Show.vue'
import { Block } from '@/types/models/block'

const currentStep = ref<number>(1)
const type = ref<string>('')
const blocks = ref<Block[]>([])
const blocksToPush = ref<number[]>([])
const totalStep = 2

const props = defineProps<{
  blockTypes: BlockType[]
  pageForm: InertiaForm<PageForm>
}>()

const emit = defineEmits(['closeModal'])

const getBlockByType = async () => {
  try {
    const response = await axios.get(route('admin.block.get-blocks-by-type', type.value))

    blocks.value = response.data.data.filter(
      (block: Block) => !props.pageForm.blocks.some(pageBlock => pageBlock.id === block.id)
    )
  } catch (error) {
    console.error(error)
  }
}

const next = async () => {
  if (type.value) {
    currentStep.value++

    await getBlockByType()
  }
}

const previous = () => {
  if (currentStep.value > 1) {
    currentStep.value--
  }
}

const pushBlocks = () => {
  const selectedBlock = blocks.value.filter(block => {
    return blocksToPush.value.includes(block.id)
  })

  props.pageForm.blocks.push(...selectedBlock)

  emit('closeModal')
}

const tableCol = computed<string[]>(() => {
  return props.blockTypes
    .filter(blockType => {
      return blockType.type === type.value
    })[0]
    .fields.map(field => {
      return field.label
    })
})
</script>

<template>
  <div class="flex flex-col gap-4">
    <Action
      tag="button"
      variant="outline"
      v-if="currentStep > 1"
      @click="previous"
      class="self-start"
      >← Previous</Action
    >

    <!-- Step 1 -->
    <template v-if="currentStep === 1">
      <BlockTypeSelector
        :block-types="blockTypes"
        v-model:current-step="currentStep"
        v-model:type="type"
      />
    </template>

    <!-- Step 2 -->
    <template v-if="currentStep === 2">
      <template v-if="blocks.length > 0">
        <div class="relative overflow-overlay rounded-lg">
          <table class="w-full border-separate border-spacing-0">
            <thead class="bg-secondary-950 text-white">
              <tr>
                <th class="text-left px-4 py-2.5">Select</th>
                <th v-for="col in tableCol" :key="col" class="text-left px-4 py-2.5">{{ col }}</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="block in blocks"
                :key="block.id"
                class="relative border-b border-secondary-200 hover:bg-secondary-100 transition odd:bg-secondary-50"
              >
                <td class="px-4 py-2.5">
                  <CheckboxInput
                    :label="`Select ${block.id}`"
                    :name="block.id.toString()"
                    :value="block.id"
                    v-model="blocksToPush"
                    hidden-label
                  />
                </td>
                <td v-for="col in tableCol" :key="`block-${col}`" class="px-4 py-2.5">
                  <span v-if="Array.isArray(block.content[col.toLowerCase()])"
                    >{{ block.content[col.toLowerCase()].length }} item(s)</span
                  >
                  <span v-else>{{ block.content[col.toLowerCase()] }}</span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </template>
      <p v-else class="text-center">No blocks available</p>
    </template>

    <Action
      tag="button"
      variant="primary"
      v-if="currentStep === totalStep && blocks.length > 0"
      @click="pushBlocks"
    >
      Add {{ blocksToPush.length }} Block(s)
    </Action>
    <Action
      tag="button"
      variant="primary"
      :disabled="type === ''"
      v-if="currentStep !== totalStep"
      @click="next"
      class="self-end"
      >Next →</Action
    >
  </div>
</template>

<style scoped></style>
