<script setup lang="ts">
import IconSquareArrowRight from '@/Components/Admin/Icon/IconSquareArrowRight.vue'

defineProps<{
  href: string
  isHome?: boolean
}>()
</script>

<template>
  <a
    :href="isHome ? '/' : href"
    target="_blank"
    class="underline text-secondary-500 hover:text-secondary-800 transition flex gap-2 items-center"
  >
    Visit page
    <IconSquareArrowRight />
  </a>
</template>

<style scoped></style>
