<script setup lang="ts">
import IconPlus from '@/Components/Admin/Icon/IconPlus.vue'
import IconTrash from '@/Components/Admin/Icon/IconTrash.vue'
import Table from '@/Components/Admin/Ui/Table.vue'
import PanelLayout from '@/Layouts/PanelLayout.vue'
import { Collection } from '@/Pages/Admin/Collection/Index.vue'
import { CollectionType } from '@/Pages/Admin/CollectionType/Index.vue'
import { PaginateCollection } from '@/types/pagination'
import { deleteItem } from '@/utils/utils'

const props = defineProps<{
  collection: PaginateCollection<Collection>
  collectionType: CollectionType
}>()

const tableCol = props.collectionType.fields.map(field => {
  return 'content.' + field.label
})
</script>

<template>
  <PanelLayout :title="collectionType.name">
    <template #action>
      <Action
        tag="Link"
        variant="primary"
        size="normal"
        :href="route('admin.collection.create', collectionType.type)"
      >
        <IconPlus />
        Create {{ collectionType.name }}
      </Action>
      <Action
        tag="button"
        :variant="['delete', 'icon']"
        @click="
          deleteItem(
            route('admin.collection-type.destroy', collectionType.type),
            'Are you sure you want to delete this collection type? This will delete every collection of this type too'
          )
        "
      >
        <IconTrash />
      </Action>
    </template>
    <div>
      <Table
        :columns="['Title', ...tableCol, 'Created at', 'Updated at']"
        :collection-name="collectionType.type"
        data-name="collection"
        :column-link="[collectionType.type, 'slug']"
        :collection="collection"
        route-name="admin.collection.show"
        has-search
      />
    </div>
  </PanelLayout>
</template>

<style scoped></style>
