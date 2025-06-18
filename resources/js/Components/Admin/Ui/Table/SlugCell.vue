<script setup lang="ts">
defineProps<{
  content: string
}>()
</script>

<template>
  <span
    class="text-secondary-950 font-mono bg-secondary-100 px-1.5 py-1 rounded-md whitespace-nowrap overflow-hidden text-ellipsis max-w-[20ch] inline-block text-sm align-middle"
  >
    {{ content }}
  </span>
</template>

<style scoped></style>
