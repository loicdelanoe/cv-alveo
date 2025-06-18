<script setup lang="ts">
import { usePage } from '@inertiajs/vue3'
import { computed, ref } from 'vue'

import Action from '@/Components/Admin/Action.vue'
import IconEdit from '@/Components/Admin/Icon/IconEdit.vue'
import IconPlus from '@/Components/Admin/Icon/IconPlus.vue'
import Modal from '@/Components/Admin/Modal/Modal.vue'
import Can from '@/Components/Admin/Permission/Can.vue'
import Container from '@/Components/Admin/Ui/Container.vue'
import StatContainer from '@/Components/Admin/Ui/StatContainer.vue'
import PanelLayout from '@/Layouts/PanelLayout.vue'
import MediaCreate from '@/Pages/Admin/Media/Create.vue'
import { Menu } from '@/types/models/menu'

import type { BlockType } from '@/Pages/Admin/Block/Create.vue'
import type { CollectionType } from '@/Pages/Admin/CollectionType/Index.vue'
import type { Page } from '@/types/models/page'

defineProps<{
  page: Page[]
  collectionTypes: CollectionType[]
  blockTypes: BlockType[]
  menus: Menu[]
}>()

const isOpen = ref(false)

const props = usePage().props

const user = computed(() => props.auth.user)
</script>

<template>
  <PanelLayout title="Dashboard">
    <span class="text-2xl font-medium">Welcome {{ user.name }} !</span>
    <section class="py-6 flex flex-col gap-4">
      <h3 class="text-xl font-medium">Statistics</h3>
      <dl class="flex flex-col md:flex-row justify-between gap-4">
        <StatContainer title="Pages" :collection="page" :href="route('admin.page.index')">
          <template #action>
            <Action tag="Link" :variant="['outline', 'icon']" :href="route('admin.page.create')">
              <IconPlus />
              <span class="sr-only">Create new page</span>
            </Action>
          </template>
        </StatContainer>
        <StatContainer
          title="Collection Types"
          :collection="collectionTypes"
          :href="route('admin.page.index')"
          hide-all
        >
          <template #action>
            <Action
              tag="Link"
              :variant="['outline', 'icon']"
              :href="route('admin.collection-type.create')"
            >
              <IconPlus />
              <span class="sr-only">Create new collection type</span>
            </Action>
          </template>
        </StatContainer>
        <StatContainer
          title="Block Types"
          :collection="blockTypes"
          :href="route('admin.page.index')"
          hide-all
        >
          <template #action>
            <Action
              tag="Link"
              :variant="['outline', 'icon']"
              :href="route('admin.block-type.create')"
            >
              <IconPlus />
              <span class="sr-only">Create new block type</span>
            </Action>
          </template>
        </StatContainer>
      </dl>
    </section>
    <div class="flex flex-col md:flex-row gap-4">
      <section class="w-full flex flex-col gap-4">
        <h3 class="text-xl font-medium">Upload Medias</h3>
        <Container>
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
        </Container>
      </section>
      <section class="w-full flex flex-col gap-4">
        <h3 class="text-xl font-medium">Last menus created</h3>
        <Container class="flex flex-col gap-4">
          <ul>
            <li
              v-for="menu in menus"
              :key="menu.id"
              class="flex items-center justify-between p-3 border border-secondary-300 rounded-lg relative hover:bg-secondary-50 transition hover:underline"
            >
              <span class="font-medium">{{ menu.name }}</span>
              <span>{{ menu.pages.length }} page(s)</span>
              <Link class="absolute inset-0" :href="route('admin.menu.show', menu.slug)">
                <span class="sr-only">Edit {{ menu.name }}</span>
              </Link>
            </li>
          </ul>
          <Action tag="Link" variant="primary" :href="route('admin.menu.index')">Show All</Action>
        </Container>
      </section>
    </div>
    <!-- <section>
      <h2 class="text-2xl font-medium">Quick actions</h2>
      <ul>
        <li>Create Page</li>
        <li>Create Menu</li>
        <li>…</li>
      </ul>
    </section>
    <section class="flex flex-col gap-4">
      <h2 class="text-2xl font-medium">Last pages</h2>
      <ul>
        <li>Page 1</li>
        <li>Page 2</li>
        <li>Page 3</li>
      </ul>
      <Action tag="button" variant="primary">Create page</Action>
    </section> -->
  </PanelLayout>
</template>

<style scoped></style>
