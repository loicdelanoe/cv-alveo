<script setup lang="ts">
defineProps<{
  links: any[]
}>()
</script>

<template>
  <ul class="flex gap-2 md:justify-end w-full flex-wrap md:w-auto">
    <li v-for="link in links" :key="link.url">
      <Link
        v-if="link.url"
        class="px-4 py-2.5 rounded-md hover:bg-secondary-100 transition inline-flex"
        :class="{ active: link.active }"
        :href="link.url"
        v-html="link.label"
      />
      <button
        v-else
        class="px-4 py-2.5 rounded-md not:disabled:hover:bg-secondary-100 transition inline-flex disabled:cursor-not-allowed disabled:opacity-50"
        v-html="link.label"
        disabled
      />
    </li>
  </ul>
</template>

<style scoped>
.active {
  background-color: var(--color-secondary-950);
  color: var(--color-white);
}
</style>
