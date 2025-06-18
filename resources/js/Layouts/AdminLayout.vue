<script setup lang="ts">
import '@Styles/admin/admin.css'

import SideNavigation from '@/Components/Admin/Navigation/SideNavigation.vue'
</script>

<template>
  <div class="layout bg-[#f5f5f5] flex">
    <h1 class="sr-only">Alveo</h1>
    <Suspense>
      <SideNavigation />
    </Suspense>
    <slot />
  </div>
</template>

<style scoped></style>
