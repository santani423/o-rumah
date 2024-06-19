<script setup>
import { Link } from '@inertiajs/vue3'
import { ChevronRightIcon, HomeIcon } from '@heroicons/vue/20/solid'

const { pages } = defineProps({
    pages: {
        type: Array,
        default: () => [
            { name: 'Properti Baru', href: route('latest'), current: true },
        ]
    }
})
</script>

<template>
    <nav class="flex" aria-label="Breadcrumb">
        <ol role="list" class="flex items-center space-x-4">
            <li>
                <div>
                    <Link :href="route('home')" class="text-neutral-400 hover:text-neutral-500">
                        <HomeIcon class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
                        <span class="sr-only">Halaman Utama</span>
                    </Link>
                </div>
            </li>
            <li v-for="page in pages" :key="page.name">
                <div class="flex items-center">
                    <ChevronRightIcon class="flex-shrink-0 w-6 h-6 text-neutral-400" aria-hidden="true" />
                    <a :href="page.href" class="ml-4 font-medium text-neutral-500 hover:text-neutral-700"
                        :aria-current="page.current ? 'page' : undefined">{{ page.name }}</a>
                </div>
            </li>
        </ol>
    </nav>
</template>
