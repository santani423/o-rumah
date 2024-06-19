<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    href: String,
});
</script>

<template>
    <Link :href="href" role="button" :class="`${$attrs.class}`">
    <slot />
    </Link>
</template>
