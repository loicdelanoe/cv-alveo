<script setup lang="ts">
defineProps<{
  width?: string
  strokeWidth?: string
}>()
</script>

<template>
  <svg
    xmlns="http://www.w3.org/2000/svg"
    width="20"
    height="20"
    viewBox="0 0 24 24"
    fill="none"
    stroke="currentColor"
    :stroke-width="strokeWidth ?? 1.75"
    stroke-linecap="round"
    stroke-linejoin="round"
    :class="width ? width : 'w-6'"
  >
    <slot />
  </svg>
</template>

<style scoped></style>
