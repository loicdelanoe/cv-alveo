<script setup lang="ts">
defineProps<{
  content: string
}>()
</script>

<template>
  <span class="font-medium">{{ content }}</span>
</template>

<style scoped></style>
