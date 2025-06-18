<script setup lang="ts">
import axios from 'axios'
import { ModelRef, ref } from 'vue'

import Modal from '@/Components/Admin/Modal/Modal.vue'
import ResponsiveImage from '@/Components/Admin/Ui/ResponsiveImage.vue'
import MediaCreate from '@/Pages/Admin/Media/Create.vue'

import Action from '../Action.vue'
import IconCheck from '../Icon/IconCheck.vue'
import Media from '../Ui/Media.vue'

import type { Media as TMedia } from '@/Pages/Admin/Media/Index.vue'

defineProps<{
  label: string
  name: string
  error?: string
  required?: boolean
  value?: string
  hint?: string
  disabled?: boolean
}>()

const model = defineModel({ default: [] }) as ModelRef<string | null>
const medias = ref<TMedia[] | null>(null)

const fetchMedia = async () => {
  try {
    const response = await axios.get(route('admin.media.index'))

    medias.value = response.data
  } catch (e) {
    console.error(e)
  }
}

// const selectedMedia = ref<string | null>(model.value || null)
const isOpen = ref(false)
const uploadModal = ref(false)

const submitMedia = () => {
  if (model.value) {
    model.value = model.value
  }

  isOpen.value = false
}

const reloadMedias = () => {
  uploadModal.value = false

  fetchMedia()
}
</script>

<template>
  <div class="flex flex-col gap-2 w-full">
    <label :for="name" class="pl-1.5 font-medium text-md">{{ label }}</label>
    <div class="flex flex-wrap gap-4">
      <template v-for="image in model" :key="JSON.stringify(image)">
        <Media
          class="aspect-square object-cover h-[13rem] w-[13rem] rounded-lg"
          v-if="image"
          :media="image.toString()"
          :key="image"
        />
      </template>
    </div>

    <Modal
      label="Select Media"
      title="Select Media"
      variant="primary"
      position="center"
      size="xl"
      @click="fetchMedia"
      v-model="isOpen"
    >
      <template #action>
        <Modal
          label="Upload Media"
          title="Choose a media"
          variant="primary"
          size="xl"
          position="center"
          v-model="uploadModal"
          icon="plus"
        >
          <MediaCreate @close-modal="reloadMedias" />
        </Modal>
      </template>

      <div v-if="medias" class="flex flex-col gap-6">
        <ul class="flex flex-wrap gap-4">
          <li
            v-for="(media, index) in medias"
            :key="media.id"
            class="relative after:content-[''] after:inset-0 hover:after:bg-black/30 after:z-10 after:absolute after:rounded-lg after:pointer-events-none after:transition"
          >
            <div class="max-w-[12rem] aspect-square relative">
              <Media class="w-full object-cover h-full rounded-lg" :media="media" />
            </div>
            <input
              type="checkbox"
              class="absolute inset-0 bg-transparent cursor-pointer rounded-lg appearance-none checked:border-2 checked:border-accent-300 peer"
              :value="media.id"
              v-model="model"
            />
            <span
              class="peer-checked:opacity-100 transition opacity-0 top-2 right-2 absolute rounded-full bg-accent-400 inline-flex text-secondary-950 aspect-square items-center justify-center"
            >
              <IconCheck />
            </span>
          </li>
        </ul>
      </div>

      <template #footer>
        <Action tag="button" variant="primary" v-if="model" @click.prevent="submitMedia">
          Submit
        </Action>
      </template>
    </Modal>
    <span v-if="hint" class="opacity-50 italic text-sm">{{ hint }}</span>
    <span v-if="error" class="text-red-500 font-medium">
      {{ Array.isArray(error) ? error[0] : error }}
    </span>
  </div>
</template>

<style scoped>
@reference "../../../../css/admin/admin.css";

input[type='radio'] {
  @apply border-0 transition;
}

input[type='radio']:checked {
  @apply border-2 border-secondary-500;
}
</style>
