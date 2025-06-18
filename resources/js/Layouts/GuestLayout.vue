<script setup lang="ts">
import Alveo from '@/Components/Admin/Icon/Alveo.vue'

defineProps<{
  title?: string
}>()
</script>

<template>
  <div class="flex min-h-screen items-center bg-gray-100">
    <div class="w-0 h-0 md:w-1/2 md:h-screen">
      <div class="w-full bg-accent-400 flex items-center justify-center h-full">
        <Alveo width="w-1/3" />
      </div>
    </div>
    <div
      class="min-h-screen justify-center flex flex-col w-full md:w-1/2 max-h-screen overflow-auto mx-auto md:max-w-[480px] px-4 relative"
    >
      <slot name="header" />
      <h1 class="text-3xl font-medium mb-10">{{ title }}</h1>
      <slot />
    </div>
  </div>
</template>
