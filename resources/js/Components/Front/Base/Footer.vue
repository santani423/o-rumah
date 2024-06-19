<template>
    <footer class="bg-neutral-700" aria-labelledby="footer-heading">
        <h2 id="footer-heading" class="sr-only">Footer</h2>
        <div class="px-6 pt-16 pb-8 mx-auto max-w-7xl lg:px-8">
            <div class="xl:grid xl:grid-cols-3 xl:gap-8">
                <div class="space-y-8">
                    <img class="h-10" src="/assets/logo.png" alt="logo" />
                    <p class="text-sm leading-6 text-neutral-300">
                        Orumah.com adalah situs teknologi jual beli properti terdepan di Indonesia yang telah melayani
                        jutaan orang sejak 2024, dan kini hadir untuk membuat “Jual Beli Properti Lebih Mudah” dengan
                        dukungan developer serta agen profesional.
                    </p>
                </div>
                <div class="grid grid-cols-2 gap-8 mt-16 xl:col-span-2 xl:mt-0">
                    <div class="md:grid md:grid-cols-2 md:gap-8">
                        <div>
                            <h3 class="text-sm font-semibold leading-6 text-white">Perusahaan</h3>
                            <ul role="list" class="mt-6 space-y-4">
                                <li v-for="item in navigation.solutions" :key="item.name">
                                    <a :href="item.href" class="text-sm leading-6 text-neutral-300 hover:text-white">{{
                                        item.name }}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="mt-10 md:mt-0">
                            <h3 class="text-sm font-semibold leading-6 text-white">Layanan</h3>
                            <ul role="list" class="mt-6 space-y-4">
                                <li v-for="item in navigation.support" :key="item.name">
                                    <a :href="item.href" class="text-sm leading-6 text-neutral-300 hover:text-white">{{
                                        item.name }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="md:grid md:grid-cols-2 md:gap-8">
                        <div>
                            <h3 class="text-sm font-semibold leading-6 text-white">Dukungan</h3>
                            <ul role="list" class="mt-6 space-y-4">
                                <li v-for="item in navigation.company" :key="item.name">
                                    <a :href="item.href" class="text-sm leading-6 text-neutral-300 hover:text-white">{{
                                        item.name }}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="mt-10 md:mt-0">
                            <h3 class="text-sm font-semibold leading-6 text-white">Hubungi Kami</h3>
                            <ul role="list" class="mt-6 space-y-4">
                                <li class="flex items-center gap-2" v-for="item in navigation.legal" :key="item.name">
                                    <component :is="item.icon" class="w-4 h-4 text-white" aria-hidden="true" />
                                    <a :href="item.href" class="text-sm leading-6 text-neutral-300 hover:text-white">{{
                                        item.name }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pt-8 mt-16 border-t border-white/10 sm:mt-20 lg:mt-24">
                <div class="flex flex-col justify-between space-y-6 md:space-y-0 md:flex-row">
                    <p class="leading-5 text-white">&copy 2023 ORumah. All Rights Reserved.</p>
                    <div class="flex space-x-6">
                        <a v-for="item in navigation.social" :key="item.name" :href="item.href"
                            class="text-white hover:text-neutral-400">
                            <span class="sr-only">{{ item.name }}</span>
                            <component :is="item.icon" class="w-6 h-6" aria-hidden="true" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</template>

<script setup>
import { defineComponent, h } from 'vue'

const navigation = {
    solutions: [
        { name: 'Tentang Kami', href: route('coming-soon') },
        { name: 'Produk & Layanan', href: route('coming-soon') },
        { name: 'Partner', href: route('coming-soon') },
    ],
    support: [
        { name: 'Iklankan Properti', href: route('coming-soon') },
        { name: 'KPR', href: route('coming-soon') },
    ],
    company: [
        { name: 'Kebijakan Privasi', href: route('coming-soon') },
        { name: 'Syarat Penggunaan', href: route('coming-soon') },
        { name: 'FAQ', href: route('coming-soon') },
    ],
    legal: [
        {
            name: 'info@orumah.com',
            href: '#',
            icon: defineComponent({
                render: () =>
                    h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24' }, [
                        h('path', {
                            'stroke-linecap': 'round',
                            'stroke-linejoin': 'round',
                            d: 'M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75',
                        }),
                    ]),
            }),
        },
        {
            name: '+62 21 932374821',
            href: '#',
            icon: defineComponent({
                render: () =>
                    h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24' }, [
                        h('path', {
                            'stroke-linecap': 'round',
                            'stroke-linejoin': 'round',
                            d: 'M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z',
                        }),
                    ]),
            }),
        },
    ],
    social: [
        {
            name: 'Facebook',
            href: '#',
            icon: defineComponent({
                render: () =>
                    h('svg', { fill: 'currentColor', viewBox: '0 0 24 24' }, [
                        h('path', {
                            'fill-rule': 'evenodd',
                            d: 'M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z',
                            'clip-rule': 'evenodd',
                        }),
                    ]),
            }),
        },
        {
            name: 'Instagram',
            href: '#',
            icon: defineComponent({
                render: () =>
                    h('svg', { fill: 'currentColor', viewBox: '0 0 24 24' }, [
                        h('path', {
                            'fill-rule': 'evenodd',
                            d: 'M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z',
                            'clip-rule': 'evenodd',
                        }),
                    ]),
            }),
        },
        {
            name: 'Twitter',
            href: '#',
            icon: defineComponent({
                render: () =>
                    h('svg', { fill: 'currentColor', viewBox: '0 0 24 24' }, [
                        h('path', {
                            d: 'M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84',
                        }),
                    ]),
            }),
        },
        {
            name: 'YouTube',
            href: '#',
            icon: defineComponent({
                render: () =>
                    h('svg', { fill: 'currentColor', viewBox: '0 0 24 24' }, [
                        h('path', {
                            'fill-rule': 'evenodd',
                            d: 'M19.812 5.418c.861.23 1.538.907 1.768 1.768C21.998 8.746 22 12 22 12s0 3.255-.418 4.814a2.504 2.504 0 0 1-1.768 1.768c-1.56.419-7.814.419-7.814.419s-6.255 0-7.814-.419a2.505 2.505 0 0 1-1.768-1.768C2 15.255 2 12 2 12s0-3.255.417-4.814a2.507 2.507 0 0 1 1.768-1.768C5.744 5 11.998 5 11.998 5s6.255 0 7.814.418ZM15.194 12 10 15V9l5.194 3Z',
                            'clip-rule': 'evenodd',
                        }),
                    ]),
            }),
        },
    ],
}
</script>
