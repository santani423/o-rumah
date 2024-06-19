<script setup>
import { Link } from "@inertiajs/vue3";
import { PhoneIcon } from "@heroicons/vue/24/solid";
import LinkButton from "./LinkButton.vue";
import { usePage } from "@inertiajs/vue3";
import { ref, reactive } from "vue";
import axios from "axios";

const props = defineProps({
    agent: Object,
    slug: String,
    showStats: {
        type: Boolean,
        default: true,
    },
    showKpr: {
        type: Boolean,
        default: false,
    },
    linkKpr: {
        type: String,
        default: "linkKpr",
    },
    routingName: {
        type: String,
        default: "linkKpr",
    },
    isLoggedIn: {
        type: Boolean,
        default: false,
    },
    showLelang: {
        type: Boolean,
        default: false,
    },
});
const user = usePage().props.auth.user;
const isAgent = (user) => !!user;
console.log("user", user);
const handlePhone = (phone) => {
    window.open(phone, "_blank");
};

const showModal = ref(false); // State untuk menampilkan atau menyembunyikan modal
const isLoginForm = ref(true); // State untuk menentukan tampilan form
const username = ref(props.agent.username);

const toggleModal = () => {
    showModal.value = !showModal.value;
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
                // Perbaiki kesalahan pengetikan dari 'ture' menjadi 'true'
                console.log("Successfully logged in:", response.data.success);
                window.location.href = route(routingName, slug);
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
                console.log("Successfully registered:", response.data.success);
                window.location.href = route(routingName, slug);
            } else {
                form.errorMessage = "Ada kesalahan dalam pengisian form!";
            }
        })
        .catch((error) => {
            console.error("Error sending HTTP request:", error);
            form.errorMessage = "Terjadi kesalahan saat registrasi";
        });
};

const form = reactive({
    email: "",
    password: "",
    confirmPassword: "",
    nama: "",
    noWa: "",
    errors: [],
    processing: false,
    errorMessage: "", // Tambahkan ini untuk menyimpan pesan error
});

const triggerLoginPopup = () => {
    toggleModal();
};
</script>

<template>
    <div
        class="relative w-full p-4 space-y-4 bg-white border rounded-xl border-neutral-300 focus-within:ring-1 focus-within:ring-neutral-500 hover:border-neutral-400"
    >
        <div class="flex items-center space-x-5">
            <div class="flex-shrink-0">
                <img
                    v-if="agent.image"
                    class="w-20 h-20 rounded-full"
                    :src="agent.image"
                    :alt="agent.name"
                />
                <img
                    v-else
                    class="w-20 h-20 rounded-full"
                    src="https://via.placeholder.com/100"
                    :alt="agent.name"
                />
            </div>
            <div class="flex-1 min-w-0 text-left">
                <Link
                    :href="route('agent-detail', agent.username)"
                    class="focus:outline-none"
                >
                    <p class="font-bold text-blue-900">{{ agent.name }}</p>
                    <p class="mt-1 text-sm truncate text-neutral-500">
                        {{ agent.joined_at }}
                    </p>
                </Link>
            </div>
            <div v-if="!showStats && agent.company_name" class="flex-shrink-0">
                <img
                    :class="[!isAgent(agent) && 'opacity-0', 'h-10 max-w-full']"
                    :src="agent.company_image"
                    :alt="agent.company_name"
                />
            </div>
        </div>
        <div v-if="showKpr" class="flex flex-shrink-0">
            <LinkButton
                v-if="user"
                :href="route('linkKpr', slug)"
                class="inline-flex items-center gap-x-2 flex-1 justify-center rounded-md px-3.5 py-2.5 text-white ring-1 bg-teal-400 ring-inset ring-teal-400 hover:bg-teal-500"
            >
                Ajukan KPR
            </LinkButton>
            <button
                v-else
                @click="triggerLoginPopup(slug)"
                class="inline-flex items-center gap-x-2 flex-1 justify-center rounded-md px-3.5 py-2.5 text-white ring-1 bg-teal-400 ring-inset ring-teal-400 hover:bg-teal-500"
            >
                Ajukan KPR
            </button>
        </div>
        <div v-if="showLelang" class="flex flex-shrink-0">
            <LinkButton
                v-if="user"
                :href="route('auction-link', [slug, username])"
                class="inline-flex items-center gap-x-2 flex-1 justify-center rounded-md px-3.5 py-2.5 text-white ring-1 bg-teal-400 ring-inset ring-teal-400 hover:bg-teal-500"
            >
                Ajukan Lelang
            </LinkButton>
            <button
                v-else
                @click="triggerLoginPopup(slug)"
                class="inline-flex items-center gap-x-2 flex-1 justify-center rounded-md px-3.5 py-2.5 text-white ring-1 bg-teal-400 ring-inset ring-teal-400 hover:bg-teal-500"
            >
                Ajukan Lelang
            </button>
        </div>
        <div v-if="!showStats" class="flex flex-shrink-0 space-x-2">
            <button
                v-if="agent.phone"
                type="button"
                @click.prevent="handlePhone(`tel:${agent.phone}`)"
                class="inline-flex items-center gap-x-2 flex-1 justify-center rounded-md px-3.5 py-2.5 text-neutral-900 ring-1 ring-inset ring-neutral-200 hover:bg-neutral-100"
            >
                <PhoneIcon class="-ml-0.5 h-5 w-5" aria-hidden="true" />
                Telepon
            </button>
            <button
                v-if="agent.wa_phone"
                type="button"
                @click.prevent="handlePhone(`https://wa.me/${agent.wa_phone}`)"
                class="inline-flex items-center gap-x-2 flex-1 justify-center rounded-md bg-green-500 px-3.5 py-2.5 text-sm font-semibold text-white hover:bg-green-600"
            >
                <svg
                    class="-ml-0.5 h-5 w-5 text-white fill-current"
                    xmlns="http://www.w3.org/2000/svg"
                    height="16"
                    width="14"
                    viewBox="0 0 448 512"
                >
                    <path
                        d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7 .9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"
                    />
                </svg>
                WhatsApp
            </button>
        </div>
        <div v-if="showStats" class="flex-shrink-0">
            <div
                v-if="agent.company_name"
                class="flex items-center px-4 py-3 space-x-4 bg-neutral-50 rounded-xl"
            >
                <img
                    class="aspect-square h-10 w-10 rounded-full object-cover"
                    :src="agent.company_image"
                    :alt="agent.company_name"
                />
                <p class="flex-1 text-sm truncate">{{ agent.company_name }}</p>
            </div>
        </div>
        <div v-if="showStats" class="flex flex-shrink-0 space-x-2">
            <div
                class="flex flex-col items-center flex-1 p-3 space-y-2 bg-neutral-50 rounded-xl"
            >
                <p class="text-xs truncate text-neutral-500">Total properti</p>
                <p class="text-sm font-bold text-blue-900">
                    {{ agent.total_ads }}
                </p>
            </div>
            <div
                class="flex flex-col items-center flex-1 p-3 space-y-2 bg-neutral-50 rounded-xl"
            >
                <p class="text-xs truncate text-neutral-500">
                    Terjual / Tersewa
                </p>
                <p class="text-sm font-bold text-blue-900">
                    {{ agent.total_sold }}
                </p>
            </div>
            <div
                class="flex flex-col items-center flex-1 p-3 space-y-2 bg-neutral-50 rounded-xl"
            >
                <p class="text-xs truncate text-neutral-500">Harga rata-rata</p>
                <p class="text-sm font-bold text-blue-900">
                    {{ agent.average_price }}
                </p>
            </div>
        </div>

        <div v-if="showModal" class="modal-overlay">
            <div class="modal-content">
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
                                    isLoginForm ? "Password:" : "Buat Password:"
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
    </div>
</template>

<style scoped>
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
