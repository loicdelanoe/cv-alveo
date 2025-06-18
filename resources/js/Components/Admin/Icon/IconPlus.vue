<script setup lang="ts">
import IconLayout from '@/Components/Admin/Icon/IconLayout.vue'

defineProps<{
  width?: string
}>()
</script>

<template>
  <IconLayout :width="width">
    <path d="M5 12h14" />
    <path d="M12 5v14" />
  </IconLayout>
</template>

<style scoped></style>
