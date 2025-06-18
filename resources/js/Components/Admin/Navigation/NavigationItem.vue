<script setup lang="ts">
import { usePage } from '@inertiajs/vue3'
import { computed } from 'vue'

const props = defineProps<{
  href: string
}>()

const page = usePage()

const isActive = computed(() => {
  return page.props.ziggy.location === props.href
})
</script>

<template>
  <Link
    class="nav-item rounded-lg px-3.5 py-3 w-full gap-2 inline-flex items-center transition"
    :class="{ active: isActive }"
    :href="href"
    preserve-scroll
  >
    <slot />
  </Link>
</template>

<style lang="scss" scoped>
.nav-item {
  &.active {
    background: var(--color-accent-400);
    color: var(--color-secondary-950);
    font-weight: 600;
  }

  &:not(.active):hover {
    background: var(--color-secondary-700);
  }

  &.small {
    padding: 0.4rem 2.2rem;
  }
}
</style>
