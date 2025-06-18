<script setup lang="ts">
import { ref } from 'vue'

import Modal from '@/Components/Admin/Modal/Modal.vue'
import Media from '@/Components/Admin/Ui/Media.vue'
import ResponsiveImage from '@/Components/Admin/Ui/ResponsiveImage.vue'
import TheLightbox from '@/Components/Admin/Ui/TheLightbox.vue'
import PanelLayout from '@/Layouts/PanelLayout.vue'
import MediaCreate from '@/Pages/Admin/Media/Create.vue'

type Paths = {
  [key: string]: string
}

export interface Media {
  id: number
  name: string
  path: Paths
  type: string
  metadata: MetaData
}

export type MetaData = {
  width: number
  height: number
  alt: string
}

const props = defineProps<{
  medias: Media[]
}>()

const isOpen = ref(false)

const lightbox = ref(false)
const mediaIndex = ref(0)

const openLightbox = (index: number) => {
  mediaIndex.value = index

  lightbox.value = true
}
</script>

<template>
  <PanelLayout class="relative" title="Medias">
    <template #action>
      <Can permission="create medias">
        <Modal
          label="Upload Media"
          title="Choose a media"
          variant="primary"
          size="4xl"
          position="center"
          v-model="isOpen"
          icon="plus"
        >
          <MediaCreate @close-modal="isOpen = false" />
        </Modal>
      </Can>
    </template>

    <ul class="grid grid-cols-2 sm:grid-cols-3 md:flex md:flex-wrap md:gap-2">
      <li
        v-for="(media, index) in medias"
        :key="media.id"
        class="md:max-w-[12rem] w-full aspect-square"
      >
        <div
          class="relative p-2 after:content-[''] after:inset-0 hover:after:bg-secondary-300/30 after:absolute after:rounded-lg after:pointer-events-none after:transition"
        >
          <Media
            class="w-full object-cover h-full aspect-square rounded-lg z-2 relative"
            :media="media"
            width="150"
            height="150"
          />

          <div class="flex flex-col cursor-pointer">
            <span class="font-medium truncate text-ellipsis max-w-prose">{{ media.name }}</span>
            <span class="text-sm truncate text-ellipsis max-w-prose">{{ media.type }}</span>
          </div>

          <button @click="openLightbox(index)" class="absolute inset-0 z-3 cursor-pointer">
            <span class="sr-only"> View {{ media.name }}</span>
          </button>
        </div>
      </li>
    </ul>
    <TheLightbox v-model:is-open="lightbox" v-model:media-index="mediaIndex" :medias="medias" />
  </PanelLayout>
</template>

<style scoped></style>
