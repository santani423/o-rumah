<script setup>
import { Popover, PopoverButton, PopoverPanel } from '@headlessui/vue'
import { ChevronDownIcon } from '@heroicons/vue/20/solid'
import { useForm, router } from '@inertiajs/vue3'
import { computed } from 'vue'

const props = defineProps({
    'label': {
        type: String
    },
    'currentUrl': String,
    'minArea': String,
    'maxArea': String
})

defineEmits(['submit', 'reset', 'update:minArea', 'update:maxArea'])

const isAlreadyFiltered = computed(() => {
    return props.minArea !== '' || props.maxArea !== ''
})

</script>

<template>
    <div>
        <Popover v-slot="{ open }" class="relative">
            <PopoverButton :class="[open ? 'text-neutral-900' : 'text-neutral-900/90', isAlreadyFiltered && '!bg-teal-500 text-white !border !border-teal-500']"
                class="inline-flex items-center px-4 py-2 font-medium bg-white border rounded-full group focus:outline-none border-neutral-200">
                <span>{{ label }}</span>
                <ChevronDownIcon :class="[open ? 'text-neutral-900 transform rotate-180' : 'text-neutral-900/70', isAlreadyFiltered && 'text-white']"
                    class="w-5 h-5 ml-2 transition duration-150 ease-in-out group-hover:text-neutral-900/80"
                    aria-hidden="true" />
            </PopoverButton>

            <transition enter-active-class="transition duration-200 ease-out" enter-from-class="translate-y-1 opacity-0"
                enter-to-class="translate-y-0 opacity-100" leave-active-class="transition duration-150 ease-in"
                leave-from-class="translate-y-0 opacity-100" leave-to-class="translate-y-1 opacity-0">
                <PopoverPanel class="absolute left-0 z-10 px-4 mt-3 transform sm:px-0">
                    <div class="overflow-hidden rounded-lg shadow-lg ring-1 ring-black/5">
                        <div class="relative flex gap-4 p-4 bg-white">
                            <div class="relative">
                                <input autocomplete="off" type="text" name="q" id="q"
                                    class="p-4 pr-10 border-0 rounded-md ring-1 ring-inset ring-neutral-200 focus:ring-1 focus:ring-inset focus:ring-neutral-300 placeholder:text-neutral-400"
                                    placeholder="Min" :value="minArea" @input="$emit('update:minArea', $event.target.value)" />
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <span class="text-neutral-500">m<sup>2</sup></span>
                                </div>
                            </div>
                            <div class="relative">
                                <input autocomplete="off" type="text" name="q" id="q"
                                    class="p-4 pr-10 border-0 rounded-md ring-1 ring-inset ring-neutral-200 focus:ring-1 focus:ring-inset focus:ring-neutral-300 placeholder:text-neutral-400"
                                    placeholder="Maks" :value="maxArea" @input="$emit('update:maxArea', $event.target.value)"/>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <span class="text-neutral-500">m<sup>2</sup></span>
                                </div>
                            </div>
                        </div>
                        <div className="bg-white border-t border-neutral-200 p-4">
                            <div class="flex justify-end">
                                <div class="flex gap-4">
                                    <button type="button"
                                        @click="$emit('reset')"
                                        class="inline-flex items-center justify-center rounded-md bg-neutral-100 px-3.5 py-2.5 text-sm font-semibold text-neutral-900 hover:bg-neutral-200">
                                        Reset
                                    </button>
                                    <button type="button"
                                        @click="$emit('submit')"
                                        class="inline-flex items-center justify-center rounded-md bg-teal-500 px-3.5 py-2.5 text-sm font-semibold text-white hover:bg-teal-600">
                                        Terapkan Filter
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </PopoverPanel>
            </transition>
        </Popover>
    </div>
</template>
