<script setup lang="ts">
import { useForm } from '@inertiajs/vue3'
import { ref, watch } from 'vue'

import FieldBuilder from '@/Components/Admin/Form/FieldBuilder.vue'
import InputLabel from '@/Components/Admin/Form/InputLabel.vue'
import SelectInput from '@/Components/Admin/Form/SelectInput.vue'
import TextAreaInput from '@/Components/Admin/Form/TextAreaInput.vue'
import Breadcrumbs from '@/Components/Admin/Ui/Breadcrumbs.vue'
import Container from '@/Components/Admin/Ui/Container.vue'
import TabsHead from '@/Components/Admin/Ui/TabsHead.vue'
import { slugify } from '@/Components/Admin/utils/text'
import PanelLayout from '@/Layouts/PanelLayout.vue'
import { CollectionType } from '@/Pages/Admin/CollectionType/Index.vue'

const status = ['draft', 'published']

const props = defineProps<{
  collectionType: CollectionType
}>()

const tabs = [
  { name: 'General', id: 0 },
  { name: 'SEO', id: 1 },
]

const tab = ref(0)

const form = useForm({
  status: 'draft',
  title: '',
  slug: '',
  meta_title: '',
  meta_description: '',
  og_type: '',
  content: {},
})

watch(
  () => form.title,
  newTitle => {
    form.slug = slugify(newTitle)
  }
)

const onSubmit = () => {
  form.post(route('admin.collection.store', props.collectionType.type))
}

const links = [
  {
    label: props.collectionType.name,
    href: route('admin.collection-type.show', props.collectionType.type),
  },
]
</script>

<template>
  <PanelLayout title="Create">
    <template #breadcrumbs>
      <Breadcrumbs :links="links" />
    </template>

    <div class="grid grid-cols-1 gap-5 relative lg:grid-cols-3">
      <div class="flex flex-col lg:col-span-2">
        <TabsHead :tabs="tabs" v-model="tab" />

        <!-- General -->
        <!-- Title and Slug -->
        <div v-show="tab === 0" class="flex flex-col w-full gap-6">
          <Container tag="section" class="flex flex-col md:flex-row gap-4">
            <h3 class="sr-only">General</h3>
            <InputLabel
              label="Title"
              name="title"
              type="text"
              v-model="form.title"
              :error="form.errors.title"
            />
            <InputLabel
              label="Slug"
              name="slug"
              type="text"
              v-model="form.slug"
              :error="form.errors.slug"
              hint="A unique identifier"
            />
          </Container>

          <!-- Fields -->
          <Container tag="section" class="flex flex-col gap-4">
            <h3 class="mb-2 text-2xl font-medium">Fields</h3>
            <div
              v-for="field in collectionType.fields"
              class="flex flex-col gap-4"
              :key="JSON.stringify(field)"
            >
              <FieldBuilder :field="field" :form="form" />
            </div>
          </Container>
        </div>

        <!-- SEO -->
        <Container v-show="tab === 1" tag="section" class="flex flex-col gap-4">
          <h3 class="text-xl font-medium sr-only">SEO</h3>
          <InputLabel label="Meta title" name="meta_title" type="text" v-model="form.meta_title" />
          <TextAreaInput
            label="Meta description"
            name="meta_description"
            type="text"
            v-model="form.meta_description"
          />
          <InputLabel label="Open Graph type" name="og_type" type="text" v-model="form.og_type" />
        </Container>
      </div>

      <!-- Status -->
      <Container tag="aside" class="flex flex-col gap-2 lg:sticky lg:top-7 self-start w-full">
        <h3 class="sr-only">Aside</h3>
        <SelectInput name="status" label="Status" :options="status" v-model="form.status" />
        <Action tag="Link" @click="onSubmit" variant="primary" type="button"> Save </Action>
      </Container>
    </div>
  </PanelLayout>
</template>

<style scoped></style>
