import { defineStore } from 'pinia'
import { computed, ref } from 'vue'

export const useSidebarStore = defineStore('sidebar', () => {
  const isOpen = ref(true)

  const toggle = () => {
    isOpen.value = !isOpen.value
  }

  const classes = computed(() => {
    return {
      'translate-0': isOpen.value,
      '-translate-x-full': !isOpen.value,
    }
  })

  return { toggle, isOpen, classes }
})
