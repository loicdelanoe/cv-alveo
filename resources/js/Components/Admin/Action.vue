<script setup lang="ts">
defineProps<{
  variant:
    | ('primary' | 'secondary' | 'outline' | 'icon' | 'delete')[]
    | 'primary'
    | 'secondary'
    | 'outline'
    | 'icon'
    | 'delete'
  size?: 'small' | 'normal' | 'large'
  href?: string
  type?: 'button'
  tag: 'Link' | 'button'
  disabled?: boolean
}>()
</script>

<template>
  <component
    :is="tag"
    :href="href"
    :class="[
      ...(Array.isArray(variant) ? variant : [variant]),
      size,
      { 'opacity-60 cursor-not-allowed': disabled },
      { 'cursor-pointer': !disabled },
    ]"
    class="flex px-3 py-2.5 font-medium rounded-lg gap-1 text-center justify-center items-center transition text-sm"
  >
    <slot />
  </component>
</template>

<style lang="scss" scoped>
.small {
  padding: 0.4rem 0.88rem;
}
</style>
