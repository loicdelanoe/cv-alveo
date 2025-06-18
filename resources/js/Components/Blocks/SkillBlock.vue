<script setup lang="ts">
import Section from '@/Components/Ui/Section.vue'

defineProps<{
  content: any
}>()
</script>

<template>
  <div class="relative z-2 bg-black">
    <Section class="flex flex-col justify-center items-center min-h-screen gap-10 pt-20">
      <pre>{{ content }}</pre>
    </Section>
  </div>
</template>

<style scoped></style>
