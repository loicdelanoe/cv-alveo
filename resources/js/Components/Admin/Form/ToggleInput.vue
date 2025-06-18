<script setup lang="ts">
import IconCheck from '@/Components/Admin/Icon/IconCheck.vue'

defineProps<{
  label: string
  name: string
  error?: string
  required?: boolean
  value?: string | number
  hint?: string
  disabled?: boolean
  reverse?: boolean
  hiddenLabel?: boolean
  col?: boolean
}>()

const model = defineModel()
</script>

<template>
  <div
    class="flex items-center gap-2"
    :class="{ 'flex-row-reverse': reverse, 'items-start justify-end flex-col-reverse': col }"
  >
    <div class="relative mt-1">
      <input
        type="checkbox"
        :id="name"
        :name="name"
        :required="required"
        v-model="model"
        :value="value"
        :disabled="disabled"
        class="w-11 h-6 rounded-full appearance-none bg-secondary-100 peer checked:bg-accent-300 transition cursor-pointer border border-secondary-200 focus:outline focus:ring-2 focus:ring-secondary-100 focus:ring-opacity-50 shrink-0 peer disabled:cursor-not-allowed disabled:opacity-50"
      />
      <span
        class="w-5 h-5 bg-white absolute top-0.5 inline-block left-0.5 shadow rounded-full pointer-events-none peer-checked:translate-x-5 transition-transform duration-200 ease-in-out cursor-pointer"
      ></span>
    </div>
    <label :for="name" class="font-medium w-full" :class="{ 'sr-only': hiddenLabel }">
      {{ label }}
    </label>
  </div>
</template>

<style scoped>
input:before {
  content: '';
  transform-origin: bottom left;
  clip-path: polygon(14% 44%, 0 65%, 50% 100%, 100% 16%, 80% 0%, 43% 62%);
}
</style>
