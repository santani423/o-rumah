<script setup>
import { Link } from "@inertiajs/vue3";
import { ClockIcon, MapPinIcon } from "@heroicons/vue/24/outline";
import VLazyImage from "v-lazy-image";

defineProps({
    ads: Object,
});
</script>

<template>
    <div>
        <Link class="block group" :href="route('ofood-detail', ads.slug)">
            <div class="flex flex-col items-stretch gap-3">
                <v-lazy-image
                    class="object-cover aspect-[4/3] w-[400px] rounded-xl group-hover:opacity-90"
                    :src="ads.image"
                    :alt="ads.title"
                />
                <div class="flex flex-col items-start flex-1 gap-2">
                    <div class="flex flex-col items-start gap-2">
                        <h3
                            class="text-xl font-bold tracking-wide text-blue-900"
                        >
                            {{ ads.title }}
                        </h3>
                        <div
                            v-if="ads.address"
                            class="items-center gap-1.5 flex"
                        >
                            <MapPinIcon class="w-4 h-4" />
                            <h5 class="tracking-wide">
                                {{ ads.address }}
                            </h5>
                        </div>
                    </div>
                    <!-- <div class="flex flex-col gap-4"> -->
                    <!-- <h6 class="tracking-wide text-neutral-500">
                            Contoh Tagline OFoods
                        </h6> -->
                    <!-- <div class="flex items-center space-x-4"> -->
                    <!-- <div class="items-center gap-1.5 flex">
                                <StarIcon class="w-4 h-4 text-yellow-400"/>
                                <div class="text-sm font-medium tracking-wide">4.4</div>
                            </div> -->
                    <!-- <div class="items-center gap-1.5 flex">
                                <ClockIcon class="w-4 h-4"/>
                                <div class="text-sm font-medium tracking-wide">09:00 - 21:00</div>
                            </div> -->
                    <!-- <div class="items-center gap-1.5 flex">
                                <MapPinIcon class="w-4 h-4"/>
                                <div class="text-sm font-medium tracking-wide">25 min (0.9km)</div>
                            </div> -->
                    <!-- </div> -->
                    <!-- </div> -->
                </div>
            </div>
        </Link>
    </div>
</template>
