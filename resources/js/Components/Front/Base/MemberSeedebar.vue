<script setup>
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
    <a
        :href="route('listing.index')"
        :class="[
            {
                'hover:bg-gray-50': !route().current('listing.index'),
            },
            'flex items-center w-full text-left rounded-md p-2 gap-x-3 text-sm leading-6 font-semibold text-gray-700 mb-3',
            {
                'text-white bg-[#1CD6D0]': route().current('listing.index'),
            },
        ]"
    >
        <Squares2X2Icon
            class="text-[#525252] h-6 w-6 shrink-0"
            :class="{
                'text-white': route().current('listing.index'),
            }"
            aria-hidden="true"
        />
        <p class="text-sm font-medium">Dashboard</p>
    </a>
    <a
        v-if="userType === 'Agent'"
        :href="route('member.lelang')"
        :class="[
            {
                'hover:bg-gray-50': !route().current('member.lelang'),
            },
            'flex items-center w-full text-left rounded-md p-2 gap-x-3 text-sm leading-6 font-semibold text-gray-700 mb-3',
            {
                'text-white bg-[#1CD6D0]': route().current('member.lelang'),
            },
        ]"
    >
        <BuildingOffice2Icon
            class="text-[#525252] h-6 w-6 shrink-0"
            :class="{
                'text-white': route().current('member.lelang'),
            }"
            aria-hidden="true"
        />
        <p class="text-sm font-medium">Lelang</p>
    </a>
    <a
        :href="route('member.plans')"
        :class="[
            {
                'hover:bg-gray-50': !route().current('member.plans'),
            },
            'flex items-center w-full text-left rounded-md p-2 gap-x-3 text-sm leading-6 font-semibold text-gray-700 mb-3',
            {
                'text-white bg-[#1CD6D0]': route().current('member.plans'),
            },
        ]"
    >
        <Squares2X2Icon
            class="text-[#525252] h-6 w-6 shrink-0"
            :class="{
                'text-white': route().current('member.plans'),
            }"
            aria-hidden="true"
        />
        <p class="text-sm font-medium">Member Plans</p>
    </a>
    <a
        :href="route('member.food')"
        :class="[
            {
                'hover:bg-gray-50': !route().current('member.food'),
            },
            'flex items-center w-full text-left rounded-md p-2 gap-x-3 text-sm leading-6 font-semibold text-gray-700 mb-3',
            {
                'text-white bg-[#1CD6D0]': route().current('member.food'),
            },
        ]"
    >
        <Squares2X2Icon
            class="text-[#525252] h-6 w-6 shrink-0"
            :class="{
                'text-white': route().current('member.food'),
            }"
            aria-hidden="true"
        />
        <p class="text-sm font-medium">Food</p>
    </a>
    <a
        :href="route('member.merchants')"
        :class="[
            {
                'hover:bg-gray-50': !route().current('member.merchants'),
            },
            'flex items-center w-full text-left rounded-md p-2 gap-x-3 text-sm leading-6 font-semibold text-gray-700 mb-3',
            {
                'text-white bg-[#1CD6D0]': route().current('member.merchants'),
            },
        ]"
    >
        <Squares2X2Icon
            class="text-[#525252] h-6 w-6 shrink-0"
            :class="{
                'text-white': route().current('member.merchants'),
            }"
            aria-hidden="true"
        />
        <p class="text-sm font-medium">Merchant</p>
    </a>
    <a
        :href="route('member.agen.kpr')"
        :class="[
            {
                'hover:bg-gray-50': !route().current('member.agen.kpr'),
            },
            'flex items-center w-full text-left rounded-md p-2 gap-x-3 text-sm leading-6 font-semibold text-gray-700 mb-3',
            {
                'text-white bg-[#1CD6D0]': route().current('member.agen.kpr'),
            },
        ]"
    >
        <Squares2X2Icon
            class="text-[#525252] h-6 w-6 shrink-0"
            :class="{
                'text-white': route().current('member.agen.kpr'),
            }"
            aria-hidden="true"
        />
        <p class="text-sm font-medium">Pengajuan KPR</p>
    </a>
    <a
        :href="route('member.transaksi')"
        :class="[
            {
                'hover:bg-gray-50': !route().current('member.transaksi'),
            },
            'flex items-center w-full text-left rounded-md p-2 gap-x-3 text-sm leading-6 font-semibold text-gray-700 mb-3',
            {
                'text-white bg-[#1CD6D0]': route().current('member.transaksi'),
            },
        ]"
    >
        <Squares2X2Icon
            class="text-[#525252] h-6 w-6 shrink-0"
            :class="{
                'text-white': route().current('member.transaksi'),
            }"
            aria-hidden="true"
        />
        <p class="text-sm font-medium">Riwayat Transaksi</p>
    </a>
</template>
