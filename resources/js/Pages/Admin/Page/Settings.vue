<script setup lang="ts">
import { useForm } from '@inertiajs/vue3'

import SelectInput from '@/Components/Admin/Form/SelectInput.vue'
import IconCheck from '@/Components/Admin/Icon/IconCheck.vue'
import Breadcrumbs from '@/Components/Admin/Ui/Breadcrumbs.vue'
import PanelLayout from '@/Layouts/PanelLayout.vue'
import { Page } from '@/types/models/page'

const props = defineProps<{
  pages: Page[]
}>()

const formatPageOptions = props.pages.map(page => page.slug)

const form = useForm({
  slug: props.pages.find(page => page.is_home)?.slug || '',
})

const breadcrumbs = [
  {
    label: 'Pages',
    href: route('admin.page.index'),
  },
]

const onSubmit = () => {
  form.submit('patch', route('admin.page.update-settings'), {
    preserveScroll: true,
    preserveState: false,
  })
}
</script>

<template>
  <PanelLayout title="Settings">
    <template #breadcrumbs>
      <Breadcrumbs :links="breadcrumbs" />
    </template>

    <template #action>
      <Action tag="button" variant="primary" :disabled="form.processing" @click="onSubmit">
        <IconCheck />
        Save
      </Action>
    </template>
    <div>
      <form @submit.prevent="onSubmit" class="flex flex-col gap-2 items-start">
        <SelectInput
          name="slug"
          label="Homepage"
          :options="formatPageOptions"
          v-model="form.slug"
          class="w-full"
        />
      </form>
    </div>
  </PanelLayout>
</template>

<style scoped></style>
