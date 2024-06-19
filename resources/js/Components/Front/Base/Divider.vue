<template>
    <div class="flex items-center">
        <div class="w-full h-px bg-neutral-200"></div>
        <p v-if="text" class="px-4 text-sm font-medium leading-none text-center text-neutral-900">
            {{ text }}
        </p>
        <div class="w-full h-px bg-neutral-200"></div>
    </div>
</template>

<script setup>
defineProps({
    text: String
})
</script>
