<template>
    <TransitionRoot appear :show="isOpen" as="template">
        <Dialog as="div" @close="setIsOpen(false)" class="relative z-10">

            <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0" enter-to="opacity-100"
                leave="duration-200 ease-in" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-black/25" />
            </TransitionChild>

            <div class="fixed inset-0 overflow-y-auto">
                <div class="flex items-center justify-center min-h-full p-4 text-center">
                    <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0 scale-95"
                        enter-to="opacity-100 scale-100" leave="duration-200 ease-in" leave-from="opacity-100 scale-100"
                        leave-to="opacity-0 scale-95">

                        <DialogPanel
                            class="w-full max-w-md overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl">

                            <div class="flex items-center p-4 border border-b">
                                <DialogTitle as="h3" class="ml-auto text-2xl font-bold text-center text-neutral-900">
                                    Info LBH
                                </DialogTitle>
                                <!-- Transparent button with X icon -->
                                <button type="button" tabindex="-1"
                                    class="ml-auto text-sm font-semibold bg-white rounded-md text-neutral-900"
                                    @click="setIsOpen(false)">
                                    <XMarkIcon class="w-7 h-7" aria-hidden="true" />
                                </button>
                            </div>

                            <div class="flex flex-col gap-4 p-6">
                                <div class="flex items-center space-x-5">
                                    <div class="flex-shrink-0">
                                        <img class="w-20 h-20 rounded-full" :src="image" :alt="lbh.name" />
                                    </div>
                                    <div class="flex-1 min-w-0 text-left">
                                        <a href="#" @click="setIsOpen(true)" class="focus:outline-none">
                                            <p class="font-bold text-blue-900">
                                                {{ lbh.name }}</p>
                                            <p class="mt-1 text-sm truncate text-neutral-500">
                                                {{ lbh.joined_at }}</p>
                                        </a>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-neutral-500">
                                        {{ lbh.bio }}
                                    </p>
                                </div>
                                <div v-if="lbh.company_name" class="flex-shrink-0">
                                    <div class="flex items-center px-4 py-3 space-x-4 bg-neutral-50 rounded-xl">
                                        <img class="object-cover w-10 h-10 rounded-full aspect-square"
                                            :src="lbh.company_image" :alt="lbh.company_name" />
                                        <p class="flex-1 text-sm truncate">
                                            {{ lbh.company_name }}</p>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-2">
                                    <button v-if="lbh.phone" type="button"
                                        @click.prevent="handlePhone(`tel:${lbh.phone}`)"
                                        class="inline-flex items-center gap-x-2 flex-1 justify-center rounded-md px-3.5 py-2.5 text-neutral-900 ring-1 ring-inset ring-neutral-200 hover:bg-neutral-100">
                                        <PhoneIcon class="-ml-0.5 h-5 w-5" aria-hidden="true" />
                                        Telepon
                                    </button>
                                    <button v-if="lbh.wa_phone" type="button"
                                        @click.prevent="handlePhone(`https://wa.me/${lbh.wa_phone}`)"
                                        class="inline-flex items-center gap-x-2 flex-1 justify-center rounded-md bg-green-500 px-3.5 py-2.5 text-sm font-semibold text-white hover:bg-green-600">
                                        <svg class="-ml-0.5 h-5 w-5 text-white fill-current"
                                            xmlns="http://www.w3.org/2000/svg" height="16" width="14"
                                            viewBox="0 0 448 512">
                                            <path
                                                d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7 .9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z" />
                                        </svg>
                                        WhatsApp
                                    </button>
                                </div>
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
} from '@headlessui/vue'
import { PhoneIcon } from '@heroicons/vue/24/solid'
import { XMarkIcon } from '@heroicons/vue/24/outline'
import { computed } from 'vue'

// Define props
const { isOpen, lbh } = defineProps({
    isOpen: Boolean,
    lbh: Object,
})

// Define emits
const emit = defineEmits(['update:isOpen'])

function setIsOpen(value) {
    emit('update:isOpen', value)
}

const image = computed(() => {
    return lbh.image ? lbh.image : 'https://via.placeholder.com/100'
})

const handlePhone = (phone) => {
    window.open(phone, '_blank')
}
</script>