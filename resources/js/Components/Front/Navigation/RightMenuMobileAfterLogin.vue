<script setup>
import { DisclosureButton } from '@headlessui/vue';
</script>

<template>
    <div class="pt-4 pb-3 border-t border-neutral-200">
        <div class="flex items-center px-4">
            <div class="flex-shrink-0">
                <img class="w-10 h-10 rounded-full"
                    src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                    alt="" />
            </div>
            <div class="ml-3">
                <div class="text-base font-medium text-neutral-800">Tom Cook</div>
                <div class="text-sm font-medium text-neutral-500">tom@example.com</div>
            </div>
            <button type="button"
                class="flex-shrink-0 p-1 ml-auto bg-white rounded-full text-neutral-400 hover:text-neutral-500 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2">
                <span class="sr-only">View notifications</span>
                <BellIcon class="w-6 h-6" aria-hidden="true" />
            </button>
        </div>
        <div class="mt-3 space-y-1">
            <DisclosureButton as="a" href="#"
                class="block px-4 py-2 text-base font-medium text-neutral-500 hover:bg-neutral-100 hover:text-neutral-800">
                Lihat Profil</DisclosureButton>
            <DisclosureButton as="a" href="#"
                class="block px-4 py-2 text-base font-medium text-neutral-500 hover:bg-neutral-100 hover:text-neutral-800">
                Pengaturan</DisclosureButton>
            <DisclosureButton as="a" href="#"
                class="block px-4 py-2 text-base font-medium text-neutral-500 hover:bg-neutral-100 hover:text-neutral-800">
                Keluar</DisclosureButton>
        </div>
    </div>
</template>
