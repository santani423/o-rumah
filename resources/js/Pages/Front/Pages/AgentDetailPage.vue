<script setup>
import { Head, Link, router, usePage } from '@inertiajs/vue3'
import { createToaster } from '@meforma/vue-toaster'

import FrontLayout from '@/Layouts/FrontLayout.vue'

import { computed, reactive } from 'vue'
import DefaultButton from '@/Components/Front/Widgets/DefaultButton.vue'
import { PencilIcon, ShareIcon } from '@heroicons/vue/24/outline'
import MobileComingSoon from '@/Components/Front/Base/MobileComingSoon.vue'
import AgentSummaryCard from '@/Components/Front/Widgets/AgentSummaryCard.vue'
import PropertyCard from '@/Components/Front/Widgets/PropertyCard.vue'
import SearchListing from '@/Components/Front/Widgets/SearchListing.vue'

const { agent } = defineProps({
    agent: Object,
})

const toaster = createToaster({
    position: 'top-right',
    duration: 2300,
    queue: true,
    max: 1,
})

// get auth user
const user = computed(() => usePage().props.auth.user)

const adsAvailable = computed(() => agent?.ads.data.length > 0)

const back = () => {
    window.history.back()
}

const handleShare = () => {
    // get current url
    const url = window.location.href

    // copy to clipboard
    navigator.clipboard.writeText(url)

    toaster.success('Link berhasil disalin!')
}

const form = reactive({
    sort: '0'
})

const filterData = () => {
    // get page url in inertia
    const params = Object.fromEntries(new URLSearchParams(window.location.search))

    // append form data
    params.sort = form.sort

    router.get(route('agent-detail', agent.username), params, { preserveState: true })
}

</script>

<template>
    <MobileComingSoon/>
    <FrontLayout>

        <Head :title="agent.name"/>

        <div class="px-4 mx-auto mb-6 space-y-6 max-w-7xl sm:p-6 lg:p-8">
            <div class="flex flex-col md:flex-row md:justify-end">
                <!--
                <DefaultButton @click="back()">
                    <ArrowLeftIcon class="w-4 h-4 mr-2 text-neutral-900" aria-hidden="true" />
                    Kembali
                </DefaultButton> -->

                <div class="flex gap-2">
                    <Link v-if="user && (user.id === agent.agent_id)" :href="route('profile')">
                        <DefaultButton>
                            <PencilIcon
                                class="w-4 h-4 mr-2 text-neutral-900"
                                aria-hidden="true"/>
                            Edit Profil
                        </DefaultButton>
                    </Link>
                    <DefaultButton @click="handleShare">
                        <ShareIcon class="w-4 h-4 mr-2 text-neutral-900"
                                   aria-hidden="true"/>
                        Bagikan
                    </DefaultButton>
                </div>
            </div>

            <div>
                <AgentSummaryCard :agent="agent"/>
            </div>

            <SearchListing class="-mt-1.5 !px-0"
                           :current-url="route('agent-detail', agent.username)"
                           search-placeholder="Cari properti" is-full-width
                           hide-filter/>

            <div class="mx-auto mb-6 space-y-8 max-w-7xl">

                <div v-if="adsAvailable" class="space-y-6">
                    <div
                        class="flex md:flex-row md:items-center md:justify-between">
                        <div class="flex flex-col gap-1">
                            <span class="text-xl font-medium text-neutral-900">Daftar listing iklan</span>
                            <span class="text-neutral-500">{{
                                    agent.ads.data.length
                                }} listing ditemukan</span>
                        </div>
                        <div class="flex justify-end">
                            <select
                                @change="filterData()" v-model="form.sort"
                                class="pl-4 border rounded-full border-neutral-200 text-neutral-900 focus:ring-0 focus:ring-transparent focus:border-neutral-200">
                                <option value="0" selected>Diutamakan</option>
                                <option value="1">Terbaru</option>
                            </select>
                        </div>
                    </div>

                    <div
                        class="grid grid-cols-[repeat(auto-fill,minmax(300px,1fr))] gap-x-6 gap-y-12">
                        <PropertyCard v-for="ads in agent.ads.data"
                                      :key="ads.id" :ads="ads"/>
                    </div>
                </div>
                <div v-else>
                    <div class="text-center">
                        <div class="text-lg font-medium text-neutral-900">Tidak
                            ada listing ditemukan
                        </div>
                    </div>
                </div>

                <Pagination class="mx-auto" :links="agent.ads.links"/>
            </div>

        </div>

    </FrontLayout>
</template>
