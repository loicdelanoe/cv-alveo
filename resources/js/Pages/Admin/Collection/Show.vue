<script setup lang="ts">
import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

import FieldBuilder from '@/Components/Admin/Form/FieldBuilder.vue'
import InputLabel from '@/Components/Admin/Form/InputLabel.vue'
import SelectInput from '@/Components/Admin/Form/SelectInput.vue'
import TextAreaInput from '@/Components/Admin/Form/TextAreaInput.vue'
import IconTrash from '@/Components/Admin/Icon/IconTrash.vue'
import Breadcrumbs from '@/Components/Admin/Ui/Breadcrumbs.vue'
import Container from '@/Components/Admin/Ui/Container.vue'
import TabsHead from '@/Components/Admin/Ui/TabsHead.vue'
import VisitLink from '@/Components/Admin/Ui/VisitLink.vue'
import PanelLayout from '@/Layouts/PanelLayout.vue'
import { deleteItem } from '@/utils/utils'

import { Collection } from './Index.vue'

const { collection, collectionType } = defineProps<{
  collection: Collection
  collectionType: any
}>()

const tab = ref(0)
const tabs = [
  { name: 'General', id: 0 },
  { name: 'SEO', id: 1 },
]
const status = ['draft', 'published']

const form = useForm({
  status: collection.status,
  title: collection.title,
  slug: collection.slug,
  meta_title: collection.meta_title,
  meta_description: collection.meta_description,
  og_type: collection.og_type,
  content: collection.content,
})

const onSubmit = () => {
  form.patch(
    route('admin.collection.update', {
      collectionType: collectionType.type,
      collection: collection.slug,
    }),
    {
      preserveScroll: true,
    }
  )
}

const links = [
  {
    label: collectionType.name,
    href: route('admin.collection-type.show', collectionType.type),
  },
  {
    label: collection.title,
    href: route('admin.collection.show', {
      collectionType: collectionType.type,
      collection: collection.slug,
    }),
  },
]
</script>

<template>
  <PanelLayout :title="collection.title">
    <template #breadcrumbs>
      <Breadcrumbs :links="links" />
    </template>

    <template #action>
      <Action
        tag="button"
        :variant="['delete', 'icon']"
        @click.prevent="
          deleteItem(
            route('admin.collection.destroy', collection.slug),
            'Do you really want to delete this collection?',
            form
          )
        "
      >
        <IconTrash />
      </Action>
    </template>
    <div class="grid grid-cols-1 gap-5 relative lg:grid-cols-3">
      <div class="flex flex-col lg:col-span-2">
        <TabsHead :tabs="tabs" v-model="tab" />
        <!-- General -->
        <!-- Title and Slug -->
        <div v-show="tab === 0" class="flex flex-col w-full gap-6">
          <Container tag="section" class="flex flex-col md:flex-row gap-4">
            <h3 class="sr-only">General</h3>
            <InputLabel label="Title" name="title" type="text" v-model="form.title" />
            <InputLabel label="Slug" name="slug" type="text" v-model="form.slug" />
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
          <!-- <p class="font-medium text-lg mb-2">API response</p>
          <pre
            class="bg-secondary-950 text-white p-5 rounded-lg overflow-scroll w-full no-scrollbar shadow"
          >
              {{ collection }}
            </pre
          > -->
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
        <p v-if="form.isDirty" class="font-medium text-orange-600 italic">
          Form has unsaved changes
        </p>
        <Action tag="Link" @click="onSubmit" variant="primary" type="button"> Save </Action>
        <VisitLink
          class="mx-auto"
          :href="
            route('page.collection', {
              collection: collectionType.type,
              slug: collection.slug,
            })
          "
        />
      </Container>
    </div>
  </PanelLayout>
</template>

<style scoped></style>
