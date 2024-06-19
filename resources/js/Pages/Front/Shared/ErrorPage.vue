<script setup>
import { computed } from 'vue'
import { Head, Link } from '@inertiajs/vue3'

import FrontLayout from '@/Layouts/FrontLayout.vue'

const props = defineProps({ status: Number })

const title = computed(() => {
    return {
        503: '503',
        500: '500',
        404: '404',
        403: '403',
    }[props.status]
})

const description = computed(() => {
    return {
        503: 'Maaf kami sedang melakukan maintenance. Silahkan coba kembali nanti.',
        500: 'Terjadi kesalahan pada server. Silahkan coba kembali nanti.',
        404: 'Maaf halaman yang anda cari tidak ditemukan.',
        403: 'Maaf anda tidak diizinkan untuk mengakses halaman ini.',
    }[props.status]
})
</script>

<template>
    <div class="grid place-items-center h-[100dvh] bg-neutral-50">

        <Head title="Error" />

        <div class="px-4 mx-auto space-y-8 max-w-7xl sm:px-6 lg:px-8 md:my-12 md:space-y-12">
            <div
                class="inline-flex flex-col items-center justify-center w-full max-w-md gap-6 px-6 py-10 bg-white border border-neutral-200 rounded-3xl">
                <div class="flex flex-col items-center justify-center gap-3">
                    <div class="text-3xl font-bold text-teal-400">{{ title }}</div>
                    <div class="text-lg text-center text-neutral-500">
                        {{ description }}
                    </div>
                </div>
                <Link :href="route('home')" role="button"
                    class="rounded-md bg-teal-400 px-6 py-2.5 text-sm font-semibold text-white ring-1 ring-inset ring-teal-400 hover:bg-teal-300 hover:ring-teal-300 uppercase mx-4">
                Kembali ke Homepage
                </Link>
            </div>
        </div>
    </div>
</template>
