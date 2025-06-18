<script setup lang="ts">
defineProps<{
  variant: 'cv-primary' | 'cv-secondary'
  href?: string
  tag: 'Link' | 'button'
}>()
</script>

<template>
  <component
    :is="tag"
    :href="href"
    :class="[variant]"
    class="flex px-3 py-2.5 font-medium rounded-lg gap-1 text-center justify-center items-center transition"
    v-bind="$attrs"
  >
    <slot />
  </component>
</template>

<style scoped>
@reference "../../../css/admin/admin.css";

.cv-primary {
  @apply font-semibold inline-flex rounded-full border border-white py-3.5 px-6 hover:bg-white hover:text-black transition-all;
}

.cv-secondary {
  @apply font-semibold inline-flex rounded-full border text-black bg-white border-white py-3.5 px-6 hover:bg-transparent hover:text-white transition-all;
}
</style>
