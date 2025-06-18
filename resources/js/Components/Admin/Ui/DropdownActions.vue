<!-- <script setup lang="ts">
import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

import IconBulk from '@/Components/Admin/Icon/IconBulk.vue'
import IconTrash from '@/Components/Admin/Icon/IconTrash.vue'
import { LaravelCollection } from '@/types/models/collection'

const props = defineProps<{
  collectionName: string
  item: LaravelCollection
}>()

const isToggle = ref(false)

const form = useForm({
  item: props.item,
})

const onDelete = () => {
  if (confirm('Are you sure you want to delete this item?')) {
    form.delete(route(`admin.${props.collectionName}.destroy`, props.item.id), {
      preserveScroll: true,
      onSuccess: () => {
        isToggle.value = false
      },
    })
  }
}

const closeDropdown = () => {
  isToggle.value = !isToggle.value
}
</script>

<template>
  <div ref="container" class="relative" v-click-outside="isToggle = false">
    <button
      class="relative w-full cursor-pointer flex items-center justify-center z-5"
      @click="closeDropdown"
    >
      <IconBulk />
    </button>
    <Transition>
      <ul
        v-show="isToggle"
        class="absolute top-8 right-0 bg-white text-secondary-950 shadow z-99 overflow-hidden rounded-md"
      >
        <li>
          <button
            class="cursor-pointer flex items-center gap-4 px-4 py-2.5 text-red-600 hover:bg-secondary-50 font-medium"
            @click="onDelete"
          >
            <IconTrash class="!w-5" />
            Delete
          </button>
        </li>
      </ul>
    </Transition>
  </div>
</template>

<style scoped>
.v-enter-active,
.v-leave-active {
  transition: opacity 0.1s ease-in-out;
}

.v-enter-from,
.v-leave-to {
  opacity: 0;
}
</style> -->
