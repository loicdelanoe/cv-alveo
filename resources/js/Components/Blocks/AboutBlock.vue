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
  <div id="about" class="relative z-2 bg-black py-32 border-b border-border">
    <Section class="flex flex-col justify-between items-center md:px-20 section-border md:flex-row">
      <ResponsiveImage
        class="rounded-lg mb-8 md:mb-0 aspect-square md:aspect-auto object-cover"
        :media="content.image"
      />
      <div class="flex flex-col gap-4 text-center md:max-w-1/2 md:text-left">
        <h2 class="text-4xl md:text-5xl">{{ content.title }}</h2>
        <div class="cv-wysiwyg" v-html="renderMarkdown(content.content)" />
        <ul class="flex flex-col gap-4 items-center flex-wrap md:flex-row">
          <li v-for="button in content.buttons" :key="JSON.stringify(button)">
            <TheButton tag="Link" :variant="button.variant" :href="button.href">{{
              button.label
            }}</TheButton>
          </li>
        </ul>
      </div>
    </Section>
  </div>
</template>

<style scoped></style>
