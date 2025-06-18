<script setup lang="ts">
import IconPlus from '@/Components/Admin/Icon/IconPlus.vue'
import IconTrash from '@/Components/Admin/Icon/IconTrash.vue'
import Container from '@/Components/Admin/Ui/Container.vue'
import Table from '@/Components/Admin/Ui/Table.vue'
import PanelLayout from '@/Layouts/PanelLayout.vue'
import { Block } from '@/types/models/block'
import { PaginateCollection } from '@/types/pagination'
import { deleteItem } from '@/utils/utils'

import type { BlockType } from '@/Pages/Admin/Block/Create.vue'

const props = defineProps<{
  blockType: BlockType
  blocks: PaginateCollection<Block>
}>()

const tableCol = props.blockType.fields.map(field => {
  return 'content.' + field.label
})
</script>

<template>
  <PanelLayout :title="blockType.name">
    <template #action>
      <Can permission="create blocks">
        <Action
          tag="Link"
          variant="primary"
          size="normal"
          :href="route('admin.block.create', blockType.type)"
        >
          <IconPlus />
          Create {{ blockType.name }} block
        </Action>
      </Can>
      <Can permission="delete blocks">
        <Action
          tag="button"
          :variant="['delete', 'icon']"
          @click="
            deleteItem(
              route('admin.block-type.destroy', blockType.type),
              'Are you sure you want to delete this block? This will delete every block of this type too'
            )
          "
        >
          <IconTrash />
        </Action>
      </Can>
    </template>
    <section class="mb-6">
      <h3 class="mb-2 text-xl font-medium">Structure</h3>
      <dl class="flex flex-col gap-6">
        <div class="flex gap-12">
          <div class="flex flex-col">
            <dt class="font-medium text-lg">Name</dt>
            <dd>{{ blockType.name }}</dd>
          </div>
          <div class="flex flex-col">
            <dt class="font-medium text-lg">Type</dt>
            <dd>{{ blockType.type }}</dd>
          </div>
        </div>
        <div class="flex flex-col gap-2">
          <dt class="font-medium text-lg">Fields</dt>
          <ul class="flex flex-col gap-2">
            <Container
              tag="li"
              v-for="(field, index) in blockType.fields"
              :key="index"
              class="flex gap-2 items-center font-mono"
            >
              {{ field.name }}
            </Container>
          </ul>
        </div>
      </dl>
    </section>
    <section>
      <h3 class="mb-2 font-medium text-xl">Blocks</h3>
      <Table
        :columns="[...tableCol, 'Created at', 'Updated at']"
        collection-name="block"
        data-name="blocks"
        :collection="blocks"
        column-link="id"
        route-name="admin.block.show"
      />
    </section>
  </PanelLayout>
</template>

<style scoped></style>
