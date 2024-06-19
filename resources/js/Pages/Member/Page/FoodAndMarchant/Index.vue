<script setup>
import { Head } from "@inertiajs/vue3";

import ListingLayout from "@/Pages/Listing/components/ListingLayout.vue";
import { usePage } from "@inertiajs/vue3";

import DataPlans from "@/Pages/Member/Page/FoodAndMarchant/DataPans.vue";

const props = defineProps({ ads: Object, url: Object });
const user = usePage().props.auth.user;
</script>

<template>
    <ListingLayout>
        <Head title="Dashboard" />
        <div class="pb-36">
            <div class="flex items-center justify-between">
                <h4 class="text-lg font-bold">Dashboard</h4>
                <a
                    :href="route(url)"
                    class="bg-[#1CD6D0] text-white py-2 px-4 rounded-full"
                    >Pasang Iklan</a
                >
            </div>
            <div
                class="md:flex justify-between mt-5 border-green-600 border-[1px] bg-green-50 p-4 rounded-sm text-green-600"
            >
                <div class="flex items-center">
                    <svg
                        class="text-green-600 fill-current"
                        width="16"
                        height="16"
                        viewBox="0 0 16 16"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            fill-rule="evenodd"
                            clip-rule="evenodd"
                            d="M16 8C16 12.4183 12.4183 16 8 16C3.58172 16 0 12.4183 0 8C0 3.58172 3.58172 0 8 0C12.4183 0 16 3.58172 16 8ZM9 4C9 4.55228 8.55228 5 8 5C7.44772 5 7 4.55228 7 4C7 3.44772 7.44772 3 8 3C8.55228 3 9 3.44772 9 4ZM7 7C6.44772 7 6 7.44772 6 8C6 8.55229 6.44772 9 7 9V12C7 12.5523 7.44772 13 8 13H9C9.55228 13 10 12.5523 10 12C10 11.4477 9.55228 11 9 11V8C9 7.44772 8.55228 7 8 7H7Z"
                        />
                    </svg>
                    <p class="ml-3 text-sm">
                        Halo <span class="font-bold">{{ user.name }}</span
                        >, selamat datang di dashboard ORumah.
                    </p>
                </div>
            </div>
            <div class="my-5">
                <DataPlans :ads="props.ads" />
            </div>
        </div>
    </ListingLayout>
</template>
