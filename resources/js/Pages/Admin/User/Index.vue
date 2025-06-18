<script setup lang="ts">
import IconPlus from '@/Components/Admin/Icon/IconPlus.vue'
import Table from '@/Components/Admin/Ui/Table.vue'
import PanelLayout from '@/Layouts/PanelLayout.vue'
import { User } from '@/types'
import { PaginateCollection } from '@/types/pagination'

defineProps<{
  users: PaginateCollection<User>
}>()
</script>

<template>
  <PanelLayout title="Users">
    <template #action>
      <Can permission="create users">
        <Action tag="Link" variant="primary" :href="route('admin.user.create')">
          <IconPlus />
          Create User
        </Action>
      </Can>
    </template>

    <Table
      :columns="['Name', 'Email', 'Created at', 'Updated at']"
      collection-name="user"
      data-name="users"
      :collection="users"
      column-link="id"
      route-name="admin.user.show"
      has-search
    />
  </PanelLayout>
</template>

<style scoped></style>
