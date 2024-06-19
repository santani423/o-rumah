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
</script>

<template>
    <a
        href="#"
        :class="[
            'hover:bg-gray-50',
            'flex items-center w-full text-left rounded-md p-2 gap-x-3 text-sm leading-6 font-semibold text-gray-700 mb-3',
        ]"
    >
        <UserCircleIcon
            class="text-[#525252] h-6 w-6 shrink-0"
            aria-hidden="true"
        />
        <p class="text-sm font-medium">Dashboard</p>
    </a>
    <Disclosure as="div" :class="['mb-3']" v-slot="{ open }">
        <DisclosureButton
            :class="[
                'hover:bg-gray-50',
                'flex items-center w-full text-left rounded-md p-2 gap-x-3 text-sm leading-6 font-semibold text-gray-700',
            ]"
        >
            <IdentificationIcon
                class="text-[#525252] h-6 w-6 shrink-0"
                aria-hidden="true"
            />
            <p class="text-sm font-medium">Bisnis</p>
            <ChevronRightIcon
                :class="[
                    open ? 'rotate-90 text-gray-500' : 'text-gray-400',
                    'ml-auto h-5 w-5 shrink-0',
                ]"
                aria-hidden="true"
            />
        </DisclosureButton>
        <DisclosurePanel as="ul" class="px-2 mt-1">
            <li>
                <DisclosureButton
                    as="a"
                    :href="route('admin.nav.properti')"
                    :class="[
                        'hover:bg-gray-50',
                        'block rounded-md py-2 pr-2 pl-9 text-sm leading-6 text-gray-700',
                    ]"
                    >Properti</DisclosureButton
                >
                <DisclosureButton
                    as="a"
                    :href="route('admin.nav.lelang')"
                    :class="[
                        'hover:bg-gray-50',
                        'block rounded-md py-2 pr-2 pl-9 text-sm leading-6 text-gray-700',
                    ]"
                    >Lelang</DisclosureButton
                >
                <DisclosureButton
                    as="a"
                    :href="route('admin.nav.o-food')"
                    :class="[
                        'hover:bg-gray-50',
                        'block rounded-md py-2 pr-2 pl-9 text-sm leading-6 text-gray-700',
                    ]"
                    >Ofood</DisclosureButton
                >
                <DisclosureButton
                    as="a"
                    :href="route('admin.nav.o-merchant')"
                    :class="[
                        'hover:bg-gray-50',
                        'block rounded-md py-2 pr-2 pl-9 text-sm leading-6 text-gray-700',
                    ]"
                    >OMearchant</DisclosureButton
                >
            </li>
        </DisclosurePanel>
    </Disclosure>
    <Disclosure as="div" :class="['mb-3']" v-slot="{ open }">
        <DisclosureButton
            :class="[
                'hover:bg-gray-50',
                'flex items-center w-full text-left rounded-md p-2 gap-x-3 text-sm leading-6 font-semibold text-gray-700',
            ]"
        >
            <DocumentTextIcon
                class="text-[#525252] h-6 w-6 shrink-0"
                aria-hidden="true"
            />
            <p class="text-sm font-medium">Pengajuan</p>
            <ChevronRightIcon
                :class="[
                    open ? 'rotate-90 text-gray-500' : 'text-gray-400',
                    'ml-auto h-5 w-5 shrink-0',
                ]"
                aria-hidden="true"
            />
        </DisclosureButton>
        <DisclosurePanel as="ul" class="px-2 mt-1">
            <li>
                <DisclosureButton
                    as="a"
                    :href="route('admin.pengajuan.kpr')"
                    :class="[
                        'hover:bg-gray-50',
                        'block rounded-md py-2 pr-2 pl-9 text-sm leading-6 text-gray-700',
                    ]"
                    >KPR</DisclosureButton
                >
            </li>
        </DisclosurePanel>
    </Disclosure>
    <Disclosure as="div" :class="['mb-3']" v-slot="{ open }">
        <DisclosureButton
            :class="[
                'hover:bg-gray-50',
                'flex items-center w-full text-left rounded-md p-2 gap-x-3 text-sm leading-6 font-semibold text-gray-700',
            ]"
        >
            <DocumentTextIcon
                class="text-[#525252] h-6 w-6 shrink-0"
                aria-hidden="true"
            />
            <p class="text-sm font-medium">Master Data</p>
            <ChevronRightIcon
                :class="[
                    open ? 'rotate-90 text-gray-500' : 'text-gray-400',
                    'ml-auto h-5 w-5 shrink-0',
                ]"
                aria-hidden="true"
            />
        </DisclosureButton>
        <DisclosurePanel as="ul" class="px-2 mt-1">
            <li>
                <DisclosureButton
                    as="a"
                    :href="route('admin.nav.ads.control-panel')"
                    :class="[
                        'hover:bg-gray-50',
                        'block rounded-md py-2 pr-2 pl-9 text-sm leading-6 text-gray-700',
                    ]"
                    >Ads Control
                </DisclosureButton>
                <DisclosureButton
                    as="a"
                    :href="route('admin.nav.bank')"
                    :class="[
                        'hover:bg-gray-50',
                        'block rounded-md py-2 pr-2 pl-9 text-sm leading-6 text-gray-700',
                    ]"
                    >Bank</DisclosureButton
                >
                <DisclosureButton
                    as="a"
                    :href="route('admin.nav.pengguna')"
                    :class="[
                        'hover:bg-gray-50',
                        'block rounded-md py-2 pr-2 pl-9 text-sm leading-6 text-gray-700',
                    ]"
                    >Pengguna</DisclosureButton
                >
                <DisclosureButton
                    as="a"
                    :href="route('admin.nav.tipe-properti')"
                    :class="[
                        'hover:bg-gray-50',
                        'block rounded-md py-2 pr-2 pl-9 text-sm leading-6 text-gray-700',
                    ]"
                    >Tipe Properti</DisclosureButton
                >
                <DisclosureButton
                    as="a"
                    :href="route('admin.nav.districts')"
                    :class="[
                        'hover:bg-gray-50',
                        'block rounded-md py-2 pr-2 pl-9 text-sm leading-6 text-gray-700',
                    ]"
                    >Kecamatan</DisclosureButton
                >
                <DisclosureButton
                    as="a"
                    :href="route('admin.nav.citie')"
                    :class="[
                        'hover:bg-gray-50',
                        'block rounded-md py-2 pr-2 pl-9 text-sm leading-6 text-gray-700',
                    ]"
                    >Kota</DisclosureButton
                >
                <DisclosureButton
                    as="a"
                    :href="route('admin.nav.provinces')"
                    :class="[
                        'hover:bg-gray-50',
                        'block rounded-md py-2 pr-2 pl-9 text-sm leading-6 text-gray-700',
                    ]"
                    >Provinsi</DisclosureButton
                >
            </li>
        </DisclosurePanel>
    </Disclosure>
    <Disclosure as="div" :class="['mb-3']" v-slot="{ open }">
        <DisclosureButton
            :class="[
                'hover:bg-gray-50',
                'flex items-center w-full text-left rounded-md p-2 gap-x-3 text-sm leading-6 font-semibold text-gray-700',
            ]"
        >
            <DocumentTextIcon
                class="text-[#525252] h-6 w-6 shrink-0"
                aria-hidden="true"
            />
            <p class="text-sm font-medium">Konten Website</p>
            <ChevronRightIcon
                :class="[
                    open ? 'rotate-90 text-gray-500' : 'text-gray-400',
                    'ml-auto h-5 w-5 shrink-0',
                ]"
                aria-hidden="true"
            />
        </DisclosureButton>
        <DisclosurePanel as="ul" class="px-2 mt-1">
            <li>
                <DisclosureButton
                    as="a"
                    :href="route('admin.nav.banner')"
                    :class="[
                        'hover:bg-gray-50',
                        'block rounded-md py-2 pr-2 pl-9 text-sm leading-6 text-gray-700',
                    ]"
                    >Banner</DisclosureButton
                >
                <DisclosureButton
                    as="a"
                    :href="route('admin.nav.plans')"
                    :class="[
                        'hover:bg-gray-50',
                        'block rounded-md py-2 pr-2 pl-9 text-sm leading-6 text-gray-700',
                    ]"
                    >Level</DisclosureButton
                >
                <DisclosureButton
                    as="a"
                    :href="route('admin.nav.websiteAdsSections')"
                    :class="[
                        'hover:bg-gray-50',
                        'block rounded-md py-2 pr-2 pl-9 text-sm leading-6 text-gray-700',
                    ]"
                    >Kolom Iklan</DisclosureButton
                >
                <DisclosureButton
                    as="a"
                    :href="route('admin.nav.settings')"
                    :class="[
                        'hover:bg-gray-50',
                        'block rounded-md py-2 pr-2 pl-9 text-sm leading-6 text-gray-700',
                    ]"
                    >Pengaturan</DisclosureButton
                >
            </li>
        </DisclosurePanel>
    </Disclosure>
    <Disclosure as="div" :class="['mb-3']" v-slot="{ open }">
        <DisclosureButton
            :class="[
                'hover:bg-gray-50',
                'flex items-center w-full text-left rounded-md p-2 gap-x-3 text-sm leading-6 font-semibold text-gray-700',
            ]"
        >
            <DocumentTextIcon
                class="text-[#525252] h-6 w-6 shrink-0"
                aria-hidden="true"
            />
            <p class="text-sm font-medium">Transaksi</p>
            <ChevronRightIcon
                :class="[
                    open ? 'rotate-90 text-gray-500' : 'text-gray-400',
                    'ml-auto h-5 w-5 shrink-0',
                ]"
                aria-hidden="true"
            />
        </DisclosureButton>
        <DisclosurePanel as="ul" class="px-2 mt-1">
            <li>
                <DisclosureButton
                    as="a"
                    :href="route('admin.nav.transaksi.panding')"
                    :class="[
                        'hover:bg-gray-50',
                        'block rounded-md py-2 pr-2 pl-9 text-sm leading-6 text-gray-700',
                    ]"
                    >Pending</DisclosureButton
                >
                <DisclosureButton
                    as="a"
                    :href="route('admin.nav.plans')"
                    :class="[
                        'hover:bg-gray-50',
                        'block rounded-md py-2 pr-2 pl-9 text-sm leading-6 text-gray-700',
                    ]"
                    >Level</DisclosureButton
                >
                <DisclosureButton
                    as="a"
                    :href="route('admin.nav.websiteAdsSections')"
                    :class="[
                        'hover:bg-gray-50',
                        'block rounded-md py-2 pr-2 pl-9 text-sm leading-6 text-gray-700',
                    ]"
                    >Kolom Iklan</DisclosureButton
                >
                <DisclosureButton
                    as="a"
                    :href="route('admin.nav.settings')"
                    :class="[
                        'hover:bg-gray-50',
                        'block rounded-md py-2 pr-2 pl-9 text-sm leading-6 text-gray-700',
                    ]"
                    >Pengaturan</DisclosureButton
                >
            </li>
        </DisclosurePanel>
    </Disclosure>
    <Disclosure as="div" :class="['mb-3']" v-slot="{ open }">
        <DisclosureButton
            :class="[
                'hover:bg-gray-50',
                'flex items-center w-full text-left rounded-md p-2 gap-x-3 text-sm leading-6 font-semibold text-gray-700',
            ]"
        >
            <DocumentTextIcon
                class="text-[#525252] h-6 w-6 shrink-0"
                aria-hidden="true"
            />
            <p class="text-sm font-medium">Transaksi</p>
            <ChevronRightIcon
                :class="[
                    open ? 'rotate-90 text-gray-500' : 'text-gray-400',
                    'ml-auto h-5 w-5 shrink-0',
                ]"
                aria-hidden="true"
            />
        </DisclosureButton>
        <DisclosurePanel as="ul" class="px-2 mt-1">
            <li>
                <DisclosureButton
                    as="a"
                    :href="route('admin.transaksi.panding')"
                    :class="[
                        'hover:bg-gray-50',
                        'block rounded-md py-2 pr-2 pl-9 text-sm leading-6 text-gray-700',
                    ]"
                    >Pending</DisclosureButton
                >
                <DisclosureButton
                    as="a"
                    :href="route('admin.nav.transaksi.processing')"
                    :class="[
                        'hover:bg-gray-50',
                        'block rounded-md py-2 pr-2 pl-9 text-sm leading-6 text-gray-700',
                    ]"
                    >Processing</DisclosureButton
                >
                <DisclosureButton
                    as="a"
                    :href="route('admin.nav.transaksi.success')"
                    :class="[
                        'hover:bg-gray-50',
                        'block rounded-md py-2 pr-2 pl-9 text-sm leading-6 text-gray-700',
                    ]"
                    >Success</DisclosureButton
                >
                <DisclosureButton
                    as="a"
                    :href="route('admin.nav.transaksi.canceled')"
                    :class="[
                        'hover:bg-gray-50',
                        'block rounded-md py-2 pr-2 pl-9 text-sm leading-6 text-gray-700',
                    ]"
                    >Canceled</DisclosureButton
                >
            </li>
        </DisclosurePanel>
    </Disclosure>
</template>
