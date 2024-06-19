<script setup>
import { Link } from '@inertiajs/vue3'
import { onMounted } from 'vue'
import { MapPinIcon } from '@heroicons/vue/24/outline'
import VLazyImage from 'v-lazy-image'
import AgentCard from './AgentCard.vue';

const props = defineProps({
    ads: Object
})

function capitalizeText(text) {
    return text.charAt(0).toUpperCase() + text.slice(1)
}
</script>

<template>
    <div>
        <Link class="block group" :href="route('property-detail', ads.slug)">
        <div class="flex items-stretch gap-6">
            <v-lazy-image class="object-cover aspect-[4/3] w-[400px] rounded-xl group-hover:opacity-90" :src="ads.image"
                :alt="ads.title" />
            <div class="flex flex-col items-start flex-1 gap-4">
                <div class="flex flex-col items-start gap-2">
                    <div v-if="ads.property" class="bg-gray-200 px-4 p-1.5 rounded-full">
                        <p class="text-sm font-medium text-gray-700">{{ capitalizeText(ads.property.property_type) }}</p>
                    </div>
                    <h3 class="text-xl font-bold tracking-wide">
                        {{ ads.title }}
                    </h3>
                    <div class="justify-start items-center gap-1.5 inline-flex">
                        <MapPinIcon class="w-5 h-5 text-neutral-500" />
                        <h6 class="tracking-wide text-neutral-500">
                            {{ ads.area }}
                        </h6>
                    </div>
                </div>
                <div class="flex flex-col gap-4">
                    <div class="text-xl font-bold tracking-wide text-blue-900">{{ ads.formatted_price }}</div>
                    <div class="flex items-center space-x-4">
                        <div class="items-center gap-1.5 flex">
                            <img src="/assets/icons/bed.png" alt="bed-icon" class="w-4 h-4" />
                            <div class="text-sm font-medium tracking-wide">{{ ads.jk }}</div>
                        </div>
                        <div class="items-center gap-1.5 flex">
                            <img src="/assets/icons/tub.png" alt="tub-icon" class="w-4 h-4" />
                            <div class="text-sm font-medium tracking-wide">{{ ads.jkm }}</div>
                        </div>
                        <div class="items-center gap-1.5 flex">
                            <div class="text-sm font-medium tracking-wide text-neutral-500">LB</div>
                            <div class="text-sm font-medium tracking-wide">{{ ads.lb }} m<sup>2</sup></div>
                        </div>
                        <div class="items-center gap-1.5 flex">
                            <div class="text-sm font-medium tracking-wide text-neutral-500">LT</div>
                            <div class="text-sm font-medium tracking-wide ">{{ ads.lt }} m<sup>2</sup></div>
                        </div>
                    </div>
                </div>
                <AgentCard :agent="ads.agent" :show-stats="false" />
            </div>
        </div>
        </Link>
    </div>
</template>
