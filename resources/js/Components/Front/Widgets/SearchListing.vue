<script setup>
import { computed, reactive, ref, watch, watchEffect } from 'vue'
import { useForm, router } from '@inertiajs/vue3'
import {
    AdjustmentsHorizontalIcon,
    MagnifyingGlassIcon,
} from '@heroicons/vue/20/solid'
import FilterPrice from '@/Components/Front/Widgets/FilterPrice.vue'
import FilterArea from '@/Components/Front/Widgets/FilterArea.vue'
import FilterModal from '@/Components/Front/Widgets/FilterModal.vue'
import DefaultButton from '@/Components/Front/Widgets/DefaultButton.vue'

const props = defineProps({
    isFullWidth: {
        type: Boolean,
        default: false,
    },
    hideFilter: {
        type: Boolean,
        default: false,
    },
    searchPlaceholder: {
        type: String,
        default: 'Cari berdasarkan daerah, kota, atau alamat',
    },
    currentUrl: String,
})

const emit = defineEmits(['update:isOpen'])

const isOpen = ref(false)
let filterCount = ref(0)

const qs = new URLSearchParams(window.location.search)

const defaultFormData = props.hideFilter ? {
    'query': qs.get('query') || '',
} : {
    'query': qs.get('query') || '',
    'min_price': qs.get('min_price') || '',
    'max_price': qs.get('max_price') || '',
    'min_lt': qs.get('min_lt') || '',
    'max_lt': qs.get('max_lt') || '',
    'min_lb': qs.get('min_lb') || '',
    'max_lb': qs.get('max_lb') || '',
}

const form = useForm(defaultFormData)

const filterData = () => {
    if (form.min_price) {
        form.min_price = form.min_price.replace(/,/g, '')
    }

    if (form.max_price) {
        form.max_price = form.max_price.replace(/,/g, '')
    }

    router.get(props.currentUrl, form.data(), { preserveState: true })
}

const resetPrice = () => {
    form.min_price = ''
    form.max_price = ''

    filterData()
}

const resetLt = () => {
    form.min_lt = ''
    form.max_lt = ''

    filterData()
}

const resetLb = () => {
    form.min_lb = ''
    form.max_lb = ''

    filterData()
}

const setIsOpen = (value) => {
    isOpen.value = value
}

const handleFiltered = () => {
    let filtered = 0

    // if qs contains ads_type, then add 1
    if (qs.get('ads_type') && qs.get('ads_type') !== '') {
        ++filtered
    }

    // if qs contains property_type, then add 1
    if (qs.get('property_type') && qs.get('property_type') !== '') {
        ++filtered
    }

    if ((qs.get('min_price') && qs.get('max_price')) && (qs.get('min_price') !== '' && qs.get('max_price') !== '')) {
        ++filtered
    }

    if ((qs.get('min_lt') && qs.get('max_lt')) && (qs.get('min_lt') !== '' && qs.get('max_lt') !== '')) {
        ++filtered
    }

    if ((qs.get('min_lb') && qs.get('max_lb')) && (qs.get('min_lb') !== '' && qs.get('max_lb') !== '')) {
        ++filtered
    }

    filterCount.value = filtered;
}

watchEffect(() => handleFiltered())
</script>

<template>
    <div class="flex px-4 mx-auto mt-8 divide-x max-w-7xl sm:px-6 lg:px-8">
        <div class="flex flex-col w-2/3 gap-4"
             :class="{ 'w-full': isFullWidth }">
            <!-- Text Search -->
            <div class="relative">
                <div class="flex items-center">
                    <input autocomplete="off" type="text" name="q" id="q"
                           class="w-full h-full p-4 border-0 rounded-full ring-1 ring-inset ring-neutral-200 focus:ring-1 focus:ring-inset focus:ring-neutral-300 placeholder:text-neutral-400"
                           :placeholder="searchPlaceholder" v-model="form.query"
                           @keydown.enter="filterData()"/>
                    <button type="button" @click="filterData()"
                            class="absolute inset-y-0 flex items-center justify-center w-10 h-10 bg-teal-400 rounded-full right-1.5 top-1.5 place-items-center hover:bg-teal-500">
                        <MagnifyingGlassIcon class="w-6 h-6 text-white"/>
                    </button>
                </div>
            </div>

            <div v-if="!hideFilter" class="flex gap-2">
                <DefaultButton
                    :class="filterCount > 0 && ['!border !border-teal-500 !bg-teal-500 text-white']"
                    @click="setIsOpen(true)">
                    Filter
                    <AdjustmentsHorizontalIcon
                        :class="filterCount > 0 && ['text-white']"
                        class="w-4 h-4 ml-2 text-neutral-900"
                        aria-hidden="true"/>
                </DefaultButton>
                <FilterPrice label="Harga" :current-url="currentUrl"
                             v-model:minPrice="form.min_price"
                             v-model:maxPrice="form.max_price"
                             @submit="filterData()" @reset="resetPrice()"/>
                <FilterArea label="Luas Tanah" :current-url="currentUrl"
                            v-model:minArea="form.min_lt"
                            v-model:maxArea="form.max_lt" @submit="filterData()"
                            @reset="resetLt()"/>
                <FilterArea label="Luas Bangunan" :current-url="currentUrl"
                            v-model:minArea="form.min_lb"
                            v-model:maxArea="form.max_lb" @submit="filterData()"
                            @reset="resetLb()"/>
            </div>
        </div>
        <FilterModal :is-open="isOpen"
                     @update:isOpen="setIsOpen(false)"
                     @update:setTotalAlreadyFiltered="handleFiltered"
                     :url="currentUrl"/>
    </div>
</template>
