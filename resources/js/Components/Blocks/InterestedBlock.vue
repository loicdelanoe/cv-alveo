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
  <div id="opinion" class="relative z-2 bg-black pb-32 border-b border-border">
    <Section class="flex justify-between items-center gap-20 border border-border rounded-lg">
      <div class="max-w-1/3 flex flex-col gap-6 pl-20">
        <h2 class="text-4xl">{{ content.title }}</h2>
        <div class="cv-wysiwyg" v-html="renderMarkdown(content.content)" />
        <ul class="flex gap-4 items-center flex-wrap">
          <li v-for="button in content.buttons" :key="JSON.stringify(button)">
            <TheButton tag="a" :variant="button.variant" :href="button.href">
              {{ button.label }}
            </TheButton>
          </li>
        </ul>
      </div>
      <ResponsiveImage :media="content.image" />
    </Section>
  </div>
</template>

<style scoped></style>
