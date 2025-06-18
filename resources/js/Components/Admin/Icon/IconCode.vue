<script setup lang="ts">
import IconLayout from '@/Components/Admin/Icon/IconLayout.vue'

defineProps<{
  width?: string
}>()
</script>

<template>
  <IconLayout :width="width">
    <path d="m16 18 6-6-6-6" />
    <path d="m8 6-6 6 6 6" />
  </IconLayout>
</template>

<style scoped></style>
