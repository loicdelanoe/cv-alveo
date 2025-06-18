<script setup lang="ts">
import { ref } from 'vue'

import IconChevronDown from '../Icon/IconChevronDown.vue'
import IconPlus from '../Icon/IconPlus.vue'

defineProps<{
  label: string
  hasCreate?: boolean
}>()

const isExpand = ref(true)

const toggle = () => {
  isExpand.value = !isExpand.value
}
</script>

<template>
  <div :class="{ 'is-expand': isExpand }" class="overflow-hidden">
    <button
      type="button"
      class="flex w-full justify-between items-center font-medium pl-3.5 py-3 cursor-pointer"
      @click.prevent="toggle"
      :aria-expanded="isExpand"
    >
      <div class="gap-2 flex items-center">
        <slot name="icon" />
        {{ label }}
      </div>

      <div class="flex items-center gap-2">
        <IconChevronDown class="arrow" />
      </div>
    </button>
    <ul class="items flex flex-col" :aria-hidden="!isExpand">
      <slot name="items" />
    </ul>
  </div>
</template>

<style lang="scss" scoped>
.items {
  max-height: 0;
  transition: all 0.5s ease-in-out;

  .is-expand & {
    max-height: 100vh;
  }
}

.arrow {
  transform: rotate(90deg);
  transition: all 0.3s ease-in-out;

  .is-expand & {
    transform: rotate(0);
  }
}
</style>
