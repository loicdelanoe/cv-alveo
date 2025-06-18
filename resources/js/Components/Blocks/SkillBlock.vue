<script setup lang="ts">
import ResponsiveImage from '@/Components/Admin/Ui/ResponsiveImage.vue'
import { renderMarkdown } from '@/Components/Admin/utils/text'
import Section from '@/Components/Ui/Section.vue'
import { Media } from '@/Pages/Admin/Media/Index.vue'

import IconCheck from '../IconCheck.vue'

defineProps<{
  content: Skills
}>()

type Skill = {
  title: string
  content: string
}

interface Skills {
  title: string
  content: string
  image: Media
  skills: Skill[]
}
</script>

<template>
  <div id="skills" class="relative z-2 bg-black py-32">
    <Section class="flex flex-col justify-center items-center">
      <h2 class="text-4xl md:text-5xl md:max-w-1/2 text-center mb-5">{{ content.title }}</h2>
      <div
        class="cv-wysiwyg max-w-prose text-center mb-12"
        v-html="renderMarkdown(content.content)"
      />
      <div class="flex flex-col gap-12 md:flex-row">
        <ResponsiveImage class="md:max-w-1/2 rounded-lg object-cover" :media="content.image" />
        <dl class="flex flex-col gap-4">
          <div v-for="skill in content.skills" :key="JSON.stringify(skill)">
            <dt class="text-3xl flex items-center gap-2 font-medium mb-4">
              <IconCheck />
              {{ skill.title }}
            </dt>
            <dd class="cv-wysiwyg" v-html="renderMarkdown(skill.content)" />
          </div>
        </dl>
      </div>
    </Section>
  </div>
</template>

<style scoped></style>
