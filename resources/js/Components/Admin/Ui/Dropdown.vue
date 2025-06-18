<script setup lang="ts">
import { vOnClickOutside } from '@vueuse/components'
import { onMounted, onUnmounted, shallowRef, useTemplateRef } from 'vue'

const isOpen = shallowRef(false)
const button = useTemplateRef<HTMLElement>('button')

const handleEscape = (e: KeyboardEvent) => {
  if (e.key === 'Escape') {
    isOpen.value = false
  }
}

const onClickOutsideHandler = [
  () => {
    isOpen.value = false
  },
  { ignore: [button] },
]

onMounted(() => document.addEventListener('keydown', handleEscape))
onUnmounted(() => document.removeEventListener('keydown', handleEscape))
</script>

<template>
  <div class="relative">
    <Action
      tag="button"
      size="small"
      variant="outline"
      ref="button"
      @click.prevent="isOpen = !isOpen"
      class="cursor-pointer"
      tabindex="1"
    >
      Bulk Actions
    </Action>

    <Transition
      enter-active-class="transition ease-out duration-200"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="transition ease-in duration-75"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div
        v-show="isOpen"
        v-on-click-outside="onClickOutsideHandler"
        class="z-10 absolute max-sm:left-0 md:right-0 top-full mt-2 p-1.5 rounded-xl bg-white shadow border-1 border-secondary-200 w-max"
      >
        <slot />
      </div>
    </Transition>
  </div>
</template>

<style scoped></style>
