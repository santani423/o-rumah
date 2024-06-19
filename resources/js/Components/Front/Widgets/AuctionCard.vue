<script setup>
import { Link } from "@inertiajs/vue3";
import { BuildingLibraryIcon, MapPinIcon } from "@heroicons/vue/24/outline";
import VLazyImage from "v-lazy-image";

defineProps({
    ads: Object,
});
</script>

<template>
    <div
        class="max-w-md mx-auto bg-white rounded-lg shadow-md overflow-hidden p-3"
    >
        <Link
            class="block group"
            :href="route('auction-detail', [ads.slug, ads.username])"
        >
            <div class="flex flex-col items-stretch gap-3">
                <div class="relative">
                    <v-lazy-image
                        class="object-cover aspect-[4/3] w-[400px] rounded-xl group-hover:opacity-90"
                        :src="ads.image"
                        :alt="ads.title"
                    />

                    <div
                        class="absolute inline-flex items-center px-4 py-2 font-medium text-white rounded-full pointer-events-none top-3 left-3 bg-neutral-900/60 group"
                    >
                        <BuildingLibraryIcon class="w-4 h-4" />
                        <span class="ml-2">Aset Bank</span>
                    </div>
                </div>
                <div class="flex flex-col items-start flex-1 gap-2">
                    <div class="flex flex-col items-start gap-2">
                        <h3 class="text-xl font-bold tracking-wide">
                            {{ ads.title }}
                        </h3>
                        <div
                            class="justify-start items-center gap-1.5 inline-flex"
                        >
                            <MapPinIcon class="w-5 h-5 text-neutral-500" />
                            <h6 class="tracking-wide text-neutral-500">
                                {{ ads.area }}
                            </h6>
                        </div>
                    </div>
                    <div class="flex flex-col gap-4">
                        <div
                            class="text-xl font-bold tracking-wide text-blue-900"
                        >
                            {{ ads.formatted_price }}
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="items-center gap-1.5 flex">
                                <img
                                    src="/assets/icons/bed.png"
                                    alt="bed-icon"
                                    class="w-4 h-4"
                                />
                                <div class="text-sm font-medium tracking-wide">
                                    {{ ads.jk }}
                                </div>
                            </div>
                            <div class="items-center gap-1.5 flex">
                                <img
                                    src="/assets/icons/tub.png"
                                    alt="tub-icon"
                                    class="w-4 h-4"
                                />
                                <div class="text-sm font-medium tracking-wide">
                                    {{ ads.jkm }}
                                </div>
                            </div>
                            <div class="items-center gap-1.5 flex">
                                <div
                                    class="text-sm font-medium tracking-wide text-neutral-500"
                                >
                                    LB
                                </div>
                                <div class="text-sm font-medium tracking-wide">
                                    {{ ads.lb }} m<sup>2</sup>
                                </div>
                            </div>
                            <div class="items-center gap-1.5 flex">
                                <div
                                    class="text-sm font-medium tracking-wide text-neutral-500"
                                >
                                    LT
                                </div>
                                <div class="text-sm font-medium tracking-wide">
                                    {{ ads.lt }} m<sup>2</sup>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </Link>
    </div>
</template>
