<script setup>
import { Head, useForm, usePage } from '@inertiajs/vue3'
import { ArrowLeftIcon, TrashIcon } from '@heroicons/vue/24/outline'

import FrontLayout from '@/Layouts/FrontLayout.vue'

import Breadcrumbs from '@/Components/Front/Base/Breadcrumbs.vue'
import MobileComingSoon from '@/Components/Front/Base/MobileComingSoon.vue'

import Pagination from '@/Components/Front/Widgets/Pagination.vue'
import PropertyWishList from '@/Components/Front/Widgets/PropertyWishList.vue'
import DefaultButton from '@/Components/Front/Widgets/DefaultButton.vue'
import { computed, reactive } from 'vue'
import { createToaster } from '@meforma/vue-toaster'

const toaster = createToaster({
    position: 'top-right',
    duration: 2300,
    queue: true,
    max: 1,
})

const props = defineProps({
    adsLists: Object,
})

const { auth: { user } } = usePage().props

const adsIdsToDelete = reactive([])

const isAdsIdsToDeleteExist = computed(() => adsIdsToDelete.length > 0)

const form = useForm({
    adsIds: [],
})

const back = () => window.history.back()

const handleCheck = (adsId) => {
    if (adsIdsToDelete.includes(adsId)) {
        adsIdsToDelete.splice(adsIdsToDelete.indexOf(adsId), 1)
    } else {
        adsIdsToDelete.push(adsId)
    }

}

const handleDelete = () => {
    form.adsIds = adsIdsToDelete

    form.delete(route('wishlist.destroy'), {
        preserveScroll: true,
        onSuccess: () => {
            toaster.success('Properti favorit berhasil dihapus!')
        },
        onError: () => toaster.error('Terjadi kesalahan, silahkan coba kembali!'),
    })
}
</script>

<template>
    <MobileComingSoon/>
    <FrontLayout>

        <Head :title="`Properti Favorit | ${user.name}`"/>

        <div class="px-4 mx-auto space-y-6 max-w-7xl sm:p-6 lg:p-8">
            <div>
                <DefaultButton @click="back()">
                    <ArrowLeftIcon class="w-4 h-4 mr-2 text-neutral-900"
                                   aria-hidden="true"/>
                    Kembali
                </DefaultButton>
            </div>
            <div class="flex gap-12">
                <div v-if="adsLists.data.length" class="w-4/5 space-y-6">
                    <div class="flex flex-col gap-1">
                        <span class="text-xl font-medium text-neutral-900">Properti favorit</span>
                        <span class="text-neutral-500">{{
                                adsLists.data.length
                            }} properti ditemukan</span>
                    </div>

                    <div class="flex items-center justify-between">
                        <Breadcrumbs :pages="[
                        { name: 'Properti Favorit', url: null, current: true }
                    ]"/>
                        <form @submit.prevent="handleDelete">
                            <input type="hidden" v-model="adsIdsToDelete" />
                            <DefaultButton type="submit" v-show="isAdsIdsToDeleteExist">
                                <TrashIcon class="w-4 h-4 mr-2 text-neutral-900" />
                                <span>Hapus</span>
                            </DefaultButton>
                        </form>
                    </div>

                    <PropertyWishList
                        v-for="ads in adsLists.data"
                        :key="ads.id"
                        :ads="ads"
                        @check="handleCheck"
                    />
                </div>
                <div v-else class="w-4/5">
                    <div class="text-center">
                        <div class="text-lg font-medium text-neutral-900">Tidak
                            ada properti
                        </div>
                    </div>
                </div>
            </div>

            <Pagination :links="adsLists.links"/>
        </div>
    </FrontLayout>
</template>
