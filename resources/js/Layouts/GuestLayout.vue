<script setup>
import ApplicationLogo from '@/Components/Breeze/ApplicationLogo.vue'
import { Link } from '@inertiajs/vue3'
</script>

<template>
    <div class="flex flex-col items-center min-h-screen pt-6 bg-neutral-100 sm:justify-center sm:pt-0 dark:bg-neutral-900">
        <div>
            <Link href="/">
            <ApplicationLogo class="w-20 h-20 text-neutral-500 fill-current" />
            </Link>
        </div>

        <div class="w-full px-6 py-4 mt-6 overflow-hidden bg-white shadow-md sm:max-w-md dark:bg-neutral-800 sm:rounded-lg">
            <slot />
        </div>
    </div>
</template>
