<script setup lang="ts">
import IconLayout from '@/Components/Admin/Icon/IconLayout.vue'

defineProps<{
  width?: string
}>()
</script>

<template>
  <IconLayout :width="width">
    <path d="M17 6H3" />
    <path d="M21 12H8" />
    <path d="M21 18H8" />
    <path d="M3 12v6" />
  </IconLayout>
</template>

<style scoped></style>
