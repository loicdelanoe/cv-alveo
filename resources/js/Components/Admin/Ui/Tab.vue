<script setup lang="ts">
defineProps<{
  active?: boolean
}>()
</script>

<template>
  <button
    type="button"
    class="flex px-6 py-3 w-full justify-center cursor-pointer relative"
    :class="{ active: active }"
  >
    <slot />
  </button>
</template>

<style scoped>
@reference "../../../../css/admin/admin.css";

.active {
  @apply font-medium;
}
.active::after {
  @apply content-[''] absolute bottom-[-1px] w-full h-[2px] bg-accent-300;
}
</style>
