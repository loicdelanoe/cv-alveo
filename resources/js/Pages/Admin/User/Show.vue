<script setup lang="ts">
import { useForm } from '@inertiajs/vue3'
import { capitalize } from 'vue'

import CheckboxInput from '@/Components/Admin/Form/CheckboxInput.vue'
import InputLabel from '@/Components/Admin/Form/InputLabel.vue'
import IconCheck from '@/Components/Admin/Icon/IconCheck.vue'
import IconTrash from '@/Components/Admin/Icon/IconTrash.vue'
import Is from '@/Components/Admin/Permission/Is.vue'
import Breadcrumbs from '@/Components/Admin/Ui/Breadcrumbs.vue'
import PanelLayout from '@/Layouts/PanelLayout.vue'
import { deleteItem } from '@/utils/utils'

const props = defineProps<{
  user: any
  permissions: any[]
  userPermissions: string[]
}>()

const form = useForm({
  name: props.user.name,
  email: props.user.email,
  permissions: props.userPermissions || [],
})

const actions = ['create', 'edit', 'show', 'delete']
const models = ['pages', 'blocks', 'collections', 'menus', 'users', 'medias']
</script>

<template>
  <PanelLayout :title="user.name">
    <template #breadcrumbs>
      <Breadcrumbs
        :links="[
          { label: 'Users', href: route('admin.user.index') },
          { label: user.name, href: route('admin.user.show', user.id) },
        ]"
      />
    </template>

    <template #action>
      <Can permission="edit users">
        <span v-if="form.isDirty" class="font-medium text-orange-600 italic">
          Form has unsaved changes
        </span>
        <Action
          tag="button"
          variant="primary"
          @click="
            form.patch(route('admin.user.update', user.id), {
              preserveScroll: true,
              preserveState: false,
            })
          "
        >
          <IconCheck />
          Save
        </Action>
      </Can>
      <Can permission="delete users">
        <Action
          tag="button"
          :variant="['delete', 'icon']"
          @click="
            deleteItem(
              route('admin.user.destroy', user.id),
              'Are you sure you want to delete this user?'
            )
          "
        >
          <IconTrash />
        </Action>
      </Can>
    </template>

    <!-- Informations -->
    <section class="flex flex-col gap-4">
      <h2 class="text-2xl font-medium">Informations</h2>
      <InputLabel label="Name" name="name" v-model="form.name" :error="form.errors.name" />
      <InputLabel
        label="Email"
        name="email"
        v-model="form.email"
        disabled
        hint="You can't modify email address"
        :error="form.errors.email"
      />
    </section>

    <!-- Permissions -->
    <Is role="super-admin">
      <section class="flex flex-col gap-4 mt-8">
        <h2 class="text-2xl font-medium">Permissions</h2>
        <div class="overflow-hidden rounded-lg">
          <table class="w-full border-separate border-spacing-0">
            <thead class="bg-secondary-950 text-white">
              <tr>
                <th class="px-4 py-2.5" scope="col">Model</th>
                <th v-for="model in models" :key="model" class="px-4 py-2.5" scope="col">
                  {{ capitalize(model) }}
                </th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="action in actions"
                :key="action"
                class="relative border-b border-secondary-200 transition odd:bg-secondary-50"
              >
                <td class="px-4 py-2.5 font-medium">{{ capitalize(action) }}</td>
                <td v-for="model in models" class="px-4 py-2.5 font-medium">
                  <div class="flex items-center justify-center">
                    <CheckboxInput
                      :label="action"
                      name="permissions"
                      hidden-label
                      :value="`${action} ${model}`"
                      v-model="form.permissions"
                    />
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </section>
    </Is>
  </PanelLayout>
</template>

<style scoped></style>
