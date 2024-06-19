<script setup>
import { Link } from "@inertiajs/vue3";
import { ClockIcon, MapPinIcon } from "@heroicons/vue/24/outline";
import VLazyImage from "v-lazy-image";

const props = defineProps({
    ads: Object,
});
console.log("ceek", props);
</script>

<template>
    <div>
        <Link class="block group" :href="route('property-detail', ads.slug)">
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
                </div>
            </div>
        </Link>
    </div>
</template>
