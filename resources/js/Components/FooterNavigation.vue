<script setup lang="ts">
import { Menu } from '@/types/models/menu'
import { getRoute } from '@/utils/utils'

import ActionLink from './Ui/ActionLink.vue'
import NavigationLink from './Ui/NavigationLink.vue'

defineProps<{
  menu: Menu
}>()
</script>

<template>
  <div class="relative z-1 bg-black text-white py-12">
    <footer
      class="max-w-[1200px] mx-auto w-full bg-black flex flex-col justify-between items-center md:flex-row px-4 md:px-12 lg:px-0"
    >
      <h2 class="sr-only">{{ menu.name }}</h2>

      <Link class="inline-flex text-3xl font-medium" href="/"> Loïc D.</Link>

      <nav>
        <ul class="flex flex-col items-center md:flex-row max-sm:text-lg">
          <li v-for="page in menu.pages" :key="page.id">
            <NavigationLink :page="page">{{ page.title }}</NavigationLink>
          </li>
          <li v-for="action in menu.actions" :key="JSON.stringify(action)">
            <ActionLink :action="action">{{ action.label }}</ActionLink>
          </li>
        </ul>
      </nav>
    </footer>
  </div>
</template>

<style scoped></style>
