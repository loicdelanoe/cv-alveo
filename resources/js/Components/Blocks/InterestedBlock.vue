<script setup lang="ts">
import Section from '@/Components/Ui/Section.vue'
import { Media } from '@/Pages/Admin/Media/Index.vue'

import ResponsiveImage from '../Admin/Ui/ResponsiveImage.vue'
import { renderMarkdown } from '../Admin/utils/text'
import TheButton from '../Ui/TheButton.vue'

defineProps<{
  content: Interested
}>()

interface Interested {
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
  <div id="opinion" class="relative z-2 bg-black pb-32 border-b border-border px-4 md:px-12">
    <Section
      class="relative overflow-hidden flex flex-col justify-between items-center gap-6 lg:gap-20 border border-border rounded-lg py-4 md:py-0 md:flex-row md:!px-0"
    >
      <div class="md:max-w-1/2 lg:max-w-1/3 flex flex-col gap-4 md:gap-6 md:p-6 lg:pl-20">
        <h2 class="text-4xl">{{ content.title }}</h2>
        <div class="cv-wysiwyg" v-html="renderMarkdown(content.content)" />
        <ul class="flex flex-col gap-4 items-start md:items-center flex-wrap md:flex-row">
          <li v-for="button in content.buttons" :key="JSON.stringify(button)">
            <TheButton tag="a" :variant="button.variant" :href="button.href">
              {{ button.label }}
            </TheButton>
          </li>
        </ul>
      </div>
      <ResponsiveImage
        class="absolute lg:relative inset-0 w-full h-auto object-cover max-lg:opacity-30"
        :media="content.image"
      />
    </Section>
  </div>
</template>

<style scoped></style>
