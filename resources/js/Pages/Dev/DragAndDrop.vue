<script setup lang="ts">
import { ref } from 'vue'

const draggedIndex = ref<number | null>(null)

const items = ref([
  { id: 1, name: 'Item 1', order: 0 },
  { id: 2, name: 'Item 2', order: 1 },
  { id: 3, name: 'Item 3', order: 2 },
])

const dragStart = (index: number) => {
  draggedIndex.value = index
}

const drop = (index: number) => {
  if (draggedIndex.value !== null) {
    const temp = items.value[draggedIndex.value]

    items.value.splice(draggedIndex.value, 1)
    items.value.splice(index, 0, temp)

    // Update order index
    items.value.forEach((item, index) => {
      item.order = index
    })
  }
}
</script>

<template>
  <ul>
    <li
      v-for="(item, index) in items"
      :key="item.id"
      draggable="true"
      @dragstart="dragStart(index)"
      @dragover.prevent
      @drop="drop(index)"
      class="bg-gray-200 p-4 user-select-none cursor-move"
    >
      {{ item.name }}
    </li>
  </ul>
  <pre>{{ items }}</pre>
</template>

<style scoped></style>
