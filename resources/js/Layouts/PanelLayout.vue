<script setup lang="ts">
import IconPanelLeft from '@/Components/Admin/Icon/IconPanelLeft.vue'
import NotificationBar from '@/Components/Admin/Ui/NotificationBar.vue'
import { useSidebarStore } from '@/stores/sidebar'

defineProps<{
  title: string
  subtitle?: string
}>()

const sidebar = useSidebarStore()
</script>

<template>
  <main
    class="w-full px-4 py-7 md:p-7 relative transition-all min-h-screen"
    :class="{ 'md:ml-68': sidebar.isOpen }"
  >
    <div class="flex flex-col md:flex-row md:items-end mb-5 gap-4">
      <div class="flex gap-2">
        <IconPanelLeft @click="sidebar.toggle" class="cursor-pointer self-center" />
        <div class="flex flex-col">
          <slot name="breadcrumbs" />
          <h2 class="text-2xl md:text-4xl font-medium">
            {{ title }}
          </h2>
        </div>
      </div>

      <div class="md:ml-auto flex gap-4 items-center">
        <slot name="action" />
      </div>
    </div>
    <NotificationBar />
    <Suspense>
      <slot />
    </Suspense>
  </main>
</template>

<style scoped>
.title {
  font-size: var(--fs-h1);
}
</style>
