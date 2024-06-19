<script setup>
import { Head, useForm, usePage } from '@inertiajs/vue3'
import { createToaster } from '@meforma/vue-toaster'

import FrontLayout from '@/Layouts/FrontLayout.vue'

import AgentCard from '@/Components/Front/Widgets/AgentCard.vue'
import DefaultButton from '@/Components/Front/Widgets/DefaultButton.vue'
import KprCalculator from '@/Components/Front/Widgets/KprCalculator.vue'
import PropertyDetailInfo
    from '@/Components/Front/Widgets/PropertyDetailInfo.vue'
import PropertyDetailImageGrid
    from '@/Components/Front/Widgets/PropertyDetailImageGrid.vue'
import { ArrowLeftIcon, HeartIcon, ShareIcon } from '@heroicons/vue/24/outline'
import { HeartIcon as HeartIconSolid } from '@heroicons/vue/24/solid'
import MobileComingSoon from '@/Components/Front/Base/MobileComingSoon.vue'
import { computed, reactive } from 'vue'
import useEmitter from '@/lib/useEmitter.js'

const { ads, slug } = defineProps({
    ads: Object,
    slug: String,
})

const emitter = useEmitter()

const toaster = createToaster({
    position: 'top-right',
    duration: 2300,
    queue: true,
    max: 1,
})

const user = computed(() => usePage().props.auth.user)
const isFavoritedAds = computed(() => ads.is_favorited_by_current_user)

const state = reactive({
    isFavorited: isFavoritedAds.value,
})

const form = useForm({
    ads_id: ads.ads_id,
})

const back = () => window.history.back()

const isKprShown = computed(() => {
    // if (ads.ads_type === 'Jual') {
    //     return true
    // }

    return false
})

const handleShare = () => {
    // get current url
    const url = window.location.href

    // copy to clipboard
    navigator.clipboard.writeText(url)

    toaster.success('Link berhasil disalin!')
}

const handleFavorite = () => {
    if (!user.value) {
        emitter.emit('setIsModalLoginShow', true)
        return
    }

    form.post(route('wishlist.store'), {
        preserveScroll: true,
        onSuccess: () => {
            state.isFavorited = !state.isFavorited
        },
        onError: () => toaster.error(
            'Terjadi kesalahan, silahkan coba kembali!'),
    })
}

</script>

<template>
    <MobileComingSoon/>
    <FrontLayout>

        <Head :title="ads.title"/>

        <div class="px-4 mx-auto space-y-6 max-w-7xl sm:p-6 lg:p-8">
            <div class="flex flex-col md:flex-row md:justify-between">
                <DefaultButton @click="back()">
                    <ArrowLeftIcon class="w-4 h-4 mr-2 text-neutral-900"
                                   aria-hidden="true"/>
                    Kembali
                </DefaultButton>

                <div class="flex gap-2">
                    <form @submit.prevent="handleFavorite">
                        <input type="hidden" v-model="form.ads_id"/>
                        <DefaultButton v-if="state.isFavorited" type="submit">
                            <HeartIconSolid class="w-4 h-4 mr-2 text-red-500"
                                            aria-hidden="true"/>
                            <span>Difavoritkan</span>
                        </DefaultButton>
                        <DefaultButton v-else type="submit">
                            <HeartIcon class="w-4 h-4 mr-2 text-neutral-900"
                                       aria-hidden="true"/>
                            <span>Favoritkan</span>
                        </DefaultButton>
                    </form>
                    <DefaultButton @click="handleShare">
                        <ShareIcon class="w-4 h-4 mr-2 text-neutral-900"
                                   aria-hidden="true"/>
                        Bagikan
                    </DefaultButton>
                </div>
            </div>
            <PropertyDetailImageGrid :media="ads.media"/>
            <div class="flex gap-12">
                <div class="w-4/6">
                    <PropertyDetailInfo :ads="ads"/>
                </div>
                <div class="w-2/6 space-y-6">
                    <AgentCard :agent="ads.agent"
                               :show-stats="false"
                               :show-kpr="isKprShown"
                               :link-kpr="route('kpr-registration', slug)"/>
                    <KprCalculator :price="ads.price"/>
                </div>
            </div>
        </div>

        <!-- <div class="px-4 mx-auto space-y-8 max-w-7xl sm:px-6 lg:px-8 md:mb-12 md:space-y-12">
            <PropertyLists title="Properti serupa">
                <Slide v-for="slide in 10" :key="slide">
                    <PropertyCard />
                </Slide>
            </PropertyLists>
        </div> -->
    </FrontLayout>
</template>
