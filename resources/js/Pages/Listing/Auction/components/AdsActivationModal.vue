<template>
    <TransitionRoot appear :show="isOpen" as="template">
        <Dialog as="div" @close="setIsOpen(false)" class="relative z-10">

            <TransitionChild as="template" enter="duration-300 ease-out"
                             enter-from="opacity-0" enter-to="opacity-100"
                             leave="duration-200 ease-in"
                             leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-black/25"/>
            </TransitionChild>

            <div class="fixed inset-0 overflow-y-auto">
                <div
                    class="flex items-center justify-center min-h-full p-4 text-center">
                    <TransitionChild as="template" enter="duration-300 ease-out"
                                     enter-from="opacity-0 scale-95"
                                     enter-to="opacity-100 scale-100"
                                     leave="duration-200 ease-in"
                                     leave-from="opacity-100 scale-100"
                                     leave-to="opacity-0 scale-95">

                        <DialogPanel
                            class="w-full overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl max-w-96">
                            <div class="p-6">
                                <div
                                    class="w-12 h-12 mx-auto mb-3 text-center bg-yellow-100 rounded-full p-2">
                                    <ExclamationTriangleIcon
                                        class="text-yellow-400"/>
                                </div>
                                <p class="text-lg font-semibold text-center mb-3">
                                    {{ title }}
                                </p>
                                <p class="text-sm font-normal text-center text-gray-500 mb-3">
                                    {{ subtitle }}
                                </p>
                                <div class="flex justify-start">
                                    <a @click="setIsOpen(false)"
                                       class="bg-gray-200 text-gray-600 py-2 px-4 rounded-full text-center w-full text-base font-bold mr-3 cursor-pointer">
                                        Kembali
                                    </a>
                                    <a @click="handleSubmit(ads.id)"
                                       class="bg-[#47C8C5] text-white py-2 px-4 rounded-full text-center w-full text-base font-bold cursor-pointer">
                                        Lanjutkan
                                    </a>
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
import { ExclamationTriangleIcon } from '@heroicons/vue/24/solid'

// Define props
const { ads, isOpen } = defineProps({
    ads: Object,
    isOpen: Boolean,
    title: String,
    subtitle: String,
})

// Define emits
const emit = defineEmits(['update:isOpen', 'update:handleSubmit'])

const handleSubmit = (adsId) => {
    emit('update:handleSubmit', adsId)
}

function setIsOpen (value) {
    emit('update:isOpen', value)
}
</script>
