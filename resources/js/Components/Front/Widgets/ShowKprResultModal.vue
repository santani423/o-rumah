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
                            class="w-full overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl max-w-4xl">
                            <div class="p-6">

                                <TableKprPayment :kpr-data="kprData" />

                                <div class="mt-8 flex flex-col">
                                    <a @click="setIsOpen(false)" class="bg-teal-500 hover:bg-teal-600 text-white py-2 px-4 rounded-md cursor-pointer text-center">
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
import TableKprPayment from '@/Components/Front/Widgets/TableKprPayment.vue'

// Define props
const { isOpen, kprData } = defineProps({
    isOpen: Boolean,
    kprData: Object
})

// Define emits
const emit = defineEmits(['update:isOpen'])


function setIsOpen(value) {
    emit('update:isOpen', value)
}
</script>
