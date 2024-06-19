<script setup>
import { ref } from 'vue'
defineProps({
    label: String,
    type: String,
    name: String,
    placeholder: String,
    modelValue: String
});

defineEmits(['update:modelValue'])

const input = ref(null)
</script>

<template>
    <div>
        <label v-if="label" :for="name" class="block mb-1 text-xs leading-6 text-neutral-500">{{ label }}</label>
        <div class="relative rounded-md">
            <input :type="type" :name="name" :id="name" :placeholder="placeholder"
                class="block w-full py-2.5 border-0 rounded-md text-neutral-900 placeholder:text-neutral-400 ring-1 ring-inset ring-neutral-200 focus:ring-1 focus:ring-inset focus:ring-neutral-200 sm:text-sm sm:leading-6"
                :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" />
            <slot name="icon" />
        </div>
    </div>
</template>
