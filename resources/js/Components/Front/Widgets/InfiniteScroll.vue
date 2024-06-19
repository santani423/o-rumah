<script setup>
import { ref, watchEffect } from 'vue';
import { router } from '@inertiajs/vue3';
import { useIntersectionObserver } from '@vueuse/core'

const props = defineProps({
    endpoint: {
        type: String,
        required: true,
    },
})

// For infinite scroll
const loader = ref(null)
const loaderIsVisible = ref(false)

// For data
const page = ref(1);
const loadingShown = ref(false)
const isFetching = ref(false)

useIntersectionObserver(
    loader,
    ([{ isIntersecting }]) => {
        loaderIsVisible.value = isIntersecting
    },
)

const setIsFetching = (value) => {
    isFetching.value = value
    loadingShown.value = value
}

watchEffect(() => {
    if (loaderIsVisible.value && !isFetching.value) {

        page.value++


        setIsFetching(true)

        setTimeout(() => {
            setIsFetching(false)
        }, 2000)
    }
})
</script>

<template>
    <div ref="loader" class="flex">
        <template v-if="loadingShown">
            <div class="w-4/5">
                <h3 class="text-xl font-medium text-center text-neutral-900">Loading...</h3>
            </div>
        </template>
    </div>
</template>
