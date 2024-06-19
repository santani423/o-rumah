<script setup>
import { Link } from '@inertiajs/vue3'
import { PhoneIcon } from '@heroicons/vue/24/solid'

const { agent } = defineProps({
    agent: Object,
})

const agentAvatar = agent.image ?? 'https://ui-avatars.com/api/?name=' + agent.name

const handlePhone = (phone) => {
    window.open(phone, '_blank')
}
</script>

<template>
    <div
        class="relative flex justify-between w-full p-4 gap-8 space-y-4 bg-white border rounded-xl border-neutral-300 focus-within:ring-1 focus-within:ring-neutral-500 hover:border-neutral-400">
        <div class="flex-1">
            <!-- User Info -->
            <div class="flex items-center space-x-5">
                <div class="flex-shrink-0">
                    <img class="w-20 h-20 rounded-full" :src="agentAvatar" :alt="agent.name"/>
                </div>
                <div class="flex-1 min-w-0 text-left">
                    <Link :href="route('agent-detail', agent.username)" class="focus:outline-none">
                        <p class="font-bold text-blue-900">{{ agent.name }}</p>
                        <p class="mt-1 text-sm truncate text-neutral-500">{{ agent.joined_at }}</p>
                    </Link>
                </div>
            </div>

            <!-- Contacts -->
            <div v-if="agent.phone || agent.wa_phone" class="flex flex-shrink-0 mt-4 space-x-2">
                <button v-if="agent.phone" type="button" @click.prevent="handlePhone(`tel:${agent.phone}`)"
                        class="inline-flex items-center gap-x-2 flex-1 justify-center rounded-md px-3.5 py-2.5 text-neutral-900 ring-1 ring-inset ring-neutral-200 hover:bg-neutral-100">
                    <PhoneIcon class="-ml-0.5 h-5 w-5" aria-hidden="true"/>
                    Telepon
                </button>
                <button v-if="agent.wa_phone" type="button" @click.prevent="handlePhone(`https://wa.me/${agent.phone}`)"
                        class="inline-flex items-center gap-x-2 flex-1 justify-center rounded-md bg-green-500 px-3.5 py-2.5 text-sm font-semibold text-white hover:bg-green-600">
                    <svg class="-ml-0.5 h-5 w-5 text-white fill-current" xmlns="http://www.w3.org/2000/svg" height="16"
                         width="14" viewBox="0 0 448 512">
                        <path
                            d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7 .9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/>
                    </svg>
                    WhatsApp
                </button>
            </div>
        </div>
        <div class="flex flex-1 space-x-2">
            <div v-if="agent.company_name" class="flex justify-center items-center px-4 py-3 space-x-4 bg-neutral-50 rounded-xl">
                <img class="aspect-square h-10 w-10 object-cover rounded-full" :src="agent.company_image" :alt="agent.company_name"/>
                <p class="flex-1 text-sm truncate">{{ agent.company_name }}</p>
            </div>
            <div class="flex flex-col justify-center items-center flex-1 p-3 space-y-2 bg-neutral-50 rounded-xl">
                <p class="text-xs truncate text-neutral-500">Total properti</p>
                <p class="text-sm font-bold text-blue-900">{{ agent.total_ads }}</p>
            </div>
            <div class="flex flex-col justify-center items-center flex-1 p-3 space-y-2 bg-neutral-50 rounded-xl">
                <p class="text-xs truncate text-neutral-500">Terjual / Tersewa</p>
                <p class="text-sm font-bold text-blue-900">{{ agent.total_sold }}</p>
            </div>
            <div class="flex flex-col justify-center items-center flex-1 p-3 space-y-2 bg-neutral-50 rounded-xl">
                <p class="text-xs truncate text-neutral-500">Harga rata-rata</p>
                <p class="text-sm font-bold text-blue-900">{{ agent.average_price }}</p>
            </div>
        </div>
    </div>
</template>
