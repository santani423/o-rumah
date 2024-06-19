<script setup>
import { Head, Link } from "@inertiajs/vue3";

import FrontLayout from "@/Layouts/FrontLayout.vue";
import ComingSoonIcon from "@/Components/Front/Icon/ComingSoonIcon.vue";
</script>

<template>
    <FrontLayout>
        <Head title="Coming Soon" />

        <div
            class="grid px-4 mx-auto my-8 space-y-8 max-w-7xl sm:px-6 lg:px-8 md:my-12 md:space-y-12 place-items-center"
        >
            <div
                class="inline-flex flex-col items-center justify-center w-full max-w-md gap-6 px-6 py-10 bg-white border border-neutral-200 rounded-3xl"
            >
                <div class="flex flex-col items-center justify-center gap-3">
                    <ComingSoonIcon />
                    <div class="text-3xl font-bold text-teal-400">
                        Coming Soon
                    </div>
                    <div class="text-lg text-center text-neutral-500">
                        Ups, fitur ini masih dalam pengembangan. Silahkan
                        kembali lagi nanti
                    </div>
                </div>
                <Link
                    :href="route('home')"
                    role="button"
                    class="rounded-md bg-teal-400 px-6 py-2.5 text-sm font-semibold text-white ring-1 ring-inset ring-teal-400 hover:bg-teal-300 hover:ring-teal-300 uppercase mx-4"
                >
                    Kembali ke Homepage
                </Link>
            </div>
        </div>
    </FrontLayout>
</template>
