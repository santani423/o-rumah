<script setup>
import { ref, watchEffect } from 'vue';
import RealEstateIcon from '@/Components/Front/Icon/RealEstateIcon.vue';
import LocationIcon from '@/Components/Front/Icon/LocationIcon.vue';
import { MagnifyingGlassIcon } from '@heroicons/vue/24/outline'
import { router, useForm } from '@inertiajs/vue3'

const props = defineProps({
    propertyTypeLists: Object
})

const showSearchResult = ref(false)

const form = useForm({
    'query': '',
    'ads_type': 'jual',
    'property_type': 'Rumah',
})

const search = () => {

    router.get(route('latest'), form.data(), { preserveState: true })
}

const setRentType = (type) => {
    form.ads_type = type
}

const setShowSearchResult = (value) => {
    showSearchResult.value = value
}

const isRentType = (type) => form.ads_type === type

/* watchEffect(() => {
    if (q.value) {
        if (q.value.length >= 3) {
            setTimeout(() => {
                setShowSearchResult(true)
            }, 1000)
        }
    } else {
        setShowSearchResult(false)
    }
}) */

</script>

<template>
    <div class="relative">
        <div class="block">
            <nav class="flex justify-center" aria-label="Tabs">
                <button @click="setRentType('jual')" type="button"
                    class="relative py-4 text-center text-gray-900 bg-white md:px-2 rounded-tl-2xl basis-24 group focus:z-10"
                    aria-current="page">
                    <span
                        :class="[isRentType('jual') && 'bg-teal-400 text-white', 'p-2 px-6 text-gray-900 rounded-full']">Jual</span>
                </button>
                <button @click="setRentType('sewa')" type="button"
                    class="relative px-2 py-4 text-center text-gray-900 bg-white rounded-tr-2xl basis-24 group focus:z-10"
                    aria-current="page">
                    <span
                        :class="[isRentType('sewa') && 'bg-teal-400 text-white', 'p-2 px-6 text-gray-900 rounded-full']">Sewa</span>
                </button>
            </nav>
        </div>
        <div class="flex bg-white rounded-2xl">

            <!-- Tipe Properti -->
            <div class="flex flex-col gap-3 px-4 py-2 md:px-8 md:py-4">
                <div class="items-center justify-start hidden gap-2 md:inline-flex">
                    <RealEstateIcon class="w-5 h-5" />
                    <h6 class="text-center text-black">Tipe Properti</h6>
                </div>
                <select v-model="form.property_type"
                    class="pl-0 border-0 md:border-b border-neutral-200 text-neutral-500 focus:ring-0 focus:ring-transparent focus:border-neutral-200">
                    <option v-for="propertyType in propertyTypeLists" :key="propertyType">{{ propertyType }}</option>
                </select>
            </div>

            <!-- Lokasi (searchbar) -->
            <div class="flex items-center justify-between flex-1 gap-8 px-4 py-2 border-l border-gray-200 md:px-8 md:py-4">
                <div class="flex flex-col flex-1 gap-2">
                    <div class="items-center justify-start hidden gap-2 md:inline-flex">
                        <LocationIcon class="w-5 h-5" />
                        <h6 class="text-center text-black">Lokasi</h6>
                    </div>
                    <div class="relative">
                        <div class="flex items-center">
                            <LocationIcon class="w-6 h-6 mr-2 md:hidden" />
                            <input
                                @keydown.enter="search"
                                v-model="form.query"
                                autocomplete="off"
                                type="text"
                                class="block w-full h-full py-2 pl-0 border-0 md:border-b border-neutral-200 placeholder:text-neutral-400 focus:ring-0 focus:ring-transparent focus:border-neutral-200"
                                placeholder="Cari berdasarkan daerah, kota, atau alamat" />
                        </div>
                        <!-- Search Result -->
                        <div
                            :class="[!showSearchResult && 'hidden', 'absolute w-full mt-3 bg-white border border-gray-200 shadow-sm']">
                            <ul class="divide-y divide-gray-200">
                                <li class="p-2">
                                    <a href="#" class="block">janesmith</a>
                                </li>
                                <li class="p-2">
                                    <a href="#" class="block">hussar</a>
                                </li>
                                <li class="p-2">
                                    <a href="#" class="block">hanom</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <button type="button"
                    class="relative hidden w-12 h-12 bg-teal-400 rounded-full md:hidden place-items-center hover:bg-teal-500">
                    <MagnifyingGlassIcon class="w-6 h-6 text-white" />
                </button>
            </div>
        </div>
    </div>
</template>
