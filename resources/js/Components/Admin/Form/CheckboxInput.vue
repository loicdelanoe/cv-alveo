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
  smallLabel?: boolean
}>()

const model = defineModel()
</script>

<template>
  <div
    class="relative z-2 flex items-center"
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
        class="appearance-none border border-secondary-200 w-4 h-4 rounded-sm bg-white checked:bg-accent-300 focus:outline focus:ring-2 focus:ring-secondary-200 focus:ring-opacity-50 cursor-pointer shrink-0 peer disabled:cursor-not-allowed disabled:opacity-50 transition mt-1"
      />
      <IconCheck
        class="!w-4 !h-4 hidden peer-checked:block absolute pointer-events-none text-secondary-950 inset-0 mt-1"
      />
    </div>
    <label
      :for="name"
      class="w-full"
      :class="[
        { 'sr-only': hiddenLabel },
        smallLabel ? 'text-sm text-secondary-600' : 'font-medium',
        col ? '' : 'pl-2',
      ]"
    >
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
