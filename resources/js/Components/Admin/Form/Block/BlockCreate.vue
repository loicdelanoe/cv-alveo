<script setup lang="ts">
import { useForm } from '@inertiajs/vue3'

import FieldBuilder from '@/Components/Admin/Form/FieldBuilder.vue'
import { BlockType } from '@/Pages/Admin/Block/Create.vue'

export interface BlockForm {
  type?: string
  content: Record<string, string>
  order: number
  [key: string]: any
}

const props = defineProps<{
  blockType: BlockType
}>()

const form = useForm<BlockForm>({
  type: '',
  content: {},
  order: 0,
})

const onSubmit = () => {
  form.post(route('admin.block.store', props.blockType.type))
}
</script>

<template>
  <form @submit.prevent="onSubmit" class="flex flex-col gap-4">
    <div v-for="field in blockType.fields" class="flex flex-col gap-2" :key="JSON.stringify(field)">
      <FieldBuilder :field="field" :form="form" />
    </div>
    <Action tag="button" variant="primary" type="submit">Submit</Action>
  </form>
</template>

<style scoped></style>
