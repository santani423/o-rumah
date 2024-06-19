<script setup>
import { ref, watchEffect } from "vue";
import { Disclosure } from "@headlessui/vue";
import { Link, usePage } from "@inertiajs/vue3";

import Hamburger from "@/Components/Front/Navigation/Hamburger.vue";
import MobileMenu from "@/Components/Front/Navigation/MobileMenu.vue";
import RightMenuBeforeLogin from "@/Components/Front/Navigation/RightMenuBeforeLogin.vue";
import RightMenuAfterLogin from "@/Components/Front/Navigation/RightMenuAfterLogin.vue";
import useEmitter from "@/lib/useEmitter";

let user = usePage().props.auth.user;

const isLoggedIn = ref(false);
const emitter = useEmitter();

watchEffect(() => {
    isLoggedIn.value = !!user;
});

const rerender = () => (isLoggedIn.value = true);

emitter.on("isLoggedIn", () => rerender());
</script>

<template :key>
    <Disclosure
        as="nav"
        class="fixed top-0 z-10 w-full bg-white border-b border-neutral-200"
        v-slot="{ open }"
    >
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <!-- Logo -->
                    <div class="flex items-center flex-shrink-0">
                        <Link :href="route('home')">
                            <img
                                class="block w-auto h-8 lg:hidden"
                                src="/assets/logo.png"
                                alt="logo"
                            />
                            <img
                                class="hidden w-auto h-8 lg:block"
                                src="/assets/logo.png"
                                alt="logo"
                            />
                        </Link>
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden lg:ml-12 lg:flex lg:space-x-8">
                        <!-- Current: "border-cyan-300 text-neutral-900", Default: "border-transparent text-neutral-500 hover:border-neutral-300 hover:text-neutral-700" -->
                        <Link
                            :href="route('latest')"
                            class="inline-flex items-center px-1 pt-1 text-sm font-medium border-b-2 border-transparent text-neutral-500 hover:border-neutral-300 hover:text-neutral-700"
                            :class="{
                                '!border-cyan-300 text-neutral-900':
                                    route().current('latest'),
                            }"
                        >
                            Properti Baru
                        </Link>
                        <a
                            :href="route('auction')"
                            class="inline-flex items-center px-1 pt-1 text-sm font-medium border-b-2 border-transparent text-neutral-500 hover:border-neutral-300 hover:text-neutral-700"
                            :class="{
                                '!border-cyan-300 text-neutral-900':
                                    route().current('auction'),
                            }"
                            >Properti Lelang</a
                        >
                        <a
                            :href="route('member.favorit')"
                            class="inline-flex items-center px-1 pt-1 text-sm font-medium border-b-2 border-transparent text-neutral-500 hover:border-neutral-300 hover:text-neutral-700"
                            :class="{
                                '!border-cyan-300 text-neutral-900':
                                    route().current('member.favorit'),
                            }"
                            >Favorit</a
                        >
                        <a
                            :href="route('member.pengajuan.kpr')"
                            class="inline-flex items-center px-1 pt-1 text-sm font-medium border-b-2 border-transparent text-neutral-500 hover:border-neutral-300 hover:text-neutral-700"
                            >Pengajuan</a
                        >
                        <a
                            :href="route('coming-soon')"
                            class="inline-flex items-center px-1 pt-1 text-sm font-medium border-b-2 border-transparent text-neutral-500 hover:border-neutral-300 hover:text-neutral-700"
                            >Tentang Kami</a
                        >
                    </div>
                </div>

                <!-- Right Menu (After Login State) -->
                <div v-if="isLoggedIn" class="flex items-center">
                    <RightMenuAfterLogin />
                </div>
                <div v-if="!isLoggedIn" class="flex items-center">
                    <RightMenuBeforeLogin />
                </div>

                <!-- Hamburger -->
                <Hamburger :open="open" />
            </div>
        </div>

        <MobileMenu />
    </Disclosure>
</template>
