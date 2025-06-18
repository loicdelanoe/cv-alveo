<script setup lang="ts">
defineProps<{
  label: string
  name: string
  type: string
  error?: string
  required?: boolean
  value?: string
  hint?: string
  disabled?: boolean
}>()

const model = defineModel()

const handleFile = (e: Event) => {
  const target = e.target as HTMLInputElement // Assert the target as HTMLInputElement
  if (!target || !target.files) return

  model.value = target.files[0]
}
</script>

<template>
  <div class="flex flex-col gap-2 w-full">
    <label :for="name" class="font-bold">{{ label }}</label>
    <input
      :type="type"
      :id="name"
      :name="name"
      :required="required"
      v-model="model"
      :disabled="disabled"
      :class="disabled ? 'bg-gray-100 opacity-50' : ''"
      @input="handleFile"
    />
    <span v-if="hint" class="opacity-50 italic text-sm">{{ hint }}</span>
    <span v-if="error" class="text-red-500 font-medium">
      {{ Array.isArray(error) ? error[0] : error }}
    </span>
  </div>
</template>

<style scoped>
input::file-selector-button {
  display: inline-flex;
  padding: 0.875rem;
  justify-content: center;
  align-items: center;
  gap: 0.625rem;
  cursor: pointer;

  border-radius: 0.4375rem;

  font-weight: 600;
  background: var(--c-primary);
  color: var(--c-white);
}
</style>
