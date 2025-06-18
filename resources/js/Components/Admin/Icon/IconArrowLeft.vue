<script setup lang="ts">
import IconLayout from '@/Components/Admin/Icon/IconLayout.vue'

defineProps<{
  width?: string
  strokeWidth?: string
}>()
</script>

<template>
  <IconLayout :width="width" :stroke-width="strokeWidth">
    <path d="M6 8L2 12L6 16" />
    <path d="M2 12H22" />
  </IconLayout>
</template>

<style scoped></style>
