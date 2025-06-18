<script setup lang="ts">
import { useForm } from '@inertiajs/vue3'

import InputLabel from '@/Components/Admin/Form/InputLabel.vue'

import IconClose from '../Icon/IconClose.vue'
import Container from '../Ui/Container.vue'

const props = defineProps<{
  index: number
  action: any
}>()

const form = useForm({
  label: props.action.label,
  value: props.action.value,
})

const onDelete = () => {
  form.delete(route('admin.action.destroy', props.action.id), {
    preserveScroll: true,
  })
}
</script>

<template>
  <Container class="flex items-start gap-2">
    <div class="flex flex-col gap-4 w-full">
      <InputLabel
        label="Label"
        name="label"
        placeholder="Alveo website"
        v-model="form.label"
        :error="form.errors.label"
      />
      <InputLabel
        label="Value"
        name="value"
        placeholder="https://alveo.com…"
        v-model="form.value"
        :error="form.errors.value"
      />
    </div>
    <Action tag="button" variant="icon" @click.prevent="onDelete">
      <span class="sr-only">Delete Action</span>
      <IconClose />
    </Action>
  </Container>
</template>

<style scoped></style>
