<script setup>
import Navbar from "@/Components/Front/Base/Navbar.vue";
import Footer from "@/Components/Front/Base/Footer.vue";
import AdministatorSeedebar from "@/Components/Front/Base/AdministatorSeedebar.vue";
import MemberSeedebar from "@/Components/Front/Base/MemberSeedebar.vue";
import { usePage } from "@inertiajs/vue3";
import { Disclosure, DisclosureButton, DisclosurePanel } from "@headlessui/vue";
import {
    ChevronRightIcon,
    DocumentTextIcon,
    IdentificationIcon,
    Squares2X2Icon,
    UserCircleIcon,
    BuildingOffice2Icon,
} from "@heroicons/vue/24/solid";
import { computed } from "vue";

const user = usePage().props.auth.user;

const userType = computed(() => {
    switch (user.type) {
        case "agent":
            return "Agent";
        case "lbh":
            return "LBH";
        case "merchant":
            return "Food / Merchant";
        case "administrator":
            return "Administrator";
        default:
            return "User";
    }
});
</script>

<template>
    <!-- Disable on mobile -->
    <div class="fixed inset-0 z-40 bg-white xl:hidden" aria-hidden="true">
        <div class="grid h-full place-items-center">
            <div class="flex flex-col items-center space-y-4">
                <img
                    class="block w-auto h-12 xl:hidden"
                    src="/assets/logo.png"
                    alt="logo"
                />
                <h1 class="text-2xl">Mobile coming soon</h1>
            </div>
        </div>
    </div>

    <div class="flex flex-col flex-1">
        <Navbar />
        <div class="flex mt-16 min-h-[600px]">
            <div
                class="sidebar min-w-64 min-h-full pt-6 pb-20 border-r-[1px] border-[#D1D5DB]"
            >
                <div
                    class="pb-5 sm:px-4 lg:px-6 border-b-[1px] border-[#D1D5DB]"
                >
                    <div class="flex items-center justify-between mb-5">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gray-400 rounded-full">
                                <img
                                    class="object-cover rounded-full"
                                    :src="user.image"
                                    alt=""
                                />
                            </div>
                            <div class="ml-3">
                                <p
                                    class="text-base font-medium text-[#161616] mb-1"
                                >
                                    {{ user.name }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div
                        class="bg-[#EAEAEA] rounded-md px-3 py-3 mb-3 flex flex-col gap-4"
                    >
                        <div>
                            <p class="mb-1 text-xs font-normal text-gray-500">
                                Anggota Sejak
                            </p>
                            <p class="text-sm font-medium text-gray-900">
                                {{ user.formatted_created_at }}
                            </p>
                        </div>
                        <div>
                            <p class="mb-1 text-xs font-normal text-gray-500">
                                Tipe Akun
                            </p>
                            <p class="text-sm font-medium text-gray-900">
                                {{ userType }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mt-5 sm:px-4 lg:px-6">
                    <p class="mb-3 sm font-bold">Menu</p>
                    <template v-if="userType === 'Administrator'">
                        <AdministatorSeedebar class="hidden xl:block w-64" />
                    </template>
                    <template v-else>
                        <MemberSeedebar class="hidden xl:block w-64" />
                    </template>
                </div>
            </div>
            <div class="w-full mx-auto sm:p-6 lg:p-8">
                <slot />
            </div>
        </div>
        <Footer />
    </div>
</template>
