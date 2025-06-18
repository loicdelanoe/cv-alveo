<script setup lang="ts">
import Tab from '@/Components/Admin/Ui/Tab.vue'

defineProps<{
  tabs: { name: string; id: number }[]
}>()

const model = defineModel()
</script>

<template>
  <ul class="flex w-full border-b border-secondary-300 mb-6">
    <li v-for="tab in tabs" :key="tab.id" class="max-w-32 w-full">
      <Tab @click="model = tab.id" :active="model === tab.id">{{ tab.name }}</Tab>
    </li>
  </ul>
</template>

<style scoped></style>
