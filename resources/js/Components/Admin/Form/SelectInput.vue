<script setup lang="ts">
import { capitalize } from 'vue'

import ErrorMessage from '@/Components/Admin/Form/ErrorMessage.vue'
import IconChevronDown from '@/Components/Admin/Icon/IconChevron.vue'

defineProps<{
  name: string
  label: string
  options: Option[]
  error?: string
}>()

type Option =
  | string
  | {
      label: string
      value: string
    }
const model = defineModel()

const isStringArray = (value: unknown): value is string[] => {
  return Array.isArray(value) && value.every(item => typeof item === 'string')
}
</script>

<template>
  <div class="flex flex-col gap-1">
    <label :for="name" class="pl-1.5 font-medium text-md">{{ label }}</label>
    <div class="relative">
      <select
        class="px-3 py-1.5 border-1 border-secondary-300 rounded-lg appearance-none w-full"
        :name="name"
        :id="name"
        v-model="model"
      >
        <template v-if="isStringArray(options)">
          <option v-for="(option, index) in options" :value="option" :key="index">
            {{ capitalize(option) }}
          </option>
        </template>
        <template v-else>
          <option v-for="option in options" :value="option.value" :key="JSON.stringify(option)">
            {{ capitalize(option.label) }}
          </option>
        </template>
      </select>
      <IconChevronDown class="arrow pointer-events-none" />
    </div>
    <ErrorMessage :error="error" />
  </div>
</template>

<style scoped>
.arrow {
  position: absolute;
  right: 0.875rem;
  top: 50%;
  transform: translateY(-50%) rotate(90deg);
}
</style>
