<script setup lang="ts">
import axios from 'axios'
import { computed, ref } from 'vue'

import ErrorMessage from '@/Components/Admin/Form/ErrorMessage.vue'
import IconFile from '@/Components/Admin/Icon/IconFile.vue'
import ResponsiveImage from '@/Components/Admin/Ui/ResponsiveImage.vue'

import type { Media } from '@/Pages/Admin/Media/Index.vue'

const props = defineProps<{
  media: Media | string
  width?: string
  height?: string
}>()

const errorMessage = ref('')

const getMedia = async (id: Media | string) => {
  if (typeof id === 'string') {
    try {
      const response = await axios.get(route('api.media', id))

      return response.data
    } catch (error) {
      console.error('Error fetching media:', error)
      errorMessage.value = 'Failed to load media. Please try again later.'
    }
  } else {
    return id
  }
}

const currentMedia = await getMedia(props.media)

const isImage = computed(() => {
  if (!currentMedia) {
    return ''
  }

  return currentMedia.type.startsWith('image/') && !currentMedia.type.includes('svg')
})
const isVideo = computed(() => {
  if (!currentMedia) {
    return ''
  }

  return currentMedia.type.startsWith('video/')
})
</script>

<template>
  <template v-if="currentMedia">
    <img
      v-bind="$attrs"
      v-if="currentMedia.type.includes('svg')"
      loading="lazy"
      :width="width ?? currentMedia.metadata.width"
      :height="height ?? currentMedia.metadata.height"
      :src="currentMedia.path"
      :alt="currentMedia.metadata.alt ?? currentMedia.metadata.title"
    />
    <ResponsiveImage v-else-if="isImage" :media="currentMedia" v-bind="$attrs" />
    <video v-else-if="isVideo" v-bind="$attrs">
      <source :src="currentMedia.path" :type="currentMedia.type" />
    </video>
    <div
      v-else
      class="bg-secondary-200 p-12 flex justify-center items-center aspect-square"
      v-bind="$attrs"
    >
      <IconFile width="w-19 h-19" stroke-width="1" />
    </div>
  </template>
  <ErrorMessage v-else :error="errorMessage" />
</template>

<style scoped></style>
