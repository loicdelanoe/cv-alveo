<script setup lang="ts">
defineProps<{
  title: string
}>()
</script>

<template>
  <section class="flex flex-col gap-2">
    <h4 class="font-medium text-sm">{{ title }}</h4>
    <ul>
      <slot />
    </ul>
  </section>
</template>

<style scoped></style>
