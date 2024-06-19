<script setup>
import { ref } from 'vue'
import {
    Listbox,
    ListboxButton,
    ListboxLabel,
    ListboxOption,
    ListboxOptions,
} from '@headlessui/vue'
import { CheckIcon, ChevronDownIcon } from '@heroicons/vue/20/solid'

const props = defineProps({
    options: Array,
    selectedOptions: Object,
})

const emit = defineEmits(['update:selectedOptions'])

const { options, selectedOptions } = props

const selected = ref(selectedOptions)
</script>

<template>
    <Listbox as="div"
             v-model="selected"
             @update:modelValue="emit('update:selectedOptions', selected)"
    >
        <div class="relative">
            <ListboxButton
                class="relative w-full cursor-default rounded-md bg-white py-2.5 pl-3 pr-10 text-left text-neutral-900 ring-1 ring-inset ring-neutral-300 focus:outline-none sm:text-sm sm:leading-6">
                <span class="flex items-center">
                    <img v-if="selected.avatar" :src="selected.avatar" alt=""
                         class="flex-shrink-0 w-5 h-5"/>
                    <span :class="selected.avatar ? 'ml-3' : ''"
                          class="block truncate">{{ selected.name }}</span>
                </span>
                <span
                    class="absolute inset-y-0 right-0 flex items-center px-2 ml-3 border pointer-events-none border-neutral-200 bg-zinc-100 rounded-br-md rounded-tr-md">
                    <ChevronDownIcon class="w-5 h-5 text-neutral-400"
                                     aria-hidden="true"/>
                </span>
            </ListboxButton>

            <transition leave-active-class="transition duration-100 ease-in"
                        leave-from-class="opacity-100"
                        leave-to-class="opacity-0">
                <ListboxOptions
                    class="absolute z-10 w-full py-1 mt-1 overflow-auto text-base bg-white rounded-md max-h-56 ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
                    <ListboxOption as="template" v-for="person in options"
                                   :key="person.id" :value="person"
                                   v-slot="{ active, selected }">
                        <li
                            :class="[active ? 'bg-neutral-600 text-white' : 'text-neutral-900', 'relative cursor-default select-none py-2 pl-3 pr-9']">
                            <div class="flex items-center">
                                <img v-if="person.avatar" :src="person.avatar"
                                     alt=""
                                     class="flex-shrink-0 w-5 h-5 rounded-full"/>
                                <div :class="person.avatar ? 'ml-3' : ''">
                                    <span
                                        :class="[selected ? 'font-semibold' : 'font-normal', 'block truncate']">{{
                                            person.name
                                        }}</span>
                                </div>
                            </div>

                            <span v-if="selected"
                                  :class="[active ? 'text-white' : 'text-neutral-600', 'absolute inset-y-0 right-0 flex items-center pr-4']">
                                <CheckIcon class="w-5 h-5" aria-hidden="true"/>
                            </span>
                        </li>
                    </ListboxOption>
                </ListboxOptions>
            </transition>
        </div>
    </Listbox>
</template>
