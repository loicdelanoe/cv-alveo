<script setup lang="ts">
import IconLayout from '@/Components/Admin/Icon/IconLayout.vue'

defineProps<{
  width?: string
}>()
</script>

<template>
  <IconLayout :width="width">
    <path d="m16 17 5-5-5-5" />
    <path d="M21 12H9" />
    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
  </IconLayout>
</template>

<style scoped></style>
