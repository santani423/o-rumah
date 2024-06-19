<script setup>
import { computed } from "vue";
import { Head } from "@inertiajs/vue3";

import { Slide } from "vue3-carousel";

import FrontLayout from "@/Layouts/FrontLayout.vue";

import BannerLists from "@/Components/Front/Base/BannerLists.vue";
import MenuLists from "@/Components/Front/Base/MenuLists.vue";
import SplitInfo from "@/Components/Front/Base/SplitInfo.vue";
import PropertyLists from "@/Components/Front/Base/PropertyLists.vue";
import AgentCard from "@/Components/Front/Widgets/AgentCard.vue";
import PropertyCard from "@/Components/Front/Widgets/PropertyCard.vue";
import SearchBar from "@/Components/Front/Form/SearchBar.vue";
import OurFeatures from "@/Components/Front/Widgets/OurFeatures.vue";

const props = defineProps({
    bannerLists: Object,
    latestAdsLists: Object,
    agentLists: Object,
    frontAdsLists: Object,
    propertyTypeLists: Object,
    isLanding: Boolean,
});

const latestAdsAvailable = computed(() => props.latestAdsLists?.length > 0);
const agentAvailable = computed(() => props.agentLists?.length > 0);
</script>

<template>
    <FrontLayout>
        <Head title="Homepage" />

        <!-- Banner -->
        <div class="bg-neutral-700">
            <div class="mx-auto sm:py-8 sm:space-y-6 max-w-7xl">
                <!-- Banner -->
                <BannerLists
                    class="md:block sm:px-6 lg:px-8"
                    :banner-lists="bannerLists"
                />

                <!-- Search Bar -->
                <SearchBar
                    class="px-4 -mt-6 sm:mt-0 sm:px-6 lg:px-8"
                    :property-type-lists="propertyTypeLists"
                />

                <!-- Menu List -->
                <MenuLists class="px-4 mt-3 sm:mt-0 sm:px-6 lg:px-8" />

                <!-- Split Info -->
                <SplitInfo
                    class="px-4 py-6 sm:py-0 sm:px-6 lg:px-8"
                    :items="frontAdsLists"
                />
            </div>
        </div>

        <!-- List Data -->
        <div
            class="px-4 mx-auto space-y-8 max-w-7xl sm:px-6 lg:px-8 md:my-12 md:space-y-12"
        >
            <template v-if="!isLanding">
                <PropertyLists
                    v-if="latestAdsAvailable"
                    title="Daftar properti terbaru"
                >
                    <Slide v-for="ads in latestAdsLists" :key="ads.id">
                        <PropertyCard :ads="ads" />
                    </Slide>
                </PropertyLists>
                <PropertyLists
                    v-if="agentAvailable"
                    title="Agen pilihan kami"
                    subtitle="Temukan agen pilihan kami"
                    :item-shown="3"
                >
                    <Slide v-for="agent in agentLists" :key="agent.id">
                        <AgentCard :agent="agent" />
                    </Slide>
                </PropertyLists>
            </template>

            <OurFeatures />
        </div>
    </FrontLayout>
</template>
