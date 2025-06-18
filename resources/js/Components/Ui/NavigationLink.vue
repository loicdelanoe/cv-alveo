<script setup lang="ts">
import { Page } from '@/types/models/page'
import { getRoute } from '@/utils/utils'

defineProps<{
  page: Page
}>()
</script>

<template>
  <Link
    :href="page.is_home ? '/' : getRoute(page.slug)"
    class="text-lg py-7 px-5 inline-block hover:text-hover transition-all"
  >
    <slot />
  </Link>
</template>

<style scoped></style>
