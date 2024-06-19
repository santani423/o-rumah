<template>
    <TransitionRoot appear :show="isAlertOpen" as="template">
        <Dialog as="div" @close="setIsAlertOpen(false)" class="relative z-10">

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
                            class="w-full overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl max-w-96">
                            <div class="p-6">

                                <div v-if="modalType === 'success'" class="w-12 h-12 mx-auto mb-3 text-center bg-green-100 rounded-full p-2">
                                    <CheckIcon class="text-green-400"/>
                                </div>

                                <div v-if="modalType === 'error'" class="w-12 h-12 mx-auto mb-3 text-center bg-red-100 rounded-full p-2">
                                    <ExclamationTriangleIcon class="text-red-400"/>
                                </div>

                                <p class="text-lg font-semibold text-center mb-3">{{title}}</p>
                                <p class="text-sm font-normal text-center text-gray-500 mb-3">
                                    {{ subtitle }}
                                </p>
                                <div class="flex justify-start">
                                    <a @click="setIsAlertOpen(false)" class="bg-gray-200 text-gray-600 py-2 px-4 rounded-full text-center w-full text-base font-bold mr-3 cursor-pointer">
                                        Kembali
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
import { CheckIcon, ExclamationTriangleIcon } from '@heroicons/vue/24/solid'

// Define props
const { ads, isAlertOpen, modalType } = defineProps({
    ads: Object,
    isAlertOpen: Boolean,
    modalType: {
        type: String,
        default: 'success',
    },
    title: String,
    subtitle: String
})

// Define emits
const emit = defineEmits(['update:isAlertOpen'])

function setIsAlertOpen(value) {
    emit('update:isAlertOpen', value)
}
</script>
