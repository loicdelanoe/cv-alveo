<script setup lang="ts">
import IconLayout from '@/Components/Admin/Icon/IconLayout.vue'

defineProps<{
  width?: string
}>()
</script>

<template>
  <IconLayout :width="width">
    <path d="M6 12h9a4 4 0 0 1 0 8H7a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h7a4 4 0 0 1 0 8" />
  </IconLayout>
</template>

<style scoped></style>
