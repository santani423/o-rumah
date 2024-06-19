<template>
    <div class="my-8 md:my-0">
        <h2 class="text-xl font-bold tracking-tight md:text-center text-neutral-900 sm:text-2xl">Mengapa Menggunakan
            ORumah?</h2>
        <div class="max-w-2xl mx-auto mt-6 md:mt-12 lg:max-w-none">
            <dl class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-8 md:gap-y-16 lg:max-w-none lg:grid-cols-3">
                <div v-for="feature in  features " :key="feature.name"
                    class="flex flex-col p-6 ring-1 ring-neutral-300 rounded-xl">
                    <dt class="text-base font-semibold leading-7 text-neutral-900">
                        <img :src="`/assets/features/${feature.icon}`" class="w-12 h-12 mb-4" aria-hidden="true" />
                        {{ feature.name }}
                    </dt>
                    <dd class="flex flex-col flex-auto mt-1 text-base leading-7 text-neutral-600">
                        <p class="flex-auto">{{ feature.description }}</p>
                    </dd>
                </div>
            </dl>
        </div>
    </div>
</template>

<script setup>
import { InboxIcon, TrashIcon, UsersIcon } from '@heroicons/vue/24/outline'

const features = [
    {
        name: 'Beli Properti Aman & Mudah',
        description:
            'ORumah sebagai situs properti terpercaya siap membantu menemukan hunian idaman Anda',
        icon: 'our-features-1.png',
    },
    {
        name: 'Kaya Fitur Pintar',
        description:
            'Tersedia 900 ribu iklan properti. Semua dapat Anda jelajah dan rencanakan memakai fitur pintar seperti Kalkulator KPR.',
        icon: 'our-features-2.png',
    },
    {
        name: 'Mitra Properti Terbaik',
        description:
            'ORumah adalah situs properti terbesar dan terpercaya yang telah melayani jutaan masyarakat Indonesia.',
        icon: 'our-features-3.png',
    },
]
</script>
