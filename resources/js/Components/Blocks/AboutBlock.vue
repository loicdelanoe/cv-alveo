<script setup lang="ts">
import ResponsiveImage from '@/Components/Admin/Ui/ResponsiveImage.vue'
import { renderMarkdown } from '@/Components/Admin/utils/text'
import Section from '@/Components/Ui/Section.vue'
import TheButton from '@/Components/Ui/TheButton.vue'
import { Media } from '@/Pages/Admin/Media/Index.vue'

defineProps<{
  content: About
}>()

interface About {
  title: string
  content: string
  image: Media
  buttons: {
    label: string
    href: string
    variant: string
  }[]
}
</script>

<template>
  <div class="relative z-2 bg-black py-32 border-b border-border">
    <Section
      class="flex justify-between items-center after:border after:border-border after:rounded-lg after:absolute after:right-0 after:left-0 after:top-10 after:bottom-10 after:content-[''] after:-z-1 px-20"
    >
      <ResponsiveImage class="rounded-lg" :media="content.image" />
      <div class="flex flex-col gap-4 max-w-1/2">
        <h2 class="text-5xl">{{ content.title }}</h2>
        <div v-html="renderMarkdown(content.content)" />
        <ul class="flex">
          <li v-for="button in content.buttons" :key="JSON.stringify(button)">
            <TheButton tag="Link" :variant="button.variant">{{ button.label }}</TheButton>
          </li>
        </ul>
      </div>
    </Section>
  </div>
</template>

<style scoped></style>
