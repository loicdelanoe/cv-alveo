<script setup lang="ts">
// ! Check how to retrieve image files from the server, for now, we only have the image path
import { useForm } from '@inertiajs/vue3'

import FieldBuilder from '@/Components/Admin/Form/FieldBuilder.vue'
import Button from '@/Components/Admin/Form/TheButton.vue'
import { BlockType } from '@/Pages/Admin/Block/Create.vue'

import type { BlockForm } from '@/Components/Admin/Form/Block/BlockCreate.vue'
import type { Block } from '@/types/models/block'

const props = defineProps<{
  blockType: BlockType
  block: Block
}>()

const emit = defineEmits(['closeModal'])

const form = useForm<BlockForm>({
  content: props.block.content,
  order: 0,
})

const onSubmit = () => {
  //   form.post(route('admin.block.store', props.blockType.type))
  form.patch(route('admin.block.update', props.block.id), {
    onSuccess: () => {
      emit('closeModal')
    },
  })
}
</script>

<template>
  <form @submit.prevent="onSubmit" enctype="multipart/form-data">
    <pre>{{ form }}</pre>
    <div v-for="(field, index) in blockType.fields" class="flex flex-col gap-2" :key="index">
      <FieldBuilder :field="field" :form="form" />
    </div>
    <Button type="submit">Update</Button>
  </form>
</template>

<style scoped></style>
