<script setup lang="ts">
import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

const form = useForm({
  files: null as File | File[] | null,
})

const imagePreviews = ref<string[]>([])
const emit = defineEmits(['closeModal'])

const handleFile = (e: Event) => {
  const target = e.target as HTMLInputElement // Assert the target as HTMLInputElement
  if (!target || !target.files) return

  const files = Array.from(target.files) // Convert FileList to Array

  form.files = files

  Array.from(files).forEach((file: File) => {
    const reader = new FileReader()

    reader.onload = (e: ProgressEvent<FileReader>) => {
      if (e.target?.result) {
        imagePreviews.value?.push(e.target.result as string)
      }
    }

    reader.readAsDataURL(file)
  })
}

const onSubmit = () => {
  form.post(route('admin.media.store'), {
    preserveScroll: true,
    onSuccess: () => emit('closeModal'),
  })
}
</script>

<template>
  <div class="flex flex-col items-start gap-2">
    <div v-if="imagePreviews" class="w-full flex flex-wrap gap-4">
      <img
        v-for="image in imagePreviews"
        :key="image"
        :src="image"
        alt="Preview"
        class="w-62 object-cover aspect-square rounded-lg"
      />
    </div>
    <input type="file" name="file" id="file" @input="handleFile" multiple />
    <Action
      v-if="form.files"
      tag="button"
      variant="primary"
      class="ml-auto"
      @click.prevent="onSubmit"
    >
      Upload
    </Action>
    <span class="text-red-500 font-medium" v-if="form.errors">
      {{ Object.values(form.errors)[0] }}
    </span>
  </div>
</template>

<style scoped></style>
