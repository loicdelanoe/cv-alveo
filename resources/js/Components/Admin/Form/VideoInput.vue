<script setup lang="ts">
import axios from 'axios'
import { computed, ref } from 'vue'

import ErrorMessage from '@/Components/Admin/Form/ErrorMessage.vue'
import Modal from '@/Components/Admin/Modal/Modal.vue'
import Media from '@/Components/Admin/Ui/Media.vue'
import MediaCreate from '@/Pages/Admin/Media/Create.vue'

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

const model = defineModel<string | null>({ default: null })

const medias = ref<TMedia[] | null>(null)
const selectedMedia = ref<string | null>(model.value || null)
const isOpen = ref(false)
const isUploadModalOpen = ref(false)
const errorMessage = ref('')

const hasSelectedMedia = computed(() => model.value && selectedMedia.value)

const fetchMedias = async () => {
  try {
    const response = await axios.get(route('admin.media.index'))

    // Filter only images via media type
    medias.value = response.data.filter((media: TMedia) => media.type.startsWith('video/'))
  } catch (e) {
    errorMessage.value = 'Failed to load media. Please try again later.'
    console.error('Media fetch error:', e)
  }
}

const submitMedia = () => {
  if (selectedMedia.value) {
    model.value = selectedMedia.value
  }

  isOpen.value = false
}

const reloadMedias = () => {
  isUploadModalOpen.value = false

  fetchMedias()
}
</script>

<template>
  <div class="flex flex-col gap-2 w-full">
    <label :for="name" class="pl-1.5 font-medium text-md">{{ label }}</label>
    <template v-if="hasSelectedMedia">
      <Media
        v-if="selectedMedia && model"
        :media="selectedMedia?.toString()"
        :key="model"
        class="aspect-square object-cover w-full h-[15rem] rounded-lg"
      />
    </template>

    <Modal
      label="Select Media"
      title="Select Media"
      variant="primary"
      position="center"
      size="4xl"
      @click="fetchMedias"
      v-model="isOpen"
    >
      <template #action>
        <Can permission="create medias">
          <Modal
            label="Upload Media"
            title="Choose a media"
            variant="primary"
            size="xl"
            position="center"
            v-model="isUploadModalOpen"
            icon="plus"
          >
            <MediaCreate @close-modal="reloadMedias" />
          </Modal>
        </Can>
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
              type="radio"
              class="absolute inset-0 bg-transparent appearance-none cursor-pointer rounded-lg"
              :value="media.id"
              v-model="selectedMedia"
            />
          </li>
        </ul>
      </div>

      <template #footer>
        <Action tag="button" variant="primary" v-if="selectedMedia" @click.prevent="submitMedia">
          Submit
        </Action>
      </template>
    </Modal>
    <span v-if="hint" class="opacity-50 italic text-sm">{{ hint }}</span>
    <ErrorMessage :error="error" />
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
