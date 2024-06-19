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
                            class="w-full overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl max-w-96">
                            <div class="p-6">
                                <div
                                    v-if="modalType === 'success'"
                                    class="w-12 h-12 mx-auto mb-3 text-center bg-green-100 rounded-full p-2">
                                    <CheckIcon class="text-green-600"/>
                                </div>
                                <div
                                    v-if="modalType === 'error'"
                                    class="w-12 h-12 mx-auto mb-3 text-center bg-red-100 rounded-full p-2">
                                    <XCircleIcon class="text-red-600"/>
                                </div>
                                <div v-if="modalType === 'success'">
                                    <p class="text-lg font-semibold text-center mb-3">Properti berhasil diperbaharui</p>
                                    <p class="text-sm font-normal text-center text-gray-500 mb-3">Selamat! properti anda sekarang sudah berhasil diperbaharui dan sedang tayang!</p>
                                </div>
                                <div v-if="modalType === 'error'">
                                    <p class="text-lg font-semibold text-center mb-3">Terjadi kesalahan</p>
                                    <p class="text-sm font-normal text-center text-gray-500 mb-3">Terjadi kesalahan, silakan cek inputan anda!</p>
                                </div>
                                <div class="flex flex-col">
                                    <button v-if="redirectUrl === '-'" @click="setIsOpen(false)" class="bg-teal-500 hover:bg-teal-600 cursor-pointer text-white py-2 px-4 rounded-full text-center">
                                        Kembali
                                    </button>
                                    <Link v-else :href="redirectUrl" class="bg-teal-500 hover:bg-teal-600 cursor-pointer text-white py-2 px-4 rounded-full text-center">
                                        Kembali
                                    </Link>
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
import { CheckIcon, XCircleIcon } from '@heroicons/vue/24/outline'
import { Link } from '@inertiajs/vue3'

// Define props
const { isOpen, modalType, redirectUrl } = defineProps({
    isOpen: Boolean,
    modalType: String,
    redirectUrl: {
        type: String,
        default: '-',
    }
})

// Define emits
const emit = defineEmits(['update:isOpen'])

function setIsOpen(value) {
    emit('update:isOpen', value)
}
</script>
