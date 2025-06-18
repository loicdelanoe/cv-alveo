<script setup lang="ts">
import { useForm } from '@inertiajs/vue3'
import { computed, ref, watch } from 'vue'

import CheckboxInput from '@/Components/Admin/Form/CheckboxInput.vue'
import ErrorMessage from '@/Components/Admin/Form/ErrorMessage.vue'
import InputLabel from '@/Components/Admin/Form/InputLabel.vue'
import ToggleInput from '@/Components/Admin/Form/ToggleInput.vue'
import IconPlus from '@/Components/Admin/Icon/IconPlus.vue'
import Breadcrumbs from '@/Components/Admin/Ui/Breadcrumbs.vue'
import Container from '@/Components/Admin/Ui/Container.vue'
import { slugify } from '@/Components/Admin/utils/text'
import PanelLayout from '@/Layouts/PanelLayout.vue'

import type { Page } from '@/types/models/page'

const props = defineProps<{
  pages: Page[]
}>()

const breadcrumbs = [
  {
    label: 'Menus',
    href: route('admin.menu.index'),
  },
]
const form = useForm({
  name: '',
  slug: '',
  active: false,
  pages: [] as number[],
})

const searchPage = ref('')

const filteredPages = computed(() => {
  return props.pages.filter(page => {
    return page.title.toLowerCase().includes(searchPage.value.toLowerCase())
  })
})

const onSubmit = () => {
  form.post(route('admin.menu.store'))
}

watch(
  () => form.name,
  newTitle => {
    form.slug = slugify(newTitle)
  }
)
</script>

<template>
  <PanelLayout title="Create">
    <template #breadcrumbs>
      <Breadcrumbs :links="breadcrumbs" />
    </template>

    <template #action>
      <ToggleInput
        label="Active"
        name="active"
        type="checkbox"
        v-model="form.active"
        :error="form.errors.active"
        reverse
      />
      <Action tag="button" variant="primary" @click="onSubmit">
        <IconPlus />
        Create Menu
      </Action>
    </template>

    <!-- <form @submit.prevent="onSubmit" class="flex flex-col gap-2"> -->
    <Container tag="section" class="flex flex-col md:flex-row gap-4 md:gap-6">
      <h3 class="sr-only">General</h3>
      <InputLabel
        label="Name"
        name="name"
        type="text"
        placeholder="Main…"
        v-model="form.name"
        :error="form.errors.name"
      />
      <InputLabel
        label="Slug"
        name="slug"
        type="text"
        placeholder="main-menu…"
        v-model="form.slug"
        :error="form.errors.slug"
        hint="A unique identifier"
      />
    </Container>

    <section class="flex flex-col gap-4">
      <h3 class="text-xl font-medium">Pages</h3>
      <InputLabel
        label="Search"
        name="search"
        type="search"
        placeholder="Search page…"
        v-model="searchPage"
      />
      <ErrorMessage :error="form.errors.pages" />
      <ul class="flex flex-col gap-2">
        <li
          v-for="page in filteredPages"
          :key="page.id"
          class="rounded-lg flex gap-2 items-center transition bg-white"
          :class="{
            'bg-secondary-100 font-medium': form.pages.includes(page.id),
          }"
        >
          <CheckboxInput
            :label="page.title"
            :name="page.slug"
            :value="page.id"
            v-model="form.pages"
            class="page-checkbox w-full pl-3 cursor-pointer"
          />
        </li>
      </ul>
      <!-- <Action tag="button" variant="primary">
            <IconPlus />
            Create Menu
          </Action> -->
    </section>
    <!-- </form> -->
  </PanelLayout>
</template>

<style scoped>
.page-checkbox :deep(label) {
  padding: 1.125rem 0.75rem;
}
</style>
