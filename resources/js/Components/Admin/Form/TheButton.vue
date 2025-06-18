<script setup lang="ts">
defineProps<{
  type?: 'reset' | 'submit' | 'button'
  disabled?: boolean
}>()
</script>

<template>
  <button class="p-4 border-black border cursor-pointer" :type="type" :disabled="disabled">
    <slot />
  </button>
</template>

<style scoped></style>
