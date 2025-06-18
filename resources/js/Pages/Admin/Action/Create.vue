<script setup lang="ts">
import { useForm } from '@inertiajs/vue3'

import InputLabel from '@/Components/Admin/Form/InputLabel.vue'
import IconPlus from '@/Components/Admin/Icon/IconPlus.vue'

const props = defineProps<{
  menuForm: any
  menuId: number
}>()

const emit = defineEmits(['closeModal'])

const form = useForm({
  menu_id: props.menuId,
  label: '',
  value: '',
})

const onSubmit = () => {
  form.post(route('admin.action.store'), {
    preserveScroll: true,
  })

  emit('closeModal')
}
</script>

<template>
  <div class="flex flex-col gap-4">
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
    <Action tag="button" variant="primary" @click.prevent="onSubmit">
      <IconPlus />
      Add Action
    </Action>
  </div>
</template>

<style scoped></style>
