<script setup lang="ts">
import Section from '@/Components/Ui/Section.vue'
import { Media } from '@/Pages/Admin/Media/Index.vue'
import { getRoute } from '@/utils/utils'

import ResponsiveImage from '../Admin/Ui/ResponsiveImage.vue'
import TheButton from '../Ui/TheButton.vue'

defineProps<{
  content: Hero
}>()

type Button = { label: string; href: string; variant: string }

interface Hero {
  title: string
  buttons: Button[]
  image: Media
}
</script>

<template>
  <div class="relative">
    <ResponsiveImage
      class="absolute md:fixed inset-0 h-full w-full opacity-50 object-cover"
      :media="content.image"
    />
    <Section
      class="relative z-1 flex flex-col justify-center items-center md:min-h-screen gap-10 pt-42 pb-28 md:pt-20 md:pb-0"
    >
      <h2 class="text-center flex max-w-[60%] text-4xl md:text-7xl">{{ content.title }}</h2>
      <ul class="flex gap-4 items-center">
        <li v-for="button in content.buttons">
          <TheButton tag="Link" :variant="button.variant" :href="getRoute(button.href)">
            {{ button.label }}
          </TheButton>
        </li>
      </ul>
    </Section>
  </div>
</template>

<style scoped></style>
