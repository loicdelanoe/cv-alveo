<script setup lang="ts">
defineProps<{
  error?: string | string[]
}>()
</script>

<template>
  <span v-if="error" class="text-red-600 font-medium">
    {{ Array.isArray(error) ? error[0] : error }}
  </span>
</template>

<style scoped></style>
