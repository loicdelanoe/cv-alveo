<script setup lang="ts">
import { BlockType } from '@/Pages/Admin/Block/Create.vue'

defineProps<{
  blockTypes: BlockType[]
  type: string
}>()

const typeModel = defineModel<string>('type', { required: true })
</script>

<!-- class="appearance-none w-5 h-5 border-2 border-gray-300 rounded-full checked:bg-blue-600 checked:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2" -->
<template>
  <ul class="flex flex-col gap-4">
    <li v-for="(blockType, index) in blockTypes" :key="blockType.type">
      <input
      type="radio"
      name="blockType"
      :id="blockType.name"
      v-model="typeModel"
      :value="blockType.type"
      class="appearance-none peer"
      >
        <label :for="blockType.name" class="cursor-pointer inline-flex w-full p-5 peer-checked:bg-secondary-100 peer-checked:font-medium border-1 border-secondary-300 rounded-lg transition">{{ blockType.name }}</label>
    </input>
    </li>
  </ul>
</template>

<style scoped></style>
