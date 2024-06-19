<script setup>
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { Link, useForm, usePage } from '@inertiajs/vue3'
import { HeartIcon, Squares2X2Icon, XMarkIcon } from '@heroicons/vue/24/outline'
import { UserCircleIcon } from '@heroicons/vue/24/solid'

const { auth: { user } } = usePage().props
const form = useForm({})

const userAvatar = user.image ?? 'https://ui-avatars.com/api/?name=' + user.name

const logout = () => {
    form.post(route('logout'), {
        preserveScroll: true,
        onSuccess: function () {
            window.location.reload()
        },
    })
}
</script>

<template>
    <div class="hidden lg:ml-6 lg:flex lg:items-center">
        <!-- <button type="button"
            class="p-1 bg-white rounded-full text-neutral-400 hover:text-neutral-500 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2">
            <span class="sr-only">View notifications</span>
            <BellIcon class="w-6 h-6" aria-hidden="true" />
        </button> -->
        <Link :href="route('listing.index')" role="button"
              class="rounded-md bg-white px-6 py-2.5 text-sm font-semibold text-neutral-900 ring-1 ring-inset ring-neutral-700 hover:bg-neutral-700 hover:text-white uppercase mx-4">
            Iklankan properti
        </Link>

        <!-- Profile dropdown -->
        <Menu as="div" class="relative ml-3">
            <div>
                <MenuButton
                    class="flex text-sm bg-white rounded-full focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2">
                    <span class="sr-only">Open user menu</span>
                    <img class="w-8 h-8 rounded-full" :src="userAvatar"
                         alt="avatar"/>
                </MenuButton>
            </div>
            <transition enter-active-class="transition duration-200 ease-out"
                        enter-from-class="transform scale-95 opacity-0"
                        enter-to-class="transform scale-100 opacity-100"
                        leave-active-class="transition duration-75 ease-in"
                        leave-from-class="transform scale-100 opacity-100"
                        leave-to-class="transform scale-95 opacity-0">
                <MenuItems
                    class="absolute right-0 z-10 w-48 py-1 mt-2 origin-top-right bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                    <MenuItem v-slot="{ active }">
                        <Link :href="route('profile')"
                              class="block font-semibold border-b border-neutral-200 text-neutral-700">
                            <div
                                class="flex items-center flex-1 w-full gap-3 px-4 py-2 hover:bg-neutral-50">
                                {{ user.name }}
                            </div>
                        </Link>
                    </MenuItem>
                    <MenuItem v-slot="{ active }">
                        <Link :href="route('listing.index')"
                              :class="[active ? 'bg-neutral-100' : '', 'text-neutral-700']">
                            <div
                                class="flex items-center flex-1 w-full gap-3 px-4 py-2 hover:bg-neutral-50">
                                <Squares2X2Icon class="w-5 h-5"
                                                aria-hidden="true"/>
                                <span>Dashboard</span>
                            </div>
                        </Link>
                    </MenuItem>
                    <MenuItem v-slot="{ active }">
                        <Link :href="route('wishlist')" :class="[active ? 'bg-neutral-100' : '', 'text-neutral-700']">
                        <div class="flex items-center flex-1 w-full gap-3 px-4 py-2 hover:bg-neutral-50">
                            <HeartIcon class="w-5 h-5" aria-hidden="true" />
                            <span>Properti Favorit</span>
                        </div>
                        </Link>
                    </MenuItem>
                    <MenuItem v-slot="{ active }">
                        <Link :href="route('agent-detail', user.username)"
                              :class="[active ? 'bg-neutral-100' : '', 'text-neutral-700']">
                            <div
                                class="flex items-center flex-1 w-full gap-3 px-4 py-2 hover:bg-neutral-50">
                                <UserCircleIcon class="w-5 h-5"
                                                aria-hidden="true"/>
                                <span>Lihat Profil</span>
                            </div>
                        </Link>
                    </MenuItem>
                    <hr/>
                    <MenuItem v-slot="{ active }">
                        <button type="button" @click="logout"
                                class="flex items-center w-full gap-3 px-4 py-2 text-left text-red-500 hover:bg-neutral-50">
                            <XMarkIcon class="w-5 h-5" aria-hidden="true"/>
                            <span>Logout</span>
                        </button>
                    </MenuItem>
                </MenuItems>
            </transition>
        </Menu>
    </div>
</template>
