<script setup>
import { Head, useForm } from '@inertiajs/vue3'
import MobileComingSoon from '@/Components/Front/Base/MobileComingSoon.vue';
import Navbar from '@/Components/Front/Base/Navbar.vue'
import { CheckCircleIcon } from '@heroicons/vue/24/solid'

const form = useForm({
    role: null,
})

function selectRole(role) {
    form.role = role
}

const submit = () => {
    form.post(route('postChooseRole'))
}

</script>

<template>
    <MobileComingSoon />
    <Navbar />

    <Head :title="'Pilih Role'" />

    <div
        class="flex items-center justify-center h-screen px-4 mx-auto mb-6 space-y-6 text-center max-w-7xl sm:p-6 lg:p-8">
        <div class="space-y-6">
            <h5 class="text-lg font-semibold">Daftar Sebagai</h5>

            <div class="flex justify-center space-x-7">
                <div @click="selectRole('user')"
                    class="border-[1px] border-gray-300 rounded-md p-5 text-center w-60 relative hover:cursor-pointer">
                    <CheckCircleIcon class="absolute top-3 right-3 w-6 text-[#1CD6D0]" v-if="form.role === 'user'" />
                    <img :src="'assets/icons/customer.png'" alt="" class="mx-auto mb-5">
                    <h6 class="font-semibold">Customer</h6>
                    <p class="text-sm text-[#7C7C7C]">Mulai miliki properti impian anda sekarang juga.</p>
                </div>
                <div @click="selectRole('agent')"
                    class="border-[1px] border-gray-300 rounded-md p-5 text-center w-60 relative hover:cursor-pointer">
                    <CheckCircleIcon class="absolute top-3 right-3 w-6 text-[#1CD6D0]" v-if="form.role === 'agent'" />
                    <img :src="'assets/icons/agent.png'" alt="" class="mx-auto mb-5">
                    <h6 class="font-semibold">Agen</h6>
                    <p class="text-sm text-[#7C7C7C]">Kelola dan promosikan properti anda.</p>
                </div>
                <div @click="selectRole('merchant')"
                    class="border-[1px] border-gray-300 rounded-md p-5 text-center w-60 relative hover:cursor-pointer">
                    <CheckCircleIcon class="absolute top-3 right-3 w-6 text-[#1CD6D0]"
                        v-if="form.role === 'merchant'" />
                    <img :src="'assets/icons/agent.png'" alt="" class="mx-auto mb-5">
                    <h6 class="font-semibold">Food / Merchant</h6>
                    <p class="text-sm text-[#7C7C7C]">Promosikan bisnis makanan atau toko anda.</p>
                </div>
                <div @click="selectRole('notaris')"
                    class="border-[1px] border-gray-300 rounded-md p-5 text-center w-60 relative hover:cursor-pointer">
                    <CheckCircleIcon class="absolute top-3 right-3 w-6 text-[#1CD6D0]" v-if="form.role === 'notaris'" />
                    <img :src="'assets/icons/agent.png'" alt="" class="mx-auto mb-5">
                    <h6 class="font-semibold">Notaris</h6>
                    <p class="text-sm text-[#7C7C7C]">Layanan hukum terkait transaksi properti.</p>
                </div>
                <div @click="selectRole('lbh')"
                    class="border-[1px] border-gray-300 rounded-md p-5 text-center w-60 relative hover:cursor-pointer">
                    <CheckCircleIcon class="absolute top-3 right-3 w-6 text-[#1CD6D0]" v-if="form.role === 'lbh'" />
                    <img :src="'assets/icons/agent.png'" alt="" class="mx-auto mb-5">
                    <h6 class="font-semibold">LBH</h6>
                    <p class="text-sm text-[#7C7C7C]">Lembaga hukum terkait transaksi properti.</p>
                </div>
            </div>

            <button class="bg-[#1CD6D0] text-white py-2 px-4 rounded-full font-bold" type="button"
                :disabled="!form.role" @click="submit">
                Pilih dan Lanjutkan
            </button>
        </div>
    </div>
</template>