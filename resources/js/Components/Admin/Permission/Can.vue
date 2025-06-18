<script setup lang="ts">
import { usePage } from '@inertiajs/vue3'
import { ExtendedPageProps } from '../Form/AsideField.vue';

defineProps<{
  permission: string
}>()

const permissions = usePage<ExtendedPageProps>().props.auth.permissions
</script>

<template>
  <template v-if="permissions.includes(permission)">
    <slot />
  </template>
</template>

<style scoped></style>
