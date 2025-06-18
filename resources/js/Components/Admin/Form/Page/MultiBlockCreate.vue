<script setup lang="ts">
import { InertiaForm, router, useForm } from '@inertiajs/vue3'
import axios from 'axios'
import { computed, ref } from 'vue'

import BlockTypeSelector from '@/Components/Admin/BlockTypeSelector.vue'
import { BlockForm } from '@/Components/Admin/Form/Block/BlockCreate.vue'
import FieldBuilder from '@/Components/Admin/Form/FieldBuilder.vue'
import { BlockType } from '@/Pages/Admin/Block/Create.vue'
import { PageForm } from '@/Pages/Admin/Page/Show.vue'

const type = ref('')
const currentStep = ref(1)
const totalSteps = 2

const form = useForm<BlockForm>({
  type: '',
  content: {},
  order: 0,
})

const props = defineProps<{
  blockTypes: BlockType[]
  pageForm: InertiaForm<PageForm>
}>()

const emit = defineEmits(['closeModal'])

const blockType = computed(() => {
  return props.blockTypes.find(blockType => blockType.type === type.value)
})

const onSubmit = async () => {
  try {
    const response = await axios.post(route('admin.block.store', type.value), form, {
      headers: {
        'Content-Type': 'multipart/form-data',
      },
    })

    router.reload({ only: ['blocks'] })

    props.pageForm.blocks.push(response.data)

    emit('closeModal')
  } catch (error) {
    // TODO: Type this
    // @ts-ignore
    form.errors = error.response.data.errors
  }
}

const next = async () => {
  if (type.value) {
    currentStep.value++
  }
}

const previous = () => {
  if (currentStep.value > 1) {
    currentStep.value--
  }
}
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
      <BlockTypeSelector :block-types="blockTypes" v-model:type="type" />
    </template>

    <!-- Step 2 -->
    <template v-if="currentStep === 2">
      <form @submit.prevent="onSubmit" class="flex flex-col gap-4" enctype="multipart/form-data">
        <div v-for="(field, index) in blockType?.fields" class="flex flex-col gap-2" :key="index">
          <FieldBuilder :field="field" :form="form" />
        </div>
        <Action tag="button" variant="primary">Create Block</Action>
      </form>
    </template>

    <Action
      tag="button"
      variant="primary"
      :disabled="type === ''"
      v-if="currentStep !== totalSteps"
      @click="next"
      class="self-end"
      >Next →</Action
    >
  </div>
</template>

<style scoped></style>
