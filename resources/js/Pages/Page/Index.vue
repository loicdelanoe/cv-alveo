<script setup lang="ts">
import ClientLayout from '@/Layouts/ClientLayout.vue'

import type { Menu } from '@/types/models/menu'
import type { Page } from '@/types/models/page'

defineProps<{
  page: Page
  menus: Menu[]
}>()
</script>

<template>
  <ClientLayout :menus="menus" :page="page" />
</template>

<style scoped></style>
