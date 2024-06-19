<template>
    <div v-if="links.length > 3">
        <div class="flex flex-wrap justify-center">
            <template v-for="(link, key) in links">
                <div v-if="link.url === null" :key="key"
                    class="px-4 py-3 mb-1 mr-1 text-sm leading-4 rounded text-neutral-400" v-html="link.label" />
                <Link v-else :key="`link-${key}`"
                    class="px-4 py-3 mb-1 mr-1 text-sm leading-4 focus:text-neutral-500 hover:bg-white focus:border-neutral-500"
                    :class="{ 'border-b-2 border-teal-500': link.active }" :href="link.url" v-html="link.label" />
            </template>
        </div>
    </div>
</template>

<script>
import { Link } from '@inertiajs/vue3'

export default {
    components: {
        Link,
    },
    props: {
        links: Array,
    },
}
</script>
