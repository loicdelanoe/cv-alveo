<script setup lang="ts">
import { InertiaForm } from '@inertiajs/vue3'

import { Field } from '@/stores/field'
import { getInputCpt } from '@/utils/mapping'

defineProps<{
  field: Field
  form: InertiaForm<any>
}>()
</script>

<template>
  <component
    :is="getInputCpt(field.type)"
    :type="field.type"
    :name="field.name"
    :label="field.label"
    v-model="form.content[field.name]"
    :error="form.errors[`content.${field.name}`]"
    :repeater-fields="field.repeaterFields"
  />
</template>

<style scoped></style>
