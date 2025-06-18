<script setup lang="ts">
import { ref } from 'vue'

import MarkdownInput from '@/Components/Admin/Form/MarkdownInput.vue'
import Draggable from '@/Components/Admin/Ui/Draggable.vue'
import DragAndDrop from '@/Pages/Dev/DragAndDrop.vue'

const array = ref([
  {
    id: 1,
    name: 'Item 1',
  },
  {
    id: 2,
    name: 'Item 2',
  },
  {
    id: 3,
    name: 'Item 3',
  },
  {
    id: 4,
    name: 'Item 4',
  },
])
const draggedIndex = ref<number | null>(null)
</script>

<template>
  <div>
    <h1>Dev zone</h1>
    <hr />
    <DragAndDrop />
    <hr />
    <section class="max-w-[1280px] mx-auto py-12">
      <h2>Markdown</h2>
      <MarkdownInput label="Test" name="test" />
    </section>
    <hr />
    <section class="max-w-[1280px] mx-auto py-12">
      <h2>Drag n Drop</h2>
      <ul class="flex flex-col gap-2">
        <li v-for="(item, index) in array" :key="JSON.stringify(item)">
          <Draggable
            :index="index"
            :pos-x="20"
            :pos-y="25"
            v-model="array"
            v-model:dragged="draggedIndex"
            class="py-4"
          >
            {{ item.name }}
          </Draggable>
        </li>
      </ul>
    </section>
  </div>
</template>

<style scoped></style>
