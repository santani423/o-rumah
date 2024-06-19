<script setup>
import { Link } from '@inertiajs/vue3'
import { MapPinIcon } from '@heroicons/vue/24/outline'
import VLazyImage from 'v-lazy-image'
import AgentCard from './AgentCard.vue'

const { ads } = defineProps({
    ads: Object,
})

const emit = defineEmits(['check'])

const handleCheck = (adsId) => {
    emit('check', adsId)
}
</script>

<template>
    <div>
        <div class="flex items-stretch gap-6 group">
            <div class="relative">
                <div
                    class="z-20 opacity-0 group-has-[input[type=checkbox]:checked]:opacity-100 group-hover:opacity-100 absolute top-3 left-3 inline-flex items-center p-4 font-medium bg-neutral-900/60 rounded-full group">
                    <div class="flex items-center justify-center">
                        <input
                            type="checkbox"
                            @change="handleCheck(ads.ads_id)"
                            class="w-4 h-4 cursor-pointer text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                        />
                    </div>
                </div>
                <v-lazy-image class="object-cover aspect-[4/3] h-full w-[400px] rounded-xl"
                              :src="ads.image"
                              :alt="ads.title"/>
            </div>
            <Link class="block flex-1 group" :href="route('property-detail', ads.slug)">
                <div class="flex flex-col items-start flex-1 gap-4">
                    <div class="flex flex-col items-start gap-2">
                        <h3 class="text-xl font-bold tracking-wide">
                            {{ ads.title }}
                        </h3>
                        <div class="justify-start items-center gap-1.5 inline-flex">
                            <MapPinIcon class="w-5 h-5 text-neutral-500"/>
                            <h6 class="tracking-wide text-neutral-500">
                                {{ ads.area }}
                            </h6>
                        </div>
                    </div>
                    <div class="flex flex-col gap-4">
                        <div class="text-xl font-bold tracking-wide text-blue-900">{{ ads.formatted_price }}</div>
                        <div class="flex items-center space-x-4">
                            <div class="items-center gap-1.5 flex">
                                <img src="/assets/icons/bed.png" alt="bed-icon" class="w-4 h-4"/>
                                <div class="text-sm font-medium tracking-wide">{{ ads.jk }}</div>
                            </div>
                            <div class="items-center gap-1.5 flex">
                                <img src="/assets/icons/tub.png" alt="tub-icon" class="w-4 h-4"/>
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
                    <AgentCard :agent="ads.agent" :show-stats="false"/>
                </div>
            </Link>
        </div>
    </div>
</template>
