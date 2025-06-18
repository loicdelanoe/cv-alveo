<script setup lang="ts">
import IconChevron from '@/Components/Admin/Icon/IconChevron.vue'
import IconHome from '@/Components/Admin/Icon/IconHome.vue'

defineProps<{
  links: {
    label: string
    href: string
  }[]
}>()
</script>

<template>
  <ul class="flex gap-2 text-sm items-center">
    <li class="flex item-center gap-2 font-light">
      <Link :href="route('admin.dashboard')">
        <span class="sr-only">Home</span>
        <IconHome width="w-4" />
      </Link>
      <IconChevron class="!w-4" />
    </li>
    <li v-for="(link, index) in links" :key="link.href" class="flex item-center gap-2 font-light">
      <Link :href="link.href" class="hover:underline">{{ link.label }}</Link>
      <IconChevron class="!w-4" v-if="index !== links.length - 1" />
    </li>
  </ul>
</template>

<style scoped></style>
