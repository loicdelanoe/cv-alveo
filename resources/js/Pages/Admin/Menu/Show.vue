<script setup lang="ts">
import { useForm } from '@inertiajs/vue3'
import { computed } from '@vue/reactivity'
import { ref } from 'vue'

import CheckboxInput from '@/Components/Admin/Form/CheckboxInput.vue'
import InputLabel from '@/Components/Admin/Form/InputLabel.vue'
import MenuAction from '@/Components/Admin/Form/MenuAction.vue'
import ToggleInput from '@/Components/Admin/Form/ToggleInput.vue'
import IconClose from '@/Components/Admin/Icon/IconClose.vue'
import IconPlus from '@/Components/Admin/Icon/IconPlus.vue'
import IconTrash from '@/Components/Admin/Icon/IconTrash.vue'
import Modal from '@/Components/Admin/Modal/Modal.vue'
import Breadcrumbs from '@/Components/Admin/Ui/Breadcrumbs.vue'
import Container from '@/Components/Admin/Ui/Container.vue'
import Draggable from '@/Components/Admin/Ui/Draggable.vue'
import PanelLayout from '@/Layouts/PanelLayout.vue'
import ActionCreate from '@/Pages/Admin/Action/Create.vue'
import { deleteItem } from '@/utils/utils'

import type { Menu } from '@/types/models/menu'
import type { Page } from '@/types/models/page'

const props = defineProps<{
  menu: Menu
  pages: Page[]
}>()

const selectedPages = ref<number[]>([])
const isOpen = ref(false)
const actionModal = ref(false)
const draggedIndex = ref<number | null>(null)

const filteredPages = computed(() => {
  return props.pages.filter(page => {
    return !props.menu.pages.some(menuPage => page.id === menuPage.id)
  })
})

const formattedFormPages = computed(() => {
  return form.pages.map(id => props.pages.find(p => p.id === id)).filter((p): p is Page => !!p) // Remove undefined (in case of mismatch)
})

const form = useForm({
  name: props.menu.name,
  slug: props.menu.slug,
  active: props.menu.active,
  pages: props.menu.pages.map(page => page.id),
})

const removeFromMenu = (index: number) => {
  form.pages.splice(index, 1)
}

const onSubmit = () => {
  form.patch(route('admin.menu.update', props.menu.slug), {
    preserveScroll: true,
    // preserveState: false,
  })
}

const addPages = () => {
  form.pages.push(...selectedPages.value)

  selectedPages.value = []
  isOpen.value = false
}
</script>

<template>
  <PanelLayout :title="menu.name">
    <template #breadcrumbs>
      <Breadcrumbs
        :links="[
          { label: 'Menus', href: route('admin.menu.index') },
          { label: props.menu.name, href: route('admin.menu.show', props.menu.id) },
        ]"
      />
    </template>

    <template #action>
      <Can permission="edit menus">
        <span v-if="form.isDirty" class="font-medium text-orange-600 italic">
          Form has unsaved changes
        </span>
        <ToggleInput
          label="Active"
          name="active"
          type="checkbox"
          v-model="form.active"
          :error="form.errors.active"
          reverse
        />
        <Action tag="button" variant="primary" @click="onSubmit">Save</Action>
      </Can>
      <Can permission="delete menus">
        <Action
          tag="button"
          :variant="['delete', 'icon']"
          @click="
            deleteItem(
              route('admin.menu.destroy', props.menu.slug),
              'Are you sure you want to delete this menu?',
              form
            )
          "
        >
          <IconTrash />
        </Action>
      </Can>
    </template>

    <div class="flex flex-col gap-6">
      <Container class="flex flex-col md:flex-row gap-4 md:gap-6">
        <InputLabel
          label="Name"
          name="name"
          type="text"
          v-model="form.name"
          :error="form.errors.name"
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

      <!-- Pages -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <section class="flex flex-col gap-4">
          <div class="flex justify-between items-center">
            <h2 class="text-xl font-medium">Pages</h2>
            <Can permission="edit menus">
              <Modal
                label="Add Pages"
                title="Choose pages"
                variant="outline"
                size="lg"
                position="left"
                v-model="isOpen"
                icon="plus"
                button-size="small"
              >
                <ul v-if="pages">
                  <li v-for="page in filteredPages" :key="`page-${page.id}`">
                    <CheckboxInput
                      :label="page.title"
                      :name="`page-${page.id}`"
                      :value="page.id"
                      v-model="selectedPages"
                      class="page-checkbox w-full pl-3 cursor-pointer"
                    />
                  </li>
                </ul>

                <template #footer>
                  <Action tag="button" variant="primary" @click="addPages">
                    <IconPlus />
                    Add {{ selectedPages.length }} page(s)
                  </Action>
                </template>
              </Modal>
            </Can>
          </div>

          <!-- Drag n Drop -->
          <ul class="flex flex-col gap-2">
            <li v-for="(page, index) in formattedFormPages" :key="page.id">
              <Draggable
                :index="index"
                :pos-x="20"
                :pos-y="25"
                v-model="form.pages"
                v-model:dragged="draggedIndex"
              >
                {{ page.title }}
                <Action tag="button" variant="icon" class="ml-auto" @click="removeFromMenu(index)">
                  <IconClose />
                </Action>
              </Draggable>
            </li>
          </ul>
        </section>
        <section class="flex flex-col gap-4">
          <div class="flex gap-2 justify-between items-center">
            <h3 class="text-xl font-medium">Actions</h3>
            <Modal
              label="Add Action"
              title="Add Action"
              variant="primary"
              size="xl"
              position="left"
              icon="plus"
              v-model="actionModal"
            >
              <ActionCreate
                :menu-form="form"
                :menu-id="menu.id"
                @close-modal="actionModal = false"
              />
            </Modal>
          </div>
          <ul class="flex flex-col gap-2">
            <li v-for="(action, index) in menu.actions" :key="action.id">
              <MenuAction :action="action" :index="index" />
            </li>
          </ul>
        </section>
      </div>
    </div>
  </PanelLayout>
</template>

<style scoped></style>
