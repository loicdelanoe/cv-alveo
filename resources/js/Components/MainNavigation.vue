<script setup lang="ts">
import { Menu } from '@/types/models/menu'
import { getRoute } from '@/utils/utils'

import ActionLink from './Ui/ActionLink.vue'
import NavigationLink from './Ui/NavigationLink.vue'
import TheButton from './Ui/TheButton.vue'

const props = defineProps<{
  menu: Menu
}>()

const { pages, actions } = props.menu

const ctas = actions.splice(actions.length - 2, 2)
</script>

<template>
  <div class="absolute w-full border-b border-border">
    <header
      class="text-white z-4 py-5 px-4 flex items-center justify-between gap-16 max-w-[1200px] w-full mx-auto md:py-5 md:flex-row md:relative font-medium"
    >
      <Link class="inline-flex text-3xl font-medium" href="/"> Loïc D.</Link>

      <!-- Burger menu -->
      <label
        class="flex flex-col gap-1 absolute z-5 top-1/2 -translate-y-1/2 peer right-8 cursor-pointer h-5 justify-center items-center md:sr-only"
        for="burger"
      >
        <input
          class="cursor-pointer appearance-none peer"
          type="checkbox"
          name="burger"
          id="burger"
        />
        <span class="sr-only">Open burger menu</span>
        <span
          class="block w-5 h-0.5 bg-white peer-checked:rotate-45 peer-checked:translate-y-0.5 transition-all duration-300 ease-in-out"
        ></span>
        <span
          class="block w-5 h-0.5 bg-white peer-checked:-rotate-45 peer-checked:-translate-y-1 transition-all duration-300 ease-in-out"
        ></span>
      </label>
      <!-- Navigation -->
      <nav
        class="fixed inset-0 z-4 flex flex-col gap-6 px-6 py-12 md:p-0 items-center -translate-x-full peer-has-checked:translate-x-0 transition ease-in-out duration-500 md:relative md:translate-x-0 md:flex-row"
      >
        <h2 class="sr-only">{{ menu.name }}</h2>
        <ul class="flex flex-col items-center md:flex-row max-sm:text-lg">
          <li v-for="page in pages" :key="page.slug">
            <NavigationLink :page="page">{{ page.title }}</NavigationLink>
          </li>
          <li v-for="action in actions" :key="JSON.stringify(action)">
            <ActionLink :action="action">{{ action.label }}</ActionLink>
          </li>

          <!-- Ctas -->
          <li class="mr-4">
            <TheButton tag="a" variant="cv-primary" target="_blank" :href="ctas[0].value">
              {{ ctas[0].label }}
            </TheButton>
          </li>
          <li>
            <TheButton tag="a" variant="cv-secondary" :href="ctas[1].value">
              {{ ctas[1].label }}
            </TheButton>
          </li>
        </ul>
      </nav>
    </header>
  </div>
</template>

<style scoped></style>
