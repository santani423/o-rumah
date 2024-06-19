<script setup>
import { computed } from 'vue'
import { Head } from '@inertiajs/vue3'

import { Slide } from 'vue3-carousel'

import FrontLayout from '@/Layouts/FrontLayout.vue'

import BannerLists from '@/Components/Front/Base/BannerLists.vue'
import MenuLists from '@/Components/Front/Base/MenuLists.vue'
import SplitInfo from '@/Components/Front/Base/SplitInfo.vue'
import PropertyLists from '@/Components/Front/Base/PropertyLists.vue'
import AgentCard from '@/Components/Front/Widgets/AgentCard.vue'
import PropertyCard from '@/Components/Front/Widgets/PropertyCard.vue'
import SearchBar from '@/Components/Front/Form/SearchBar.vue'
import OurFeatures from '@/Components/Front/Widgets/OurFeatures.vue'

const props = defineProps({
    bannerLists: Object,
    latestAdsLists: Object,
    frontAdsLists: Object,
    agentLists: Object,
})

const latestAdsAvailable = computed(() => props.latestAdsLists?.length > 0)
const agentAvailable = computed(() => props.agentLists?.length > 0)
</script>

<template>
    <FrontLayout>

        <Head title="Homepage" />

        <!-- Banner -->
        <div class="bg-neutral-700">
            <div class="px-4 mx-auto space-y-6 max-w-7xl sm:p-6 lg:p-8">

                <!-- Banner -->
                <BannerLists class="md:block" :banner-lists="bannerLists" />

                <SearchBar />

                <!-- Menu List -->
                <MenuLists class="md:flex" />

                <!-- Split Info -->
                <SplitInfo :items="frontAdsLists" />
            </div>
        </div>

        <!-- List Data -->
        <div class="px-4 mx-auto space-y-8 max-w-7xl sm:px-6 lg:px-8 md:my-12 md:space-y-12">
            <PropertyLists v-if="latestAdsAvailable" title="Daftar properti terbaru">
                <Slide v-for="ads in latestAdsLists" :key="ads.id">
                    <PropertyCard :ads="ads" />
                </Slide>
            </PropertyLists>
            <PropertyLists v-if="agentAvailable" title="Agen pilihan kami" subtitle="Temukan agen pilihan kami"
                :item-shown="3">
                <Slide v-for="agent in agentLists" :key="agent.id">
                    <AgentCard :agent="agent" />
                </Slide>
            </PropertyLists>

            <OurFeatures />
        </div>

    </FrontLayout>
</template>
