<script setup lang="ts">
import { useForm } from '@inertiajs/vue3'

import InputLabel from '@/Components/Admin/Form/InputLabel.vue'
import IconPlus from '@/Components/Admin/Icon/IconPlus.vue'
import Breadcrumbs from '@/Components/Admin/Ui/Breadcrumbs.vue'
import PanelLayout from '@/Layouts/PanelLayout.vue'

const form = useForm({
  name: '',
  email: '',
  password: '',
})
</script>

<template>
  <PanelLayout title="Create">
    <template #breadcrumbs>
      <Breadcrumbs :links="[{ label: 'Users', href: route('admin.user.index') }]" />
    </template>
    <form class="flex flex-col gap-4" @submit.prevent="form.post(route('admin.user.store'))">
      <InputLabel
        label="Name"
        name="name"
        type="text"
        placeholder="John Doe"
        v-model="form.name"
        :error="form.errors.name"
      />
      <InputLabel
        label="Email"
        name="email"
        type="text"
        placeholder="jon@example.com"
        v-model="form.email"
        :error="form.errors.email"
      />
      <InputLabel
        label="Password"
        name="password"
        type="password"
        v-model="form.password"
        :error="form.errors.password"
      />
      <Action tag="button" variant="primary">
        <IconPlus />
        Create User
      </Action>
    </form>
  </PanelLayout>
</template>

<style scoped></style>
