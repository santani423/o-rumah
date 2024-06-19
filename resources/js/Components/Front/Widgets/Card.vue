<script setup>
const props = defineProps({
    cardTitle: String,
})
</script>

<template>
    <div class="border-[1px] border-[#D1D5DB] rounded-md">
        <div class="border-b-[1px] border-[#D1D5DB] p-3 font-semibold text-base">
            <p>{{ cardTitle }}</p>
        </div>
        <div class="p-3">
            <slot />
        </div>
    </div>
</template>
