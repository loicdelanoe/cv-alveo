<script setup lang="ts">
import IconPlus from '@/Components/Admin/Icon/IconPlus.vue'
import IconSettings from '@/Components/Admin/Icon/IconSettings.vue'
import Can from '@/Components/Admin/Permission/Can.vue'
import Table from '@/Components/Admin/Ui/Table.vue'
import PanelLayout from '@/Layouts/PanelLayout.vue'
import { Page } from '@/types/models/page'
import { PaginateCollection } from '@/types/pagination'

defineProps<{
  pages: PaginateCollection<Page>
}>()
</script>

<template>
  <PanelLayout title="Pages">
    <template #action>
      <Can permission="create pages">
        <Action tag="Link" variant="primary" size="normal" :href="route('admin.page.create')">
          <IconPlus />
          Create Page
        </Action>
      </Can>
      <Can permission="edit pages">
        <Action
          tag="Link"
          :variant="['outline', 'icon']"
          size="normal"
          :href="route('admin.page.settings')"
        >
          <IconSettings />
        </Action>
      </Can>
    </template>
    <div class="flex flex-col gap-3">
      <Table
        collection-name="page"
        data-name="pages"
        :collection="pages"
        :columns="['Status', 'Title', 'Slug', 'Created at', 'Updated at']"
        column-link="slug"
        route-name="admin.page.show"
        hasSearch
      />
    </div>
  </PanelLayout>
</template>

<style scoped></style>
