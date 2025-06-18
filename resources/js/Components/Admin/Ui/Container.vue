<script setup lang="ts">
defineProps<{
  tag?: string
}>()
</script>

<template>
  <component :is="tag || 'div'" class="bg-white border-secondary-200 border p-3.5 rounded-lg">
    <slot />
  </component>
</template>

<style scoped></style>
