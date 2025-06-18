<script setup lang="ts">
import { computed, ref } from 'vue'

import { Media } from '@/Pages/Admin/Media/Index.vue'

const props = defineProps<{
  media: Media
}>()

const srcset = computed(() => {
  return Object.entries(props.media.path)
    .filter(([key, value]) => {
      return key !== 'original'
    })
    .map(([key, value]) => {
      return `${value} ${key}`
    })
    .join(', ')
})

const src = computed(() => {
  if (!props.media || !props.media.path) {
    return ''
  }

  return Object.entries(props.media.path)
    .filter(([key, value]) => {
      return key === 'original'
    })
    .map(([key, value]) => {
      return value
    })
    .join(', ')
})
</script>

<template>
  <img
    loading="lazy"
    :width="media.metadata.width ?? null"
    :height="media.metadata.height ?? null"
    :src="src"
    sizes="(min-width: 1024px) 33vw, (min-width: 768px) 50vw, 100vw"
    :srcset="srcset"
    :alt="media.metadata.alt ?? media.name"
    v-bind="$attrs"
  />
</template>

<style scoped></style>
