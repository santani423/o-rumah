<script setup>
import { computed, reactive } from "vue";
import { Head, router } from "@inertiajs/vue3";

import FrontLayout from "@/Layouts/FrontLayout.vue";
import MobileComingSoon from "@/Components/Front/Base/MobileComingSoon.vue";
import SearchListing from "@/Components/Front/Widgets/SearchListing.vue";
import Pagination from "@/Components/Front/Widgets/Pagination.vue";
import AuctionCard from "@/Components/Front/Widgets/AuctionCard.vue";
import BannerLists from "@/Components/Front/Base/BannerLists.vue";

const props = defineProps({
    adsLists: Object,
    bannerLists: Object,
});

const adsAvailable = computed(() => props.adsLists?.data.length > 0);
const bannerAvailable = computed(() => props.bannerLists?.length > 0);

const form = reactive({
    sort: "0",
});

const filterData = () => {
    // get page url in inertia
    const params = Object.fromEntries(
        new URLSearchParams(window.location.search)
    );

    // append form data
    params.sort = form.sort;

    router.get(route("auction"), params, {
        preserveState: true,
        preserveScroll: true,
    });
};
</script>

<template>
    <MobileComingSoon />
    <FrontLayout>
        <Head title="Properti Lelang" />

        <!-- Banner -->
        <div
            v-if="bannerAvailable"
            class="px-4 mx-auto space-y-8 max-w-7xl sm:p-6 lg:p-8"
        >
            <BannerLists
                class="md:block"
                :banner-lists="bannerLists"
                :is-navigation-show="false"
            />
        </div>

        <SearchListing
            class="-mt-1.5"
            is-full-width
            :current-url="route('auction')"
        />

        <div class="px-4 mx-auto mb-6 space-y-8 max-w-7xl sm:p-6 lg:p-8">
            <div v-if="adsAvailable" class="space-y-6">
                <div
                    class="flex md:flex-row md:items-center md:justify-between"
                >
                    <div class="flex flex-col gap-1">
                        <span class="text-xl font-medium text-neutral-900"
                            >Properti Lelang</span
                        >
                        <span class="text-neutral-500"
                            >{{ adsLists.total }} properti lelang
                            ditemukan</span
                        >
                    </div>
                    <div class="flex justify-end">
                        <select
                            @change="filterData()"
                            v-model="form.sort"
                            class="pl-4 border rounded-full border-neutral-200 text-neutral-900 focus:ring-0 focus:ring-transparent focus:border-neutral-200"
                        >
                            <option value="0" selected>Diutamakan</option>
                            <option value="1">Terbaru</option>
                            <option value="2">Harga Terendah</option>
                            <option value="3">Harga Tertinggi</option>
                            <option value="4">Luas Tanah Terkecil</option>
                            <option value="5">Luas Tanah Terbesar</option>
                            <option value="6">Luas Bangunan Terkecil</option>
                            <option value="7">Luas Bangunan Terbesar</option>
                        </select>
                    </div>
                </div>

                <div
                    class="grid grid-cols-[repeat(auto-fill,minmax(300px,1fr))] gap-x-6 gap-y-12"
                >
                    <AuctionCard
                        v-for="ads in adsLists.data"
                        :key="ads.id"
                        :ads="ads"
                    />
                </div>
            </div>
            <div v-else>
                <div class="text-center">
                    <div class="text-lg font-medium text-neutral-900">
                        Tidak ada properti
                    </div>
                </div>
            </div>

            <Pagination class="mx-auto" :links="adsLists.links" />
        </div>
    </FrontLayout>
</template>
