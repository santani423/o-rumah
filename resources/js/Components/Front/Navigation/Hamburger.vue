<script setup>
import { DisclosureButton } from '@headlessui/vue'
import { Bars3Icon, XMarkIcon } from '@heroicons/vue/24/outline'

defineProps({
    open: Boolean,
})
</script>

<template>
    <div class="flex items-center -mr-2 lg:hidden">
        <!-- Mobile menu button -->
        <DisclosureButton
            class="inline-flex items-center justify-center p-2 rounded-md text-neutral-400 hover:bg-neutral-100 hover:text-neutral-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-cyan-500">
            <span class="sr-only">Open main menu</span>
            <Bars3Icon v-if="!open" class="block w-6 h-6" aria-hidden="true" />
            <XMarkIcon v-else class="block w-6 h-6" aria-hidden="true" />
        </DisclosureButton>
    </div>
</template>
