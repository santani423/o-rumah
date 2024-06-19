<script setup>
import { computed, ref } from 'vue'
import NotarisDetailModal from '@/Components/Front/Modal/NotarisDetailModal.vue'

const props = defineProps({
    notaris: Object,
    showStats: {
        type: Boolean,
        default: true
    },
})

const isOpen = ref(false)

const setIsOpen = (value) => {
    isOpen.value = value
}

const image = computed(() => {
    return props.notaris.image ? props.notaris.image : 'https://via.placeholder.com/100'
})
</script>

<template>
    <div
        class="relative w-full p-4 space-y-4 bg-white border rounded-xl border-neutral-300 focus-within:ring-1 focus-within:ring-neutral-500 hover:border-neutral-400">
        <div class="flex items-center space-x-5">
            <div class="flex-shrink-0">
                <img class="w-20 h-20 rounded-full" :src="image" :alt="notaris.name" />
            </div>
            <div class="flex-1 min-w-0 text-left">
                <a href="#" @click="setIsOpen(true)" class="focus:outline-none">
                    <p class="font-bold text-blue-900">{{ notaris.name }}</p>
                    <p class="mt-1 text-sm truncate text-neutral-500">{{ notaris.joined_at }}</p>
                </a>
            </div>
        </div>
        <div v-if="notaris.company_name" class="flex-shrink-0">
            <div class="flex items-center px-4 py-3 space-x-4 bg-neutral-50 rounded-xl">
                <img class="aspect-square h-10 w-10 rounded-full" :src="notaris.company_image" :alt="notaris.company_name" />
                <p class="flex-1 text-sm truncate">{{ notaris.company_name }}</p>
            </div>
        </div>
        <div v-if="showStats" class="flex flex-shrink-0 space-x-2">
            <div class="flex flex-col items-center flex-1 p-3 space-y-2 bg-neutral-50 rounded-xl">
                <p class="text-xs truncate text-neutral-500">Total properti</p>
                <p class="text-sm font-bold text-blue-900">{{ notaris.total_ads }}</p>
            </div>
            <div class="flex flex-col items-center flex-1 p-3 space-y-2 bg-neutral-50 rounded-xl">
                <p class="text-xs truncate text-neutral-500">Terjual / Tersewa</p>
                <p class="text-sm font-bold text-blue-900">{{ notaris.total_sold }}</p>
            </div>
            <div class="flex flex-col items-center flex-1 p-3 space-y-2 bg-neutral-50 rounded-xl">
                <p class="text-xs truncate text-neutral-500">Harga rata-rata</p>
                <p class="text-sm font-bold text-blue-900">{{ notaris.average_price }}</p>
            </div>
        </div>
    </div>
    <NotarisDetailModal :isOpen="isOpen" :notaris="notaris" @update:isOpen="setIsOpen" />
</template>
