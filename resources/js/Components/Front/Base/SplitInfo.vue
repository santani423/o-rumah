<script setup>

const props = defineProps({
    items: Array
})

</script>

<template>
    <div class="flex flex-col gap-6 md:flex-row">
        <div v-for="item in items" class="md:w-1/2">
            <a :href="item.url" target="_blank" class="cursor-pointer">
                <img class="w-full h-[300px] object-cover rounded-2xl" :src="item.image_url"
                    alt="info" />
            </a>
        </div>
    </div>
</template>
