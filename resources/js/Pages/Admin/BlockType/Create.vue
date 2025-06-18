<script setup lang="ts">
import { useForm } from '@inertiajs/vue3'
import { ref, watch } from 'vue'

import AsideField from '@/Components/Admin/Form/AsideField.vue'
import InputLabel from '@/Components/Admin/Form/InputLabel.vue'
import IconPlus from '@/Components/Admin/Icon/IconPlus.vue'
import IconTrash from '@/Components/Admin/Icon/IconTrash.vue'
import Modal from '@/Components/Admin/Modal/Modal.vue'
import Container from '@/Components/Admin/Ui/Container.vue'
import { slugify } from '@/Components/Admin/utils/text'
import PanelLayout from '@/Layouts/PanelLayout.vue'
import { Form } from '@/stores/field'

defineProps<{
  collectionTypes: string[]
}>()

const form = useForm<Form>({
  name: '',
  type: '',
  component: '',
  fields: [],
})

const removeField = (index: number) => {
  form.fields.splice(index, 1)
}

watch(
  () => form.name,
  newTitle => {
    form.type = slugify(newTitle)
  }
)

const isOpen = ref(false)
</script>

<template>
  <PanelLayout title="Create block type">
    <template #action>
      <Action
        tag="button"
        variant="primary"
        @click.prevent="form.post(route('admin.block-type.store'))"
      >
        <IconPlus />
        Create Block Type
      </Action>
    </template>

    <form>
      <section class="mb-8">
        <h3 class="text-xl font-medium mb-2">General</h3>
        <Container class="flex flex-col md:flex-row gap-2 md:gap-4">
          <InputLabel
            type="text"
            label="Name"
            name="name"
            :error="form.errors.name"
            v-model="form.name"
          />
          <InputLabel
            type="text"
            label="Type"
            name="type"
            :error="form.errors.type"
            v-model="form.type"
            hint="A unique identifier for the block type"
          />
        </Container>
        <!-- <InputLabel
              type="text"
              label="Component"
              name="component"
              :error="form.errors.component"
              v-model="form.component"
              hint="Name of the Vue component to be used for this block type"
            /> -->
      </section>

      <!-- Fields -->
      <section class="mb-8">
        <div class="flex justify-between items-center">
          <h3 class="text-xl font-medium mb-2">Fields</h3>
          <Modal
            variant="primary"
            label="Add Field"
            title="Add Field"
            position="left"
            size="xl"
            v-model="isOpen"
            icon="plus"
          >
            <AsideField :form="form" @close-modal="isOpen = false" />
          </Modal>
        </div>
        <span v-if="form.errors.fields" class="text-red-500 font-medium">
          {{ form.errors.fields }}
        </span>
        <ul class="flex flex-col gap-4">
          <li
            v-for="(field, index) in form.fields"
            :key="index"
            class="flex gap-2 items-center border border-secondary-200 rounded-lg bg-white p-4 font-mono"
          >
            [{{ field.type }}] {{ field.label }} ({{ field.name }})
            <Action
              class="ml-auto"
              tag="button"
              :variant="['delete', 'icon']"
              @click.prevent="removeField(index)"
            >
              <IconTrash />
            </Action>
          </li>
        </ul>
      </section>
    </form>
  </PanelLayout>
</template>

<style scoped></style>
