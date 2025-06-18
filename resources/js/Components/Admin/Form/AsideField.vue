<script setup lang="ts">
import { InertiaForm, usePage } from '@inertiajs/vue3'
import { watch } from 'vue'

import InputLabel from '@/Components/Admin/Form/InputLabel.vue'
import SelectInput from '@/Components/Admin/Form/SelectInput.vue'
import ToggleInput from '@/Components/Admin/Form/ToggleInput.vue'
import IconChevronDown from '@/Components/Admin/Icon/IconChevronDown.vue'
import { Form, useFieldStore } from '@/stores/field'

import { slugify } from '../utils/text'

import type { PageProps, User } from '@/types'

const { form } = defineProps<{
  form: InertiaForm<any>
}>()

export interface ExtendedPageProps extends PageProps {
  flash: {
    success?: string
    error?: string
    info?: string
  }
  fields: string[]
  auth: {
    user: User
    permissions: string[]
    roles: string[]
  }
  collectionTypes: { id: number; name: string }[]
}

const fieldStore = useFieldStore()
const page = usePage<ExtendedPageProps>()
const emit = defineEmits(['closeModal'])

const fieldTypes: string[] = page.props.fields

const submitField = (form: InertiaForm<Form>) => {
  const isValid = fieldStore.pushField(form)

  if (!isValid) {
    emit('closeModal')
  }
}

watch(
  () => fieldStore.field.label,
  newTitle => {
    fieldStore.field.name = slugify(newTitle)
  }
)
</script>

<template>
  <aside class="flex flex-col gap-6">
    <div class="flex flex-col gap-2">
      <SelectInput
        name="type"
        label="Type"
        :options="fieldTypes"
        v-model="fieldStore.field.type"
        :error="fieldStore.errors.type"
      />
      <InputLabel
        type="text"
        label="Label"
        name="label"
        v-model="fieldStore.field.label"
        :error="fieldStore.errors.label"
        hint="The name appearing on the admin panel"
      />
      <InputLabel
        type="text"
        label="Name"
        name="name"
        v-model="fieldStore.field.name"
        :error="fieldStore.errors.name"
        hint="A unique identifier for the field"
      />
    </div>

    <!-- Repeater fields -->
    <div
      class="flex flex-col gap-3 bg-secondary-50 p-4 rounded-md"
      v-if="fieldStore.field.type === 'repeater' && fieldStore.field.repeaterFields"
    >
      <div class="flex justify-between">
        <span class="text-xl font-medium inline-flex">Repeater fields</span>
        <IconChevronDown />
      </div>
      <div
        v-for="(field, index) in fieldStore.field.repeaterFields"
        class="flex gap-2"
        :key="index"
      >
        <SelectInput
          name="type"
          label="Type"
          :options="fieldTypes"
          v-model="field.type"
          :error="fieldStore.errors.type"
          class="min-w-1/4"
        />
        <InputLabel
          type="text"
          label="Label"
          name="label"
          v-model="field.label"
          :error="fieldStore.errors.label"
        />
        <InputLabel
          type="text"
          label="Name"
          name="name"
          v-model="field.name"
          :error="fieldStore.errors.name"
        />
      </div>
      <Action
        tag="button"
        variant="primary"
        @click="
          fieldStore.field.repeaterFields.push({
            type: 'text',
            label: '',
            name: '',
            validation: [],
          })
        "
      >
        Add Repeater Field
      </Action>
    </div>

    <!-- Collection field -->
    <!-- <SelectInput name="collection" label=""/> -->

    <div class="flex flex-col gap-2">
      <p class="text-xl font-medium">Validation</p>
      <ToggleInput
        label="Required"
        name="required"
        v-model="fieldStore.field.validation"
        value="required"
      />
    </div>
    <Action tag="button" variant="primary" @click.prevent="submitField(form)">Add Field</Action>
  </aside>
</template>

<style scoped></style>
