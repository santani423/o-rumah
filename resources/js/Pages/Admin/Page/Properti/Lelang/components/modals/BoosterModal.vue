<template>
    <TransitionRoot appear :show="isOpen" as="template">
        <Dialog as="div" @close="setIsOpen(false)" class="relative z-10">
            <div class="fixed inset-0 overflow-y-auto">
                <div class="flex items-center justify-center min-h-full p-4 text-center">
                    <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0 scale-95"
                        enter-to="opacity-100 scale-100" leave="duration-200 ease-in" leave-from="opacity-100 scale-100"
                        leave-to="opacity-0 scale-95">

                        <DialogPanel
                            class="w-full max-w-md overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl">
                            <div class="flex items-center p-4">
                                <button v-if="currentStep == 'detail'" type="button"
                                    class="mr-auto text-lg font-semibold bg-white rounded-md text-neutral-900"
                                    @click="back()">
                                    <ArrowLeftIcon class="w-6 h-6" aria-hidden="true" />
                                </button>
                                <DialogTitle as="h3" class="text-lg font-semibold text-center text-neutral-900"
                                    :class="[currentStep == 'detail' ? 'mr-auto' : 'ml-auto']">
                                    {{ formattedTitle }}
                                </DialogTitle>
                                <!-- Transparent button with X icon -->
                                <button v-if="currentStep == 'list'" type="button"
                                    class="ml-auto text-lg font-semibold bg-white rounded-md text-neutral-900"
                                    @click="setIsOpen(true)">
                                    <XMarkIcon class="w-6 h-6" aria-hidden="true" />
                                </button>
                            </div>

                            <Divider />

                            <div class="p-6" v-if="currentStep == 'list'">
                                <div class="block mb-3 md:flex">
                                    <div class="md:w-28 h-28 rounded-xl">
                                        <img v-if="ads.media.length > 0" :src="ads.media[0].original_url" alt=""
                                            class="object-cover w-full h-full rounded-xl">
                                    </div>
                                    <div class="md:ml-3">
                                        <h5 class="text-lg font-bold text-[#2952A4]">Rp{{ ads.property.price }}</h5>
                                        <p class="my-1 text-base font-normal">{{ ads.title }}</p>
                                        <p class="text-[#7C7C7C] text-base mb-1">
                                            {{ ads.property.area }},
                                            <span class="capitalize">{{ ads.property.district_name.toLowerCase() }}</span>
                                        </p>
                                    </div>
                                </div>
                                <form>
                                    <div>
                                        <p class="mb-3 text-sm font-medium text-gray-700">Tipe Booster</p>

                                        <div v-for="booster in boosterList" :key="booster.id">
                                            <div class="border-[1px] border-gray-300 rounded-xl mb-3">
                                                <div class="flex items-center justify-between p-3">
                                                    <div class="flex items-center space-x-2">
                                                        <img :src="booster.image" alt="" class="w-4 h-4">
                                                        <p class="text-sm font-medium text-neutral-900">
                                                            {{ booster.name }}
                                                        </p>
                                                    </div>
                                                    <div class="flex items-center h-6">
                                                        <div class="mr-3 text-sm leading-6">
                                                            <label class="text-sm font-semibold text-neutral-900">
                                                                10 Kredit
                                                            </label>
                                                        </div>
                                                        <input id="sundul" name="tipe-booster" type="checkbox"
                                                            class="w-5 h-5 text-green-500 border-2 border-gray-500 rounded cursor-pointer focus:ring-transparent"
                                                            :value="booster.value" />
                                                    </div>
                                                </div>
                                                <div class="border-t-[1px] p-2 border-gray-300 bg-gray-100 rounded-b-xl cursor-pointer"
                                                    @click="openDetail(booster.name, booster.image, booster.desc)">
                                                    <div class="flex items-center justify-between">
                                                        <p class="text-sm font-medium text-gray-700">Pelajari Lebih Lanjut
                                                        </p>
                                                        <ChevronRightIcon :class="'w-5 h-5 text-gray-600'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex flex-col">
                                        <a @click="setIsOpen(false)"
                                            class="bg-[#1CD6D0] text-white py-2 px-4 rounded-full text-center">
                                            Aktifkan Booster
                                        </a>
                                    </div>
                                </form>
                            </div>

                            <div class="p-6" v-if="currentStep == 'detail'">
                                <div class="flex items-center mb-3 space-x-2">
                                    <img :src="detailImage" alt="" class="w-5 h-5">
                                    <p class="text-base font-bold text-neutral-900">{{ detailTitle }}</p>
                                </div>
                                <p class="text-base font-normal text-gray-500">
                                    {{ detailDesc }}
                                </p>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script setup>
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogTitle
} from '@headlessui/vue'
import { XMarkIcon, ChevronRightIcon, ArrowLeftIcon } from '@heroicons/vue/24/outline'
import Divider from '@/Components/Front/Base/Divider.vue'
import { ref, computed } from 'vue'

let currentStep = ref('list')
const boosterList = ref([
    {
        'name': 'Sundul',
        'value': 'sundul',
        'image': 'assets/icons/fire.png',
        'desc': 'Sundul merupakan salah satu fitur unggulan ORumah yang berguna untuk meningkatkan visibilitas listing properti Anda, agar lebih banyak dilirik calon pembeli.'
    },
    {
        'name': 'Landing Page',
        'value': 'landing_page',
        'image': 'assets/icons/ad_group.png',
        'desc': 'Landing Page merupakan salah satu fitur unggulan ORumah yang berguna untuk meningkatkan visibilitas listing properti Anda, agar dapat ditampilkan di halaman depan website ORumah.'
    },
    {
        'name': 'KPR',
        'value': 'kpr',
        'image': 'assets/icons/cottage.png',
        'desc': 'KPR merupakan salah satu fitur unggulan ORumah yang berguna untuk meningkatkan visibilitas listing properti Anda, agar lebih banyak dilirik calon pembeli.'
    }
])
let detailTitle = ref('')
let detailImage = ref('')
let detailDesc = ref('')

const formattedTitle = computed(() => {
    switch (currentStep.value) {
        case 'list':
            return 'Aktifkan Booster'
        case 'detail':
            return 'Detail Booster'
        default:
            break;
    }
})

// Define props
const { isOpen, ads } = defineProps({
    isOpen: Boolean,
    ads: Object,
})

// Define emits
const emit = defineEmits(['update:isOpen', 'update:booster'])

function openDetail(title, image, desc) {
    detailTitle.value = title
    detailImage.value = image
    detailDesc.value = desc
    currentStep.value = 'detail'
}

function back() {
    detailTitle.value = ''
    detailImage.value = ''
    detailDesc.value = ''
    currentStep.value = 'list'
}


function setIsOpen(value, ads) {
    emit('update:isOpen', [value, ads])
}
</script>
