<script setup lang="ts">
import Section from '@/Components/Ui/Section.vue'

import { renderMarkdown } from '../Admin/utils/text'
import TheButton from '../Ui/TheButton.vue'

defineProps<{
  content: Contact
}>()

type Information = {
  title: string
  content: string
}

interface Contact {
  informations: Information[]
  buttons: {
    label: string
    href: string
  }[]
}
</script>

<template>
  <div class="relative z-2 bg-black border-y border-border">
    <Section class="flex items-center py-13 gap-4">
      <dl class="flex w-full justify-between">
        <div v-for="info in content.informations" :key="JSON.stringify(info)">
          <dt class="text-lg mb-2 font-medium">{{ info.title }}</dt>
          <dd class="cv-wysiwyg" v-html="renderMarkdown(info.content)" />
        </div>
      </dl>
      <ul class="flex flex-shrink-0">
        <li v-for="button in content.buttons" :key="JSON.stringify(button)">
          <TheButton tag="Link" variant="cv-secondary" :href="button.href">
            {{ button.label }}
          </TheButton>
        </li>
      </ul>
    </Section>
  </div>
</template>

<style scoped></style>
