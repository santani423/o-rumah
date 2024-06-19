<script setup>
import { Link } from '@inertiajs/vue3';
import PropertyIcon from '../Icon/PropertyIcon.vue';
import AuctionIcon from '../Icon/AuctionIcon.vue';
import OFoodsIcon from '../Icon/OFoodsIcon.vue';
import OMerchantIcon from '../Icon/OMerchantIcon.vue';
import LawHelperIcon from '../Icon/LawHelperIcon.vue';
import NotarisIcon from '../Icon/NotarisIcon.vue';
import AgentIcon from '../Icon/AgentIcon.vue';
import OtherMenuIcon from '../Icon/OtherMenuIcon.vue';
</script>

<template>
    <ul class="menu-list">
        <li class="flex-1">
            <Link :href="route('latest')">
            <div class="flex flex-col items-center px-4 py-6 space-y-4 bg-white menu-item">
                <PropertyIcon class="w-7 h-7" />
                <h6 class="text-sm">Carikan Properti</h6>
            </div>
            </Link>
        </li>
        <li class="flex-1">
            <Link :href="route('auction')">
            <div class="flex flex-col items-center px-4 py-6 space-y-4 bg-white menu-item">
                <AuctionIcon class="w-7 h-7" />
                <h6 class="text-sm">Properti Lelang</h6>
            </div>
            </Link>
        </li>
        <li class="flex-1">
            <Link :href="route('ofoods')">
            <div class="flex flex-col items-center px-4 py-6 space-y-4 bg-white menu-item">
                <OFoodsIcon class="w-7 h-7" />
                <h6 class="text-sm">OFoods</h6>
            </div>
            </Link>
        </li>
        <li class="flex-1">
            <Link :href="route('omerchant')">
            <div class="flex flex-col items-center px-4 py-6 space-y-4 bg-white menu-item">
                <OMerchantIcon class="w-7 h-7" />
                <h6 class="text-sm">OMerchant</h6>
            </div>
            </Link>
        </li>
        <li class="flex-1">
            <a :href="route('law-helper')">
                <div class="flex flex-col items-center px-4 py-6 space-y-4 bg-white menu-item">
                    <LawHelperIcon class="w-7 h-7" />
                    <h6 class="text-sm">Cari LBH</h6>
                </div>
            </a>
        </li>
        <li class="flex-1">
            <a :href="route('notaris')">
                <div class="flex flex-col items-center px-4 py-6 space-y-4 bg-white menu-item">
                    <NotarisIcon class="w-7 h-7" />
                    <h6 class="text-sm">Cari Notaris</h6>
                </div>
            </a>
        </li>
        <li class="flex-1">
            <a :href="route('agent')">
                <div class="flex flex-col items-center px-4 py-6 space-y-4 bg-white menu-item">
                    <AgentIcon class="w-7 h-7" />
                    <h6 class="text-sm">Cari Agen</h6>
                </div>
            </a>
        </li>
        <li class="flex-1">
            <a :href="route('coming-soon')">
                <div class="flex flex-col items-center px-4 py-6 space-y-4 bg-white menu-item">
                    <OtherMenuIcon class="w-7 h-7" />
                    <h6 class="text-sm">Lainnya</h6>
                </div>
            </a>
        </li>
    </ul>
</template>

<style scoped>
.menu-list {
    @apply grid grid-cols-4 md:flex md:flex-wrap text-center;
}

.menu-list .menu-item {
    @apply hover:text-neutral-700 hover:bg-neutral-50 h-full border border-neutral-100;
}

.menu-list li:first-child .menu-item {
    @apply rounded-tl-2xl md:rounded-bl-2xl;
}

.menu-list li:nth-child(4) .menu-item {
    @apply rounded-tr-2xl md:rounded-none;
}

.menu-list li:nth-child(5) .menu-item {
    @apply rounded-bl-2xl md:rounded-none;
}

.menu-list li:last-child .menu-item {
    @apply rounded-br-2xl md:rounded-tr-2xl;
}
</style>