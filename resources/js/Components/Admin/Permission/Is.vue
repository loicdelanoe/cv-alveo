<script setup lang="ts">
import { usePage } from '@inertiajs/vue3'
import { ExtendedPageProps } from '../Form/AsideField.vue';

defineProps<{
  role: string
}>()

const permissions = usePage<ExtendedPageProps>().props.auth.roles
</script>

<template>
  <template v-if="permissions.includes(role)">
    <slot />
  </template>
</template>

<style scoped></style>
