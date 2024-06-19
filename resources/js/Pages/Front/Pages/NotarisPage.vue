<script setup>

import { computed } from 'vue'
import { Head } from '@inertiajs/vue3'

import FrontLayout from '@/Layouts/FrontLayout.vue'
import MobileComingSoon from '@/Components/Front/Base/MobileComingSoon.vue'
import Pagination from '@/Components/Front/Widgets/Pagination.vue'
import BannerLists from '@/Components/Front/Base/BannerLists.vue'
import SearchListing from '@/Components/Front/Widgets/SearchListing.vue'
import NotarisCard from '@/Components/Front/Widgets/NotarisCard.vue'

const props = defineProps({
    userLists: Object,
    bannerLists: Object
})

const userAvailable = computed(() => props.userLists?.data.length > 0)
</script>

<template>
    <MobileComingSoon />
    <FrontLayout>

        <Head title="Cari notaris" />

        <!-- Banner -->
        <div v-if="bannerAvailable" class="px-4 mx-auto space-y-8 max-w-7xl sm:p-6 lg:p-8">
            <BannerLists class="md:block" :banner-lists="bannerLists" :is-navigation-show="false" />
        </div>

        <SearchListing class="-mt-1.5" :current-url="route('notaris')" search-placeholder="Cari notaris" is-full-width
            hide-filter />

        <div class="px-4 mx-auto mb-6 space-y-8 max-w-7xl sm:p-6 lg:p-8">

            <div v-if="userAvailable" class="space-y-6">
                <div class="flex md:flex-row md:items-center md:justify-between">
                    <div class="flex flex-col gap-1">
                        <span class="text-xl font-medium text-neutral-900">Cari notaris</span>
                        <span class="text-neutral-500">{{ userLists.total }} notaris ditemukan</span>
                    </div>
                </div>

                <div class="grid grid-cols-[repeat(auto-fill,minmax(300px,1fr))] gap-x-6 gap-y-12">
                    <NotarisCard v-for="notaris in userLists.data" :key="notaris.id" :notaris="notaris"
                        :show-stats="false" />
                </div>
            </div>
            <div v-else>
                <div class="text-center">
                    <div class="text-lg font-medium text-neutral-900">Tidak ada notaris ditemukan</div>
                </div>
            </div>

            <Pagination class="mx-auto" :links="userLists.links" />
        </div>
    </FrontLayout>
</template>