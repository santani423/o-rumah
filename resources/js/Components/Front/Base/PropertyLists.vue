<script setup>
import { ref } from 'vue'
import { ChevronLeftIcon, ChevronRightIcon } from '@heroicons/vue/20/solid'
import { Carousel } from 'vue3-carousel'
import 'vue3-carousel/dist/carousel.css'

const carousel = ref(null)
const prev = () => carousel.value.prev()
const next = () => carousel.value.next()

defineProps({
    items: {
        type: Object,
        required: false
    },
    itemShown: {
        type: Number,
        default: 4
    },
    title: {
        type: String,
    },
    subtitle: {
        type: String,
    }
})

</script>

<template>
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div class="px-2">
                <h2 class="text-xl font-semibold sm:text-2xl">
                    {{ title }}
                </h2>
                <p class="mt-1 font-medium text-neutral-500" v-if="subtitle">{{ subtitle }}</p>
            </div>
            <div class="flex space-x-2">
                <button type="button" @click="prev"
                    class="p-2 bg-white rounded-full text-neutral-900 ring-1 ring-inset ring-neutral-200 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white hover:bg-neutral-50">
                    <ChevronLeftIcon class="w-5 h-5" aria-hidden="true" />
                </button>
                <button type="button" @click="next"
                    class="p-2 bg-white rounded-full text-neutral-900 ring-1 ring-inset ring-neutral-200 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white hover:bg-neutral-50">
                    <ChevronRightIcon class="w-5 h-5" aria-hidden="true" />
                </button>
            </div>
        </div>
        <div class="grid grid-cols-1 gap-x-6 gap-y-10 xl:gap-x-8">
            <Carousel :items-to-show="itemShown" :items-to-scroll="1" :wrap-around="true" :snap-align="'start'"
                ref="carousel">
                <slot />
            </Carousel>
        </div>
    </div>
</template>
