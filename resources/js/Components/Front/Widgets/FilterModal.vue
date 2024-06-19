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
                            class="w-full max-w-xl overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl">

                            <div class="flex items-center max-w-xl p-4">
                                <DialogTitle as="h3" class="ml-auto text-2xl font-bold text-center text-neutral-900">
                                    Filter Berdasarkan
                                </DialogTitle>
                                <!-- Transparent button with X icon -->
                                <button type="button"
                                    class="ml-auto text-sm font-semibold bg-white rounded-md text-neutral-900"
                                    @click="setIsOpen(true)">
                                    <XMarkIcon class="w-7 h-7" aria-hidden="true" />
                                </button>
                            </div>

                            <Divider />

                            <!-- Form -->
                            <div class="p-6">
                                <div class="flex flex-col space-y-6">
                                    <!-- Tipe Iklan -->
                                    <div class="flex flex-col space-y-2">
                                        <h6>Tipe Iklan</h6>
                                        <RadioGroup v-model="form.ads_type">
                                            <RadioGroupLabel class="sr-only">Tipe Iklan</RadioGroupLabel>
                                            <div class="flex gap-2">
                                                <RadioGroupOption as="template" v-for="adsType in adsTypes"
                                                    :key="adsType.id" :value="adsType.value" v-slot="{ active, checked }">
                                                    <div :class="[
                                                        active
                                                            ? 'bg-white'
                                                            : '',
                                                        checked ? 'bg-teal-500 border-teal-500 text-white' : 'bg-white ',
                                                    ]"
                                                        class="px-4 py-2 text-white border rounded-full cursor-pointer border-neutral-200 focus:outline-none focus:bg-teal-500">
                                                        <RadioGroupLabel as="p"
                                                            :class="checked ? 'text-white' : 'text-gray-900'"
                                                            class="font-medium">
                                                            {{ adsType.name }}
                                                        </RadioGroupLabel>
                                                    </div>
                                                </RadioGroupOption>
                                            </div>
                                        </RadioGroup>
                                    </div>

                                    <!-- Tipe Properti -->
                                    <div class="flex flex-col space-y-2">
                                        <h6>Tipe Properti</h6>
                                        <RadioGroup v-model="form.property_type">
                                            <RadioGroupLabel class="sr-only">Tipe Iklan</RadioGroupLabel>
                                            <div class="flex gap-2">
                                                <RadioGroupOption as="template" v-for="propertyType in propertyTypes"
                                                    :key="propertyType.id" :value="propertyType.value"
                                                    v-slot="{ active, checked }">
                                                    <div :class="[
                                                        active
                                                            ? 'bg-white'
                                                            : '',
                                                        checked ? 'bg-teal-500 border-teal-500 text-white ' : 'bg-white ',
                                                    ]"
                                                        class="px-4 py-2 text-white border rounded-full cursor-pointer border-neutral-200 focus:outline-none focus:bg-teal-500">
                                                        <RadioGroupLabel as="p"
                                                            :class="checked ? 'text-white' : 'text-gray-900'"
                                                            class="font-medium">
                                                            {{ propertyType.name }}
                                                        </RadioGroupLabel>
                                                    </div>
                                                </RadioGroupOption>
                                            </div>
                                        </RadioGroup>
                                    </div>

                                    <!-- Kisaran Harga -->
                                    <div class="flex flex-col space-y-2">
                                        <h6>Kisaran Harga</h6>
                                        <div class="flex gap-2 bg-white">
                                            <div class="relative flex-1">
                                                <div
                                                    class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                                    <span class="text-neutral-500">Rp</span>
                                                </div>
                                                <input autocomplete="off" type="text" name="q" id="q"
                                                    class="w-full p-2 pl-10 border-0 rounded-md ring-1 ring-inset ring-neutral-200 focus:ring-1 focus:ring-inset focus:ring-neutral-300 placeholder:text-neutral-400"
                                                    placeholder="Min" v-model="form.min_price" v-maska:[numberOptions] />
                                            </div>
                                            <div class="relative flex-1">
                                                <div
                                                    class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                                    <span class="text-neutral-500">Rp</span>
                                                </div>
                                                <input autocomplete="off" type="text" name="q" id="q"
                                                    class="w-full p-2 pl-10 border-0 rounded-md ring-1 ring-inset ring-neutral-200 focus:ring-1 focus:ring-inset focus:ring-neutral-300 placeholder:text-neutral-400"
                                                    placeholder="Maks" v-model="form.max_price" v-maska:[numberOptions] />
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Luas Tanah -->
                                    <div class="flex flex-col space-y-2">
                                        <h6>Luas Tanah</h6>
                                        <div class="flex gap-2 bg-white">
                                            <div class="relative flex-1">
                                                <input autocomplete="off" type="text" name="q" id="q"
                                                    class="w-full pl-3 pr-10 border-0 rounded-md ring-1 ring-inset ring-neutral-200 focus:ring-1 focus:ring-inset focus:ring-neutral-300 placeholder:text-neutral-400"
                                                    placeholder="Min" v-model="form.min_lt" />
                                                <div
                                                    class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                                    <span class="text-neutral-500">m<sup>2</sup></span>
                                                </div>
                                            </div>
                                            <div class="relative flex-1">
                                                <input autocomplete="off" type="text" name="q" id="q"
                                                    class="w-full pl-3 pr-10 border-0 rounded-md ring-1 ring-inset ring-neutral-200 focus:ring-1 focus:ring-inset focus:ring-neutral-300 placeholder:text-neutral-400"
                                                    placeholder="Maks" v-model="form.max_lt" />
                                                <div
                                                    class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                                    <span class="text-neutral-500">m<sup>2</sup></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Luas Bangunan -->
                                    <div class="flex flex-col space-y-2">
                                        <h6>Luas Bangunan</h6>
                                        <div class="flex gap-2 bg-white">
                                            <div class="relative flex-1">
                                                <input autocomplete="off" type="text" name="q" id="q"
                                                    class="w-full pl-3 pr-10 border-0 rounded-md ring-1 ring-inset ring-neutral-200 focus:ring-1 focus:ring-inset focus:ring-neutral-300 placeholder:text-neutral-400"
                                                    placeholder="Min" v-model="form.min_lb" />
                                                <div
                                                    class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                                    <span class="text-neutral-500">m<sup>2</sup></span>
                                                </div>
                                            </div>
                                            <div class="relative flex-1">
                                                <input autocomplete="off" type="text" name="q" id="q"
                                                    class="w-full pl-3 pr-10 border-0 rounded-md ring-1 ring-inset ring-neutral-200 focus:ring-1 focus:ring-inset focus:ring-neutral-300 placeholder:text-neutral-400"
                                                    placeholder="Maks" v-model="form.max_lb" />
                                                <div
                                                    class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                                    <span class="text-neutral-500">m<sup>2</sup></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Footer -->
                            <div className="bg-white border-t border-neutral-200 p-4">
                                <div class="flex justify-end">
                                    <div class="flex gap-4">
                                        <button type="button" @click="reset()"
                                            class="inline-flex items-center justify-center rounded-md bg-neutral-100 px-3.5 py-2.5 text-sm font-semibold text-neutral-900 hover:bg-neutral-200">
                                            Reset
                                        </button>
                                        <button type="button"
                                            class="inline-flex items-center justify-center rounded-md bg-teal-500 px-3.5 py-2.5 text-sm font-semibold text-white hover:bg-teal-600"
                                            @click="submit()">
                                            Terapkan Filter
                                        </button>
                                    </div>
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
    RadioGroup,
    RadioGroupLabel,
    RadioGroupOption,
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
} from '@headlessui/vue'
import { useForm, router } from '@inertiajs/vue3'
import { XMarkIcon } from '@heroicons/vue/24/outline'
import { DialogTitle } from '@headlessui/vue'
import Divider from '@/Components/Front/Base/Divider.vue';
import { vMaska } from 'maska'
import { numberOptions } from '@/lib/utils'

const emit = defineEmits(['update:isOpen', 'update:setTotalAlreadyFiltered'])

// Define props
const { isOpen, url } = defineProps({
    isOpen: Boolean,
    url: String
})

function setIsOpen(value) {
    emit('update:isOpen', value)
}

const adsTypes = [
    {
        value: 'jual',
        name: 'Dijual',
    },
    {
        value: 'sewa',
        name: 'Disewakan',
    },
]

const propertyTypes = [
    {
        id: 1,
        value: 'rumah',
        name: 'Rumah',
    },
    {
        id: 2,
        value: 'apartemen',
        name: 'Apartemen',
    },
    {
        id: 3,
        value: 'tanah',
        name: 'Tanah',
    },
]

// get query string data
const qs = new URLSearchParams(window.location.search)

const form = useForm({
    'ads_type': qs.get('ads_type') || '',
    'property_type': qs.get('property_type') || '',
    'min_price': qs.get('min_price') || '',
    'max_price': qs.get('max_price') || '',
    'min_lt': qs.get('min_lt') || '',
    'max_lt': qs.get('max_lt') || '',
    'min_lb': qs.get('min_lb') || '',
    'max_lb': qs.get('max_lb') || '',
})

const reset = () => {
    form.ads_type = ''
    form.property_type = ''
    form.min_price = ''
    form.max_price = ''
    form.min_lt = ''
    form.max_lt = ''
    form.min_lb = ''
    form.max_lb = ''

    submit()
}

const submit = () => {
    if (form.min_price) {
        form.min_price = form.min_price.replace(/,/g, '')
    }

    if (form.max_price) {
        form.max_price = form.max_price.replace(/,/g, '')
    }

    router.get(url, form.data(), { preserveState: true })

    emit('update:setTotalAlreadyFiltered')

    setIsOpen(false)
}
</script>
