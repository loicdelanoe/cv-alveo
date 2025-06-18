<script setup lang="ts">
import { useForm, usePage } from '@inertiajs/vue3'
import { ref, watch } from 'vue'

import { ExtendedPageProps } from '@/Components/Admin/Form/AsideField.vue'
import InputLabel from '@/Components/Admin/Form/InputLabel.vue'
import Block from '@/Components/Admin/Form/Page/Block.vue'
import MultiBlockAdd from '@/Components/Admin/Form/Page/MultiBlockAdd.vue'
import MultiBlockCreate from '@/Components/Admin/Form/Page/MultiBlockCreate.vue'
import SelectInput from '@/Components/Admin/Form/SelectInput.vue'
import TextAreaInput from '@/Components/Admin/Form/TextAreaInput.vue'
import ToggleInput from '@/Components/Admin/Form/ToggleInput.vue'
import IconPlus from '@/Components/Admin/Icon/IconPlus.vue'
import Modal from '@/Components/Admin/Modal/Modal.vue'
import Breadcrumbs from '@/Components/Admin/Ui/Breadcrumbs.vue'
import Container from '@/Components/Admin/Ui/Container.vue'
import TabsHead from '@/Components/Admin/Ui/TabsHead.vue'
import { slugify } from '@/Components/Admin/utils/text'
import PanelLayout from '@/Layouts/PanelLayout.vue'

import { BlockType } from '../Block/Create.vue'
import { PageForm } from './Show.vue'

import type { Block as TBlock } from '@/types/models/block'

const tabs = [
  { name: 'General', id: 0 },
  { name: 'SEO', id: 1 },
  { name: 'Settings', id: 2 },
]
const status = ['draft', 'published']

const pageProps = usePage<ExtendedPageProps>().props

const draggedIndex = ref<number | null>(null)

const tab = ref(0)
const createBlockModal = ref(false)
const existingBlockModal = ref(false)

defineProps<{
  blocks: TBlock[]
  blockTypes: BlockType[]
}>()

const form = useForm<PageForm>({
  status: 'draft',
  title: '',
  slug: '',
  meta_title: '',
  meta_description: '',
  og_type: '',
  blocks: [] as TBlock[],
  is_archive: false,
  collection_type_id: null,
})

const onSubmit = () => {
  form.post(route('admin.page.store'))
}

watch(
  () => form.title,
  newTitle => {
    form.slug = slugify(newTitle)
  }
)

const breadcrumbs = [
  {
    label: 'Pages',
    href: route('admin.page.index'),
  },
]

const collectionTypesOptions = Object.keys(pageProps.collectionTypes).map(key => ({
  label: key,
  value: pageProps.collectionTypes[key],
}))
</script>

<template>
  <PanelLayout title="Create">
    <template #breadcrumbs>
      <Breadcrumbs :links="breadcrumbs" />
    </template>
    <div>
      <div class="grid grid-cols-1 md:flex-row gap-5 relative lg:grid-cols-3">
        <div class="flex flex-col w-full lg:col-span-2">
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
              <div class="w-full">
                <InputLabel
                  label="Slug"
                  name="slug"
                  type="text"
                  v-model="form.slug"
                  hint="A unique identifier"
                  :error="form.errors.slug"
                />
              </div>
            </Container>
            <!-- Blocks -->
            <section>
              <h3 class="mb-2 text-2xl font-medium">Blocks</h3>
              <div class="flex flex-col gap-4 mb-4">
                <template v-for="(block, index) in form.blocks" :key="block.id">
                  <Block
                    :index="index"
                    :block-type="
                      blockTypes.find(blockType => blockType.id === block.block_type_id)!
                    "
                    :block="block"
                    :page-form="form"
                    v-model:dragged-index="draggedIndex"
                  />
                </template>
              </div>
              <div class="flex gap-4">
                <Modal
                  variant="primary"
                  size="lg"
                  label="Create block"
                  title="Create block"
                  position="left"
                  v-model="createBlockModal"
                >
                  <MultiBlockCreate
                    :block-types="blockTypes"
                    :page-form="form"
                    @close-modal="createBlockModal = false"
                  />
                </Modal>
                <Modal
                  variant="outline"
                  size="lg"
                  label="Add existing block"
                  title="Add existing block"
                  position="left"
                  v-model="existingBlockModal"
                >
                  <MultiBlockAdd
                    :block-types="blockTypes"
                    :page-form="form"
                    @close-modal="existingBlockModal = false"
                  />
                </Modal>
              </div>
            </section>
          </div>

          <!-- SEO -->
          <Container tag="section" v-show="tab === 1" class="flex flex-col gap-4">
            <h3 class="text-xl font-medium sr-only">SEO</h3>
            <InputLabel
              label="Meta title"
              name="meta_title"
              type="text"
              v-model="form.meta_title"
              :error="form.errors.meta_title"
            />
            <TextAreaInput
              label="Meta description"
              name="meta_description"
              type="text"
              v-model="form.meta_description"
              :error="form.errors.meta_description"
            />
            <InputLabel
              label="Open Graph type"
              name="og_type"
              type="text"
              v-model="form.og_type"
              :error="form.errors.og_type"
            />
          </Container>

          <!-- Settings -->
          <section v-show="tab === 2" class="flex flex-col gap-4">
            <h3 class="sr-only">Settings</h3>
            <Container>
              <ToggleInput
                label="Define as archive page"
                name="is_archive"
                v-model="form.is_archive"
                reverse
              />
              <SelectInput
                v-if="form.is_archive"
                label="Collection Type"
                name="collection_type_id"
                v-model="form.collection_type_id"
                :options="collectionTypesOptions"
                class="mt-4"
              />
            </Container>
          </section>
        </div>
        <!-- Status -->
        <Container tag="aside" class="flex flex-col gap-2 md:sticky md:top-7 self-start w-full">
          <h3 class="sr-only">Aside</h3>
          <SelectInput name="status" label="Status" :options="status" v-model="form.status" />
          <Action tag="button" @click="onSubmit" variant="primary">
            <IconPlus />
            Create
          </Action>
        </Container>
      </div>
    </div>
  </PanelLayout>
</template>

<style scoped></style>
