<script setup lang="ts">
import { useForm } from '@inertiajs/vue3'

import FieldBuilder from '@/Components/Admin/Form/FieldBuilder.vue'
import IconCheck from '@/Components/Admin/Icon/IconCheck.vue'
import IconSquareArrowRight from '@/Components/Admin/Icon/IconSquareArrowRight.vue'
import IconTrash from '@/Components/Admin/Icon/IconTrash.vue'
import Container from '@/Components/Admin/Ui/Container.vue'
import VisitLink from '@/Components/Admin/Ui/VisitLink.vue'
import PanelLayout from '@/Layouts/PanelLayout.vue'
import { Block } from '@/types/models/block'
import { deleteItem } from '@/utils/utils'

const props = defineProps<{
  block: Block
}>()

const form = useForm({
  content: props.block.content,
})
</script>

<template>
  <PanelLayout :title="block.block_type.name">
    <template #action>
      <Can permission="edit blocks">
        <p v-if="form.isDirty" class="font-medium text-orange-600 italic">
          Form has unsaved changes
        </p>
        <Action
          tag="button"
          variant="primary"
          @click.prevent="form.patch(route('admin.block.update', props.block.id))"
        >
          <IconCheck />
          Save
        </Action>
      </Can>
      <Can permission="delete blocks">
        <Action
          tag="button"
          :variant="['delete', 'icon']"
          @click.prevent="
            deleteItem(
              route('admin.block.destroy', props.block.id),
              'Are you sure you want to delete this block?',
              form
            )
          "
        >
          <IconTrash />
        </Action>
      </Can>
    </template>

    <!-- Informations -->
    <section class="mb-12">
      <h3 class="text-2xl mb-2">Informations</h3>
      <p>This block is present in {{ block.pages.length }} page(s) :</p>
      <ul class="flex flex-col gap-2">
        <li
          v-for="page in block.pages"
          :key="page.slug"
          class="flex items-center justify-between border-b border-secondary-200 py-2"
        >
          <span class="font-medium">{{ page.title }}</span>
          <div class="flex gap-4">
            <VisitLink :href="route('page.show', page.slug)" :is-home="page.is_home" />
            <Can permission="edit pages">
              <Action
                tag="Link"
                variant="outline"
                size="small"
                :href="route('admin.page.show', page.slug)"
              >
                Edit Page
              </Action>
            </Can>
          </div>
        </li>
      </ul>
    </section>

    <!-- Form -->
    <section class="flex flex-col gap-4">
      <h3 class="text-2xl">Edit block</h3>
      <Container tag="form" class="flex flex-col gap-4">
        <div
          v-for="field in block.block_type.fields"
          class="flex flex-col gap-2"
          :key="JSON.stringify(field)"
        >
          <FieldBuilder :field="field" :form="form" />
        </div>
        <Can permission="edit blocks">
          <Action
            tag="button"
            variant="primary"
            @click.prevent="form.patch(route('admin.block.update', props.block.id))"
          >
            <IconCheck />
            Save
          </Action>
        </Can>
      </Container>
    </section>
  </PanelLayout>
</template>

<style scoped></style>
