<script setup>
    defineProps({
        type: {
            type: String,
            default: 'button'
        }
    })
    const emit = defineEmits(['click'])
</script>

<template>
    <button
        @click="emit('click')"
        :type="type"
        class="inline-flex items-center px-4 py-2 font-medium bg-white border rounded-full group focus:outline-none border-neutral-200 hover:bg-neutral-100 text-neutral-900">
        <slot />
    </button>
</template>
