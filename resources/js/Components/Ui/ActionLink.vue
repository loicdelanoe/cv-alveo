<script setup lang="ts">
import { getRoute } from '@/utils/utils'

defineProps<{
  action: Action
}>()

interface Action {
  label: string
  value?: string
}
</script>

<template>
  <Link
    :href="action.value ? getRoute(action.value) : '/'"
    class="text-lg py-7 px-5 inline-block hover:text-hover transition-all"
  >
    <slot />
  </Link>
</template>

<style scoped></style>
