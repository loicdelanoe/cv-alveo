<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3'

import CheckboxInput from '@/Components/Admin/Form/CheckboxInput.vue'
import InputLabel from '@/Components/Admin/Form/InputLabel.vue'
import IconArrowLeft from '@/Components/Admin/Icon/IconArrowLeft.vue'
import GuestLayout from '@/Layouts/GuestLayout.vue'

defineProps<{
  canResetPassword?: boolean
  status?: string
}>()

const form = useForm({
  email: '',
  password: '',
  remember: false,
})

const submit = () => {
  form.post(route('login'), {
    onFinish: () => {
      form.reset('password')
    },
  })
}
</script>

<template>
  <GuestLayout title="Log in">
    <Head title="Log in" />

    <template #header>
      <Link href="/" class="inline-flex text-sm">
        <IconArrowLeft stroke-width="1" />
        Back to website
      </Link>
    </template>

    <form class="flex flex-col gap-4 w-full" @submit.prevent="submit">
      <InputLabel
        label="Email"
        name="email"
        v-model="form.email"
        type="email"
        :error="form.errors.email"
      />

      <InputLabel
        label="Password"
        name="password"
        type="password"
        v-model="form.password"
        :error="form.errors.password"
      />

      <CheckboxInput
        label="Remember me"
        name="remember"
        v-model="form.remember"
        small-label
        class="mb-12"
      />

      <div class="flex flex-col gap-2">
        <Link
          v-if="canResetPassword"
          :href="route('password.request')"
          class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
        >
          Forgot your password?
        </Link>

        <Action
          tag="button"
          variant="primary"
          :class="{ 'opacity-25': form.processing }"
          :disabled="form.processing"
        >
          Log in
        </Action>
      </div>
    </form>
  </GuestLayout>
</template>
