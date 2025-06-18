import { InertiaForm } from '@inertiajs/vue3'
import { defineStore } from 'pinia'
import { ref, watch } from 'vue'

import { fields } from '@/config/fields'

export interface Form {
  name: string
  type: string
  fields: Field[]
  [key: string]: any
}

export interface Field {
  name: string
  type: string
  label: string
  validation: string[]
  repeaterFields?: Field[]
  [key: string]: any
}

interface Errors {
  name: string
  type: string
  label: string
  [key: string]: string
}

export const useFieldStore = defineStore('field', () => {
  const field = ref<Field>({
    name: '',
    type: '',
    label: '',
    validation: [],
  })

  const errors = ref<Errors>({
    name: '',
    type: '',
    label: '',
  })

  // TODO: Improve with more validation rules
  // Add types validation, if not in the array, return false
  const isValid = (key: string) => {
    const value = field.value[key]

    return value.length > 0
  }

  const addBasicValidation = (fieldType: string) => {
    field.value.validation = []

    // TODO: fix error, when choosing a field type
    field.value.validation.push(...fields.validation[fieldType])
  }

  const pushField = (form: InertiaForm<Form>) => {
    let hasErrors = false
    // Add validation
    Object.entries(field.value).forEach(([key, value]) => {
      if (!isValid(key)) {
        errors.value[key] = 'This field is required'
        hasErrors = true
      }
    })

    if (hasErrors) {
      return true
    }

    // After validate the field, push it to the form
    form.fields.push(field.value)

    // Reset the field
    resetField()
  }

  const resetField = () => {
    field.value = {
      name: '',
      type: '',
      label: '',
      validation: [],
    }

    errors.value = {
      name: '',
      type: '',
      label: '',
    }
  }

  const addRepeaterField = (field: Field) => {
    if (!field.repeaterFields) {
      field.repeaterFields = []
    }

    field.repeaterFields.push({
      name: '',
      type: '',
      label: '',
      validation: [],
    })
  }

  watch(
    () => field.value.type,
    newType => {
      if (!newType) {
        return
      }

      if (newType !== 'repeater' && field.value.repeaterFields) {
        field.value.repeaterFields = []
      }

      if (newType === 'repeater') {
        addRepeaterField(field.value)
      }

      addBasicValidation(newType)
    }
  )

  return { field, errors, pushField, resetField }
})
