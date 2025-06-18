<script setup lang="ts">
import Container from './Container.vue'

defineProps<{
  title: string
  collection: any[]
  href: string
  hideAll?: boolean
}>()
</script>

<template>
  <Container class="w-full">
    <dt class="font-medium">{{ title }}</dt>
    <dd class="text-lg font-medium flex flex-col gap-3 justify-between">
      <div class="flex items-center justify-between">
        <span>{{ collection.length }}</span>
        <slot name="action" />
      </div>
      <Action v-if="!hideAll" tag="Link" variant="primary" :href="route('admin.page.index')">
        Show All
      </Action>
    </dd>
  </Container>
</template>

<style scoped></style>
