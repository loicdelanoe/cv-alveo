<script setup lang="ts">
import { capitalize } from 'vue'

defineProps<{
  content: string
}>()
</script>

<template>
  <span
    v-if="content === 'published'"
    class="text-[#2AA383] font-medium px-2 py-1 rounded-full w-full flex items-center gap-2 before:content-[''] before:w-2 before:h-2 before:bg-[#2AA383] before:rounded-full"
  >
    {{ capitalize(content) }}
  </span>
  <span
    v-else
    class="text-secondary-950 font-medium px-2 py-1 rounded-full w-full flex items-center gap-2 before:content-[''] before:w-2 before:h-2 before:bg-secondary-950 before:rounded-full"
  >
    {{ capitalize(content) }}
  </span>
</template>

<style scoped></style>
