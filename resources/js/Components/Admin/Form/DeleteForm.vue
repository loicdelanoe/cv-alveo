<script setup lang="ts">
import { router } from '@inertiajs/vue3'

import Button from '@/Components/Admin/Form/TheButton.vue'

const props = defineProps<{
  route: string | URL
  // TODO: Type this
  options?: Record<string, any>
}>()

const onSubmit = () => {
  router.delete(props.route, props.options)
}
</script>

<template>
  <Button @click="onSubmit">
    <slot />
  </Button>
</template>

<style scoped></style>
