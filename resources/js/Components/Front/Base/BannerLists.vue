<template>
    <div class="carousel">
        <Carousel
            :items-to-show="1"
            :items-to-scroll="1"
            :autoplay="3000"
            :wrap-around="true"
        >
            <Slide v-for="item in bannerLists" :key="item.id">
                <a
                    :href="item.url"
                    target="_blank"
                    class="block w-full h-full cursor-pointer"
                >
                    <div class="carousel__item">
                        <v-lazy-image
                            class="absolute top-0 left-0 object-cover w-full h-full md:rounded-3xl"
                            :src="item.image_url"
                            :alt="item.name"
                        />
                    </div>
                </a>
            </Slide>

            <template #addons>
                <Navigation v-if="isNavigationShow" />
            </template>
        </Carousel>
    </div>
</template>

<script setup>
import { Carousel, Navigation, Slide } from "vue3-carousel";
import VLazyImage from "v-lazy-image";

import "vue3-carousel/dist/carousel.css";

const props = defineProps({
    bannerLists: Array,
    isNavigationShow: {
        type: Boolean,
        default: true,
    },
});
</script>
