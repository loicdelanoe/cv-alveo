<script setup lang="ts">
import { computed, ref } from 'vue'

import ErrorMessage from '@/Components/Admin/Form/ErrorMessage.vue'
import IconEye from '@/Components/Admin/Icon/IconEye.vue'
import IconEyeOff from '@/Components/Admin/Icon/IconEyeOff.vue'

defineProps<{
  label: string
  name: string
  type?: 'password' | 'text' | 'search' | 'email' | 'number'
  error?: string
  required?: boolean
  value?: string | number
  hint?: string
  disabled?: boolean
  placeholder?: string
  inline?: boolean
}>()

const model = defineModel()

const isToggle = ref(false)

const calculatedType = computed(() => {
  return isToggle.value ? 'text' : 'password'
})
</script>

<template>
  <div class="flex flex-col w-full">
    <div class="flex" :class="inline ? 'flex-row items-center' : 'flex-col'">
      <label
        :for="name"
        class="pl-1.5 font-medium text-md"
        :class="inline ? 'pr-1.5 w-1/6' : 'pb-1.5'"
        >{{ label }}</label
      >
      <div class="relative w-full">
        <input
          :type="type === 'password' ? calculatedType : type"
          :id="name"
          :name="name"
          :required="required"
          :placeholder="placeholder"
          v-model="model"
          :disabled="disabled"
          :class="[disabled ? 'bg-gray-100 opacity-50' : '', inline ?? 'flex-1']"
          class="px-3 py-1.5 border-1 border-secondary-300 rounded-lg w-full relative"
        />
        <div
          v-if="type === 'password'"
          class="absolute top-1/2 right-3 -translate-y-1/2 cursor-pointer"
          @click.prevent="isToggle = !isToggle"
        >
          <IconEye width="5" v-if="!isToggle" />
          <IconEyeOff width="5" v-else />
        </div>
      </div>
    </div>
    <span v-if="hint" class="opacity-50 italic text-sm">{{ hint }}</span>
    <ErrorMessage :error="error" />
  </div>
</template>

<style scoped></style>
