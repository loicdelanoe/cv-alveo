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
}
</script>

<template>
  <div class="relative z-2 bg-black border-y border-border">
    <Section class="flex items-center py-13 gap-4">
      <dl class="flex flex-col justify-center w-full gap-5 md:justify-between md:flex-row">
        <div
          class="flex flex-col items-center md:items-start"
          v-for="info in content.informations"
          :key="JSON.stringify(info)"
        >
          <dt class="text-lg mb-2 font-medium">{{ info.title }}</dt>
          <dd class="cv-wysiwyg" v-html="renderMarkdown(info.content)" />
        </div>
      </dl>
    </Section>
  </div>
</template>

<style scoped></style>
