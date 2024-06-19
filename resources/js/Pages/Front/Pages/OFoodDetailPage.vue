<script setup>
import { Head, useForm, usePage } from "@inertiajs/vue3";
import { createToaster } from "@meforma/vue-toaster";

import FrontLayout from "@/Layouts/FrontLayout.vue";

import AgentCard from "@/Components/Front/Widgets/AgentCard.vue";
import DefaultButton from "@/Components/Front/Widgets/DefaultButton.vue";
import KprCalculator from "@/Components/Front/Widgets/KprCalculator.vue";
import PropertyDetailInfo from "@/Components/Front/Widgets/PropertyDetailInfo.vue";
import PropertyDetailImageGrid from "@/Components/Front/Widgets/PropertyDetailImageGrid.vue";
import { ArrowLeftIcon, HeartIcon, ShareIcon } from "@heroicons/vue/24/outline";
import { HeartIcon as HeartIconSolid } from "@heroicons/vue/24/solid";
import MobileComingSoon from "@/Components/Front/Base/MobileComingSoon.vue";
import { computed, reactive, ref } from "vue";
import useEmitter from "@/lib/useEmitter.js";
import OMerchantDetailInfo from "@/Components/Front/Widgets/OMerchantDetailInfo.vue";
import axios from "axios";

const { ads, slug, agent, like, typeFood } = defineProps({
    ads: Object,
    media: Object,
    agent: Object,
    like: Boolean,
    slug: String,
    typeFood: String,
    routingName: {
        type: String,
        default: "linkKpr",
    },
});

const emitter = useEmitter(); // State untuk menampilkan atau menyembunyikan modal
const isLoginForm = ref(true);
const isFavoritedAds = ref(like);

const toaster = createToaster({
    position: "top-right",
    duration: 2300,
    queue: true,
    max: 1,
});

const user = computed(() => usePage().props.auth.user);

const state = reactive({
    isFavorited: isFavoritedAds.value,
});

const form = useForm({
    ads_id: ads.ads_id,
});

const back = () => window.history.back();

const handleShare = () => {
    // get current url
    const url = window.location.href;

    // copy to clipboard
    navigator.clipboard.writeText(url);

    toaster.success("Link berhasil disalin!");
};

const handleFavorite = () => {
    if (!user.value) {
        toggleModal();
        return;
    }
    console.log("agent:", agent);
    axios
        .post(route("ad.like"), {
            addId: ads.ads_id,
            agentId: agent.id,
            type: typeFood,
        })
        .then((response) => {
            console.log("HTTP request sent successfully:", response.data);
            state.isFavorited = response.data.like;
        })
        .catch((error) => {
            console.error("Error sending HTTP request:", error);
            form.errorMessage = "Username atau password salah"; // Pesan error yang lebih tepat
        });
};

const showModal = ref(false); // State untuk menampilkan atau menyembunyikan modal
const toggleModal = () => {
    showModal.value = !showModal.value;
};
const triggerLoginPopup = () => {
    toggleModal();
};
const toggleForm = () => {
    isLoginForm.value = !isLoginForm.value; // Mengganti antara login dan registrasi
};

// Fungsi untuk submit login
const submitLogin = async (slug, routingName) => {
    console.log("Email:", form.email, "Password:", form.password); // Menambahkan console log
    form.processing = true;
    form.errorMessage = "";
    axios
        .post(route("auth.in.login"), {
            email: form.email,
            password: form.password,
        })
        .then((response) => {
            console.log(
                "HTTP request sent successfully:",
                response.data.success
            );
            if (response.data.success === true) {
                handleFavorite();
                location.reload();
            } else {
                form.errorMessage = "Email atau Password anda salah!";
            }
        })
        .catch((error) => {
            console.error("Error sending HTTP request:", error);
            form.errorMessage = "Username atau password salah"; // Pesan error yang lebih tepat
        });
};

// Fungsi untuk submit registrasi
const submitRegistration = async (slug, routingName) => {
    console.log("Email:", form.email, "Password:", form.password);
    console.log("Wa:", form.noWa, "Konfirmasi:", form.confirmPassword);
    axios
        .post(route("auth.in.registrasi"), {
            // Perbaiki rute untuk registrasi
            email: form.email,
            password: form.password,
            nama: form.nama,
            noWa: form.noWa,
        })
        .then((response) => {
            console.log("HTTP request sent successfully:", response.data);
            if (response.data.success === true) {
                handleFavorite();
                location.reload();
            } else {
                form.errorMessage = "Ada kesalahan dalam pengisian form!";
            }
        })
        .catch((error) => {
            console.error("Error sending HTTP request:", error);
            form.errorMessage = "Terjadi kesalahan saat registrasi";
        });
};
</script>

<template>
    <FrontLayout>
        <Head :title="ads.title" />

        <div class="px-4 mx-auto space-y-6 max-w-7xl sm:p-6 lg:p-8">
            <div class="flex flex-col md:flex-row md:justify-between">
                <DefaultButton @click="back()">
                    <ArrowLeftIcon
                        class="w-4 h-4 mr-2 text-neutral-900"
                        aria-hidden="true"
                    />
                    Kembali
                </DefaultButton>

                <div class="flex gap-2">
                    <form @submit.prevent="handleFavorite">
                        <input type="hidden" v-model="form.ads_id" />
                        <DefaultButton v-if="state.isFavorited" type="submit">
                            <HeartIconSolid
                                class="w-4 h-4 mr-2 text-red-500"
                                aria-hidden="true"
                            />
                            <span>Difavoritkan</span>
                        </DefaultButton>
                        <DefaultButton v-else type="submit">
                            <HeartIcon
                                class="w-4 h-4 mr-2 text-area-900"
                                aria-hidden="false"
                            />
                            <span>Favoritkan</span>
                        </DefaultButton>
                    </form>
                    <DefaultButton @click="handleShare">
                        <ShareIcon
                            class="w-4 h-4 mr-2 text-neutral-900"
                            aria-hidden="true"
                        />
                        Bagikan
                    </DefaultButton>
                </div>
            </div>
            <PropertyDetailImageGrid :media="media" />
            <div class="flex gap-12">
                <div class="w-4/6">
                    <OMerchantDetailInfo
                        :title="ads.title"
                        :area="ads.district"
                        :description="ads.description"
                        :lat="ads.districtLocation_lat"
                        :lng="ads.districtLocation_long"
                    />
                </div>
                <div class="w-2/6 space-y-6">
                    <AgentCard
                        :agent="agent"
                        :slug="slug"
                        :show-stats="false"
                        :showKpr="true"
                    />
                </div>
            </div>
        </div>

        <!-- <div class="px-4 mx-auto space-y-8 max-w-7xl sm:px-6 lg:px-8 md:mb-12 md:space-y-12">
            <PropertyLists title="Properti serupa">
                <Slide v-for="slide in 10" :key="slide">
                    <PropertyCard />
                </Slide>
            </PropertyLists>
        </div> -->
        <transition name="fade">
            <div
                v-if="showModal"
                class="modal-overlay fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center"
            >
                <div class="modal-content bg-white p-4 rounded-lg">
                    <form
                        @submit.prevent="
                            isLoginForm
                                ? submitLogin(slug, routingName)
                                : submitRegistration(slug, routingName)
                        "
                    >
                        <div
                            class="modal-header p-4 flex justify-between items-center"
                        >
                            <h2
                                class="text-2xl font-bold text-center text-neutral-900 flex-grow"
                            >
                                {{ isLoginForm ? "Login" : "Registrasi" }}
                            </h2>
                            <button @click="toggleModal" class="text-2xl">
                                &times;
                            </button>
                        </div>
                        <div class="w-full border-t border-gray-300"></div>
                        <div class="modal-body p-4">
                            <!-- Tambahkan tampilan error di sini -->
                            <div
                                v-if="form.errorMessage"
                                class="p-3 bg-red-100 text-red-700 rounded"
                            >
                                {{ form.errorMessage }}
                            </div>
                            <div v-if="!isLoginForm" class="mb-4">
                                <label
                                    for="nama"
                                    class="block text-sm font-medium text-gray-700"
                                    >Nama:</label
                                >
                                <input
                                    type="text"
                                    id="nama"
                                    v-model="form.nama"
                                    required
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                />
                            </div>
                            <div class="mb-4">
                                <label
                                    for="email"
                                    class="block text-sm font-medium text-gray-700"
                                    >Email:</label
                                >
                                <input
                                    type="email"
                                    id="email"
                                    v-model="form.email"
                                    required
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                />
                            </div>

                            <div v-if="!isLoginForm" class="mb-4">
                                <label
                                    for="no-wa"
                                    class="block text-sm font-medium text-gray-700"
                                    >No WhatsApp:</label
                                >
                                <input
                                    type="number"
                                    id="no-wa"
                                    v-model="form.noWa"
                                    required
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                />
                            </div>

                            <div class="mb-4">
                                <label
                                    for="password"
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    {{
                                        isLoginForm
                                            ? "Password:"
                                            : "Buat Password:"
                                    }}
                                </label>
                                <input
                                    type="password"
                                    id="password"
                                    v-model="form.password"
                                    required
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                />
                            </div>

                            <div v-if="!isLoginForm" class="mb-4">
                                <label
                                    for="confirm-password"
                                    class="block text-sm font-medium text-gray-700"
                                    >Konfirmasi Password:</label
                                >
                                <input
                                    type="password"
                                    id="confirm-password"
                                    v-model="form.confirmPassword"
                                    required
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                />
                            </div>

                            <button
                                type="submit"
                                class="inline-flex items-center gap-x-2 w-full justify-center rounded-md px-3.5 py-2.5 text-white ring-1 bg-teal-400 ring-inset ring-teal-400 hover:bg-teal-500"
                            >
                                {{ isLoginForm ? "Login" : "Daftar" }}
                            </button>
                        </div>
                        <div class="modal-footer p-4">
                            <p class="text-sm text-center">
                                {{
                                    isLoginForm
                                        ? "Belum punya akun?"
                                        : "Sudah punya akun?"
                                }}
                                <button
                                    @click="toggleForm"
                                    class="text-blue-500 hover:text-blue-800"
                                >
                                    {{
                                        isLoginForm
                                            ? "Daftar sekarang"
                                            : "Login sekarang"
                                    }}
                                </button>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </transition>
    </FrontLayout>
</template>

<style>
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1050; /* Nilai z-index yang lebih tinggi */
}

.modal-content {
    background: white;
    padding: 20px;
    border-radius: 10px;
    width: 90%;
    max-width: 500px;
    overflow-y: auto; /* Menambahkan scroll vertikal jika diperlukan */
}

.modal-header,
.modal-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.close-button {
    border: none;
    background: none;
    font-size: 1.5rem;
    cursor: pointer;
}

.submit-button,
.login-button,
.toggle-form {
    cursor: pointer;
    padding: 10px 20px;
    margin-top: 10px;
    color: white;
    background-color: #007bff;
    border: none;
    border-radius: 5px;
    transition: background-color 0.3s;
}

.submit-button:hover,
.login-button:hover,
.toggle-form:hover {
    background-color: #0056b3;
}
</style>
