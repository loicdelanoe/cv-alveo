<script setup lang="ts">
import ErrorMessage from '@/Components/Admin/Form/ErrorMessage.vue'

defineProps<{
  label: string
  name: string
  error?: string
  required?: boolean
}>()

const model = defineModel<string>()
</script>

<template>
  <div class="flex flex-col gap-1">
    <label :for="name" class="pl-1.5 font-medium text-md">{{ label }}</label>
    <textarea
      class="px-3 py-2.5 border-1 border-secondary-300 rounded-lg min-h-42"
      :name="name"
      :id="name"
      v-model="model"
      :required="required"
    ></textarea>
    <ErrorMessage :error="error" />
  </div>
</template>

<style scoped></style>
