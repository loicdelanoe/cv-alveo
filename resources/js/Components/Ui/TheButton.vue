<script setup lang="ts">
defineProps<{
  variant: string
  href?: string
  tag: 'Link' | 'button'
}>()
</script>

<template>
  <component
    :is="tag"
    :href="href"
    :class="[variant]"
    class="flex px-3 py-2.5 font-semibold rounded-full gap-1 text-center justify-center items-center transition"
    v-bind="$attrs"
  >
    <slot />
  </component>
</template>

<style scoped>
@reference "../../../css/admin/admin.css";

.cv-primary {
  @apply border border-white py-3.5 px-6 hover:bg-white hover:text-black transition-all;
}

.cv-secondary {
  @apply border text-black bg-white border-white py-3.5 px-6 hover:bg-transparent hover:text-white transition-all;
}

.cv-arrow {
  @apply text-white after:content-['→'] after:ml-2 p-0;
}
</style>
