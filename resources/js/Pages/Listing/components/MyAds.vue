<template>
    <div class="border-[1px] border-[#D1D5DB] rounded-md">
        <div
            class="flex justify-between items-center border-b-[1px] border-[#D1D5DB] px-4 py-3 font-semibold text-base">
            <p>Iklan Saya</p>
            <div>
                <input type="text"
                    class="block w-full rounded-md border-0 py-1.5 text-neutral-900 shadow-sm ring-1 ring-inset ring-neutral-300 placeholder:text-neutral-400 placeholder:font-normal focus:ring-2 focus:ring-inset focus:ring-slate-500 sm:text-sm sm:leading-6"
                    placeholder="Cari iklan saya" v-model="form.query" @keydown.enter="filterData()" />
            </div>
        </div>
        <div>
            <div v-if="ads.data.length > 0" v-for="(items) in ads.data" :key="items.id"
                class="px-4 py-3 md:flex justify-between items-center block border-b-[1px] border-b-[#D1D5DB] mt-3">
                <div class="block mb-3 md:flex">
                    <div class="md:w-28 h-28 border-[1px] border-[#D1D5DB] rounded-xl bg-[#F6F6F6]">
                        <img v-if="items.media.length > 0" :src="items.media[0].original_url" alt=""
                            class="object-cover w-full h-full rounded-xl">
                    </div>
                    <div class="md:ml-6">
                        <h5 class="text-xl font-bold text-[#2952A4]">
                            {{ items.property.formatted_price }}</h5>
                        <p class="my-1">{{ items.title }}</p>
                        <p class="text-[#7C7C7C] mb-1">
                            {{ items.property.area }},
                            <span class="capitalize">{{
                        items.property.district_name.toLowerCase()
                    }}</span>
                        </p>
                        <div class="flex space-x-4">
                            <div class="flex items-center space-x-2">
                                <img src="assets/icons/bed.png" alt="tub-icon" class="w-5 h-5">
                                <p class="font-medium">{{
                            items.property.jk ?? '0'
                        }}</p>
                            </div>
                            <div class="flex space-x-2">
                                <img src="/assets/icons/tub.png" alt="tub-icon" class="w-5 h-5" />
                                <p class="font-medium">1</p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="text-[#7C7C7C] font-medium">LB</span>
                                <span class="font-medium">{{
                            items.property.lb
                        }} m2</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <!-- <div class="grid grid-cols-2 gap-2 mb-3" dir="rtl">
                        <div class="py-1 text-sm text-center rounded-full bg-red-50">Sundul</div>
                        <div class="py-1 text-sm text-center rounded-full bg-green-50">Landing Page</div>
                        <div class="py-1 text-sm text-center rounded-full bg-cyan-50">KPR</div>
                    </div> -->
                    <div class="flex gap-3">
                        <a :href="route('listing.edit', items.id)"
                            class="border-[1px] border-black py-2 px-8 rounded-full mr-2 hover:bg-black hover:text-white">Edit</a>
                        <button v-if="items.is_active === 1" type="button"
                            @click="setIsModalShow(true, items, 'deactivate')"
                            class="px-4 py-2 text-white bg-red-500 rounded-full">Nonaktifkan Iklan</button>
                        <button v-if="items.is_active === 0" type="button"
                            @click="setIsModalShow(true, items, 'activate')"
                            class="bg-[#1CD6D0] text-white py-2 px-4 rounded-full">Aktifkan Iklan</button>
                    </div>
                </div>
            </div>
            <div v-else class="p-3 font-semibold text-center">Belum ada iklan</div>
            <Pagination :links="ads.links" />
        </div>
    </div>
    <AdsActivationModal :title="title" :subtitle="subtitle" :ads="ad" :isOpen="isModalShow"
        @update:isOpen="setIsModalShow(false, ad)" @update:handleSubmit="handleSubmit" />

    <AdsAlertModal :modal-type="modalType" :title="title" :subtitle="subtitle" :ads="ad"
        :is-alert-open="isModalAlertShow" @update:is-alert-open="setIsModalAlertShow(false, ad)" />
</template>

<script setup>
import { ref } from 'vue'
import { router, useForm } from '@inertiajs/vue3'

import Pagination from '@/Components/Front/Widgets/Pagination.vue'
import AdsActivationModal
    from '@/Pages/Listing/Auction/components/AdsActivationModal.vue'
import AdsAlertModal from '@/Pages/Listing/components/modals/AdsAlertModal.vue'

const props = defineProps({
    ads: Object,
})

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

const form = useForm({
    query: '',
})

const isModalShow = ref(false)
const setIsModalShow = (value, selectedAds, action) => {
    setModalAction(action)

    switch (action) {
        case 'activate':
            setModalTitle('Aktifkan iklan?')
            setModalSubtitle('Anda yakin ingin mengaktifkan iklan ini?')
            break
        case 'deactivate':
            setModalTitle('Nonaktifkan iklan?')
            setModalSubtitle('Anda yakin ingin menonaktifkan iklan ini?')
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

const filterData = () => {
    router.get(route('listing.index'), form.data(), { preserveState: true })
}

const handleSubmit = (adsId) => {
    router.put(route('listing.toggle', adsId), {
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
</script>