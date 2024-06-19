<script setup>
import { ref } from 'vue'
const props = defineProps({
    'id': String,
    'title': String,
    'placeholder': String,
    'type': String,
    'modelValue': String
})

defineEmits(['update:modelValue'])

const input = ref(null)

defineExpose({ focus: () => input.value.focus() })
</script>

<template>
    <div class="block">
        <p class="mb-3 text-sm font-medium">{{ title }}</p>
        <input :id=id :type=type :placeholder=placeholder
            class="border-neutral-300 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-300 focus:border-neutral-500 dark:focus:border-neutral-600 focus:ring-neutral-500 dark:focus:ring-neutral-600 rounded-md shadow-sm w-full placeholder:text-sm text-sm"
            autocomplete :value="modelValue" @input="$emit('update:modelValue', $event.target.value)">
    </div>
</template>
