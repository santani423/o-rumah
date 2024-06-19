<script setup>
import { Head, router, usePage } from '@inertiajs/vue3'

import ListingLayout from '@/Pages/Listing/components/ListingLayout.vue'
import AdsActivationModal
    from '@/Pages/Listing/Auction/components/AdsActivationModal.vue'
import { ref } from 'vue'
import Pagination from '@/Components/Front/Widgets/Pagination.vue'
import AdsAlertModal from '@/Pages/Listing/components/modals/AdsAlertModal.vue'

const props = defineProps({ ads: Object })
const user = usePage().props.auth.user

const ad = ref({})

const modalAction = ref('')
const modalType = ref('success')
const title = ref('')
const subtitle = ref('')

const setModalAction = (value) => {
    modalAction.value = value
}

const setModalType = (value) => {
    modalType.value = value
}

const setModalTitle = (value) => {
    title.value = value
}

const setModalSubtitle = (value) => {
    subtitle.value = value
}

const isModalShow = ref(false)
const setIsModalShow = (value, selectedAds, action) => {
    setModalAction(action)

    switch (action) {
        case 'activate':
            setModalTitle('Aktifkan lelang?')
            setModalSubtitle('Anda yakin ingin mengaktifkan lelang ini?')
            break
        case 'deactivate':
            setModalTitle('Nonaktifkan lelang?')
            setModalSubtitle('Anda yakin ingin menonaktifkan lelang ini?')
            break
        case 'bid':
            setModalTitle('Pasang lelang?')
            setModalSubtitle('Anda yakin ingin pasang lelang ini?')
            break
    }

    isModalShow.value = value
    ad.value = selectedAds
}

const isModalAlertShow = ref(false)
const setIsModalAlertShow = (value, selectedAds) => {
    isModalAlertShow.value = value
    ad.value = selectedAds
}

const handleSubmit = (adsId) => {
    router.put(route('listing.auction.update', adsId), {
        action: modalAction.value,
    }, {
        onSuccess: (page) => {
            if (page.props.flash.success != null) {
                setModalType('success')
                setModalTitle('Sukses')
                setModalSubtitle(page.props.flash.success)
            }

            setIsModalAlertShow(true, ad.value)
        },
    })
    setIsModalShow(false, ad.value)
}

console.log(props.ads);
</script>

<template>
    <ListingLayout>

        <Head title="Dashboard - Lelang" />
        <div class="flex items-center justify-between mb-3">
            <h4 class="text-lg font-bold">Lelang</h4>
        </div>

        <div class="border-[1px] border-[#D1D5DB] rounded-md">
            <div
                class="flex justify-between items-center border-b-[1px] border-[#D1D5DB] px-4 py-3 font-semibold text-base">
                <p class="text-base font-semibold">Daftar Iklan Lelang Bank</p>
            </div>
            <div class="w-full">
                <div v-for="(items) in ads.data" :key="items.id" class="w-full px-4 py-6">
                    <div class="block w-full md:flex">
                        <div class="md:w-44 h-44 rounded-xl bg-[#F6F6F6]">
                            <img :src="items.media[0].original_url" alt=""
                                class="object-cover w-full h-full rounded-xl">
                        </div>
                        <div class="flex-1 md:ml-6">
                            <p class="text-xl font-bold">{{ items.title }}</p>
                            <p class="text-[#7C7C7C] text-base font-normal">
                                {{ items.property.area }}
                            </p>
                            <div class="flex items-center justify-between w-full my-4">
                                <div class="flex-1">
                                    <p class="text-[#7C7C7C] text-base font-normal">
                                        Perkiraan Harga</p>
                                    <h5 class="text-xl font-bold text-[#2952A4]">
                                        {{
                    items.property.formatted_price
                }}</h5>
                                </div>
                                <div class="flex">
                                    <p class="mr-3 text-[#7C7C7C] text-base font-medium">
                                        LB
                                        <span class="text-[#161616]">{{
                        items.property.lb
                    }} m2</span>
                                    </p>
                                    <p class="text-[#7C7C7C] text-base font-medium">
                                        LT
                                        <span class="text-[#161616]">{{
                        items.property.lt
                    }} m2</span>
                                    </p>
                                </div>
                            </div>
                            <button v-show="!items.is_user_already_bid_auction" type="button"
                                @click="setIsModalShow(true, items, 'bid')"
                                class="bg-[#1CD6D0] text-white py-2 px-4 rounded-full">
                                Pasang Lelang
                            </button>

                            <button v-if="items.is_user_already_bid_auction && items.is_active === 1" type="button"
                                @click="setIsModalShow(true, items, 'deactivate')"
                                class="px-4 py-2 text-white bg-red-500 rounded-full">
                                Nonaktifkan Lelang
                            </button>

                            <button v-if="items.is_user_already_bid_auction && items.is_active === 0" type="button"
                                @click="setIsModalShow(true, items, 'activate')"
                                class="bg-[#1CD6D0] text-white py-2 px-4 rounded-full">
                                Aktifkan Lelang
                            </button>
                        </div>
                    </div>
                </div>
                <div v-if="ads.data.length === 0" class="p-3 font-semibold text-center">Belum ada iklan
                </div>
                <Pagination :links="ads.links" />
            </div>
        </div>
    </ListingLayout>

    <AdsActivationModal :title="title" :subtitle="subtitle" :ads="ad" :isOpen="isModalShow"
        @update:isOpen="setIsModalShow(false, ad)" @update:handleSubmit="handleSubmit" />

    <AdsAlertModal :modal-type="modalType" :title="title" :subtitle="subtitle" :ads="ad"
        :is-alert-open="isModalAlertShow" @update:is-alert-open="setIsModalAlertShow(false, ad)" />

</template>