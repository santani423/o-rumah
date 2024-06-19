<script setup>
import { DisclosureButton, DisclosurePanel } from '@headlessui/vue'
import RightMenuMobileBeforeLogin from './RightMenuMobileBeforeLogin.vue';
</script>

<template>
    <!-- Mobile Menu -->
    <DisclosurePanel class="lg:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <!-- Current: "bg-cyan-50 border-cyan-500 text-cyan-700", Default: "border-transparent text-neutral-500 hover:bg-neutral-50 hover:border-neutral-300 hover:text-neutral-700" -->
            <DisclosureButton as="a" :href="route('latest')"
                class="block py-2 pl-3 pr-4 text-base font-medium border-l-4 text-cyan-700 border-cyan-500 bg-cyan-50">
                Properti Baru</DisclosureButton>
            <DisclosureButton as="a" :href="route('auction')"
                class="block py-2 pl-3 pr-4 text-base font-medium border-l-4 border-transparent text-neutral-500 hover:border-neutral-300 hover:bg-neutral-50 hover:text-neutral-700">
                Properti Lelang</DisclosureButton>
            <DisclosureButton as="a" :href="route('coming-soon')"
                class="block py-2 pl-3 pr-4 text-base font-medium border-l-4 border-transparent text-neutral-500 hover:border-neutral-300 hover:bg-neutral-50 hover:text-neutral-700">
                Tentang Kami</DisclosureButton>
        </div>
        <RightMenuMobileBeforeLogin />

    </DisclosurePanel>
</template>
