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

const isOpen = ref(false)

const form = useForm<Form>({
  name: '',
  type: '',
  fields: [],
})

watch(
  () => form.name,
  newTitle => {
    form.type = slugify(newTitle)
  }
)

const removeField = (index: number) => {
  form.fields.splice(index, 1)
}
</script>

<template>
  <PanelLayout title="Create collection type">
    <template #action>
      <Action
        tag="button"
        variant="primary"
        class="w-full"
        @click.prevent="form.post(route('admin.collection-type.store'))"
      >
        <IconPlus />
        Create Collection Type
      </Action>
    </template>
    <form class="flex flex-col gap-4">
      <section class="mb-8">
        <h2 class="text-xl font-medium mb-2">General</h2>
        <Container class="flex flex-col md:flex-row gap-2 md:gap-4">
          <InputLabel
            label="Name"
            name="name"
            type="text"
            v-model="form.name"
            :error="form.errors.name"
          />
          <InputLabel
            label="Type"
            name="type"
            type="text"
            v-model="form.type"
            :error="form.errors.type"
            hint="A unique identifier for the collection type"
          />
        </Container>
      </section>

      <!-- Fields -->
      <section class="mb-8">
        <div class="flex justify-between items-center">
          <h2 class="text-xl font-medium mb-2">Fields</h2>
          <Modal
            variant="primary"
            label="Add Field"
            title="Add Field"
            size="xl"
            v-model="isOpen"
            position="left"
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
