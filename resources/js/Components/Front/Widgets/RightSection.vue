<script setup>

defineProps({
    items: Array
})

</script>

<template>
    <div class="sticky flex flex-col space-y-6 top-20">
        <img v-for="list in items" :key="list.id" class="h-auto max-w-full" :src="list.image_url"
            :alt="list.title" />
    </div>
</template>
