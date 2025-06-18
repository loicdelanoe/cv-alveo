<script setup lang="ts">
import Section from '@/Components/Ui/Section.vue'

import { renderMarkdown } from '../Admin/utils/text'

defineProps<{
  content: Opinion
}>()

type Card = {
  title: string
  content: string
}

interface Opinion {
  title: string
  content: string
  cards: Card[]
}
</script>

<template>
  <div id="opinion" class="relative z-2 bg-black py-32 border-b border-border">
    <Section class="flex flex-col justify-center items-center gap-20">
      <div class="flex justify-between gap-12">
        <h2 class="text-5xl">{{ content.title }}</h2>
        <div class="max-w-1/2 cv-wysiwyg" v-html="renderMarkdown(content.content)" />
      </div>
      <dl class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <div
          v-for="card in content.cards"
          :key="JSON.stringify(card)"
          class="flex flex-col gap-6 items-start border border-border rounded-md p-6"
        >
          <dt class="text-xl font-medium inline-flex bg-border p-4 rounded-md">{{ card.title }}</dt>
          <dd class="cv-wysiwyg" v-html="renderMarkdown(card.content)" />
        </div>
      </dl>
    </Section>
  </div>
</template>

<style scoped></style>
