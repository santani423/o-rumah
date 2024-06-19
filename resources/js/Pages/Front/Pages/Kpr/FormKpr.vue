<script setup>
import { Head, Link } from "@inertiajs/vue3";

import FrontLayout from "@/Layouts/FrontLayout.vue";
import AgentCard from "@/Components/Front/Widgets/AgentCard.vue";
import { ref, defineProps } from "vue";
import axios from "axios";
const imageSrc = ref("");
const imagekkSrc = ref("");
const fotoSuratNikahSrc = ref("");
const fotoRekeningKoranSrc = ref("");
const fotoSlipGajiSrc = ref("");
const selectedJob = ref("");
import vSelect from "vue-select";
const props = defineProps({
    ads: Array,
    job: Array,
    agent: Array,
    bankBpr: Array,
    bankUmum: Array,
});
const agreement = ref(false);
const showModal = ref(false);

function toggleModal() {
    showModal.value = !showModal.value;
}

function handleJobChange(event) {
    selectedJob.value = event.target.value;
    console.log("Pekerjaan yang dipilih: ", selectedJob.value);
}
console.log("props", props.bankBpr);
function previewImage(event) {
    const [file] = event.target.files;
    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            imageSrc.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
}
function previewkkImage(event) {
    const [file] = event.target.files;
    console.log("ini");
    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            imagekkSrc.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
}
function previewfotoSuratNikahImage(event) {
    const [file] = event.target.files;
    console.log("ini");
    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            fotoSuratNikahSrc.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
}
function previewfotoRekeningKoranImage(event) {
    const [file] = event.target.files;
    console.log("ini");
    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            fotoRekeningKoranSrc.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
}
function previewfotoSlipGajiImage(event) {
    const [file] = event.target.files;
    console.log("ini");
    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            fotoSlipGajiSrc.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
}

function triggerFileInput(inputId) {
    const inputElement = document.getElementById(inputId); // Mendapatkan elemen input
    if (inputElement) {
        inputElement.click(); // Memicu klik pada elemen input jika elemen ditemukan
    } else {
        console.error(`Input element with id ${inputId} not found`); // Menampilkan pesan error jika elemen tidak ditemukan
    }
}

const submit = () => {
    if (!agreement.value) {
        alert("Anda harus menyetujui persyaratan untuk melanjutkan.");
        return;
    }
    const formData = new FormData();
    // Menambahkan semua file yang diperlukan ke formData
    formData.append("imageSrc", document.getElementById("foto").files[0]);
    formData.append("imagekkSrc", document.getElementById("fotokk").files[0]);
    formData.append(
        "fotoSuratNikahSrc",
        document.getElementById("fotoSuratNikah").files[0]
    );
    formData.append(
        "fotoRekeningKoranSrc",
        document.getElementById("fotoRekeningKoran").files[0]
    );
    formData.append(
        "fotoSlipGajiSrc",
        document.getElementById("fotoSlipGaji").files[0]
    );
    // Menambahkan data teks dari formulir
    formData.append("bankUmum", document.getElementById("bankUmum").value);
    formData.append("bankBpr", document.getElementById("bankBpr").value);
    formData.append("pekerjaan", selectedJob.value);
    formData.append("agreement", agreement.value);
    console.log("ok");
    formData.append("ads_id", props.ads.ads_id);
    formData.append(
        "namaLengkap",
        document.getElementById("namaLengkap").value
    );
    formData.append("email", document.getElementById("email").value);
    formData.append("noHp", document.getElementById("noHp").value);
    console.log(formData);

    // Mengirim POST request menggunakan Axios
    axios
        .post(route("linkKpr.store", props.ads.slug), formData, {
            headers: {
                "Content-Type": "multipart/form-data", // Penting untuk upload file
            },
        })
        .then((response) => {
            console.log("Response from Laravel:", response.data);
            window.location.href = route("member.pengajuan.kpr");
        })
        .catch((error) => {
            console.error("Error submitting form:", error);
        });
};
</script>
<template>
    <FrontLayout>
        <Head title="Formulir Pengajuan KPR" />

        <div class="container mx-auto px-4 sm:px-6 lg:px-8 my-8">
            <div class="flex justify-center">
                <div
                    class="bg-white p-8 border border-neutral-200 rounded-3xl shadow-lg w-full max-w-4xl mr-3"
                    style="min-height: 100%"
                >
                    <p class="text-xl text-gray-700 mb-4 font-bold">
                        {{ ads.title }}
                    </p>
                    <h3 class="text-3xl font-bold text-teal-500 mb-6">
                        Harga: Rp{{ ads.price }}
                    </h3>

                    <img
                        :src="ads.image"
                        alt="Deskripsi Gambar"
                        class="max-w-full mb-3"
                    />

                    <AgentCard
                        :agent="agent"
                        :slug="ads.slug"
                        :show-stats="false"
                        :showKpr="false"
                    />
                </div>
                <div
                    class="bg-white p-8 border border-neutral-200 rounded-3xl shadow-lg w-full max-w-4xl"
                >
                    <p class="text-xl text-gray-700 mb-4 font-bold">
                        Formulir Pengajuan KPR
                    </p>
                    <form
                        class="w-full"
                        @submit.prevent="submit"
                        enctype="multipart/form-data"
                    >
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label
                                    for="bankUmum"
                                    class="block text-sm font-medium text-gray-700"
                                    >Bank Umum:</label
                                >
                                <select
                                    id="bankUmum"
                                    class="w-full p-3 border border-gray-300 rounded-md"
                                >
                                    <option disabled selected>
                                        Pilih Bank Umum
                                    </option>
                                    <optgroup
                                        v-for="(group, province) in bankUmum"
                                        :label="province"
                                    >
                                        <option
                                            v-for="bank in group.banks"
                                            :key="bank.id"
                                            :value="bank.id"
                                        >
                                            {{ bank.alias_name }}
                                        </option>
                                    </optgroup>
                                </select>
                            </div>
                            <div>
                                <label
                                    for="bankBpr"
                                    class="block text-sm font-medium text-gray-700"
                                    >Bank BPR:</label
                                >
                                <select
                                    id="bankBpr"
                                    class="w-full p-3 border border-gray-300 rounded-md"
                                >
                                    <option disabled selected>
                                        Pilih Bank BPR
                                    </option>
                                    <optgroup
                                        v-for="(group, province) in bankBpr"
                                        :label="province"
                                    >
                                        <option
                                            v-for="bank in group.banks"
                                            :key="bank.id"
                                            :value="bank.id"
                                        >
                                            {{ bank.alias_name }}
                                        </option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <h3 class="col-span-3 text-left">
                                Pilih Pekerjaan:
                            </h3>
                            <!-- Judul bagian pekerjaan ditambahkan di sini -->
                            <div
                                class="bg-white p-4 shadow rounded-lg flex justify-between items-center"
                                v-for="(job, index) in job"
                                :key="job.id"
                            >
                                <label
                                    :for="'option' + job.id"
                                    class="text-left"
                                >
                                    {{ job.title }}
                                </label>

                                <input
                                    type="radio"
                                    :id="'option' + job.id"
                                    name="pekerjaan"
                                    :value="job.id"
                                    class="text-right"
                                    @change="handleJobChange"
                                />
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-1 gap-4 mb-4">
                            <div>
                                <label
                                    for="namaLengkap"
                                    class="block text-sm font-medium text-gray-700"
                                    >Nama Lengkap:</label
                                >
                                <input
                                    type="text"
                                    id="namaLengkap"
                                    placeholder="Masukkan Nama Lengkap Anda"
                                    class="w-full p-3 border border-gray-300 rounded-md"
                                />
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label
                                    for="email"
                                    class="block text-sm font-medium text-gray-700"
                                    >Email:</label
                                >
                                <input
                                    type="email"
                                    id="email"
                                    placeholder="Masukkan Email Anda"
                                    class="w-full p-3 border border-gray-300 rounded-md"
                                />
                            </div>
                            <div>
                                <label
                                    for="noHp"
                                    class="block text-sm font-medium text-gray-700"
                                    >No Handphone:</label
                                >
                                <input
                                    type="tel"
                                    id="noHp"
                                    placeholder="Masukkan No Handphone Anda"
                                    class="w-full p-3 border border-gray-300 rounded-md"
                                />
                            </div>
                        </div>
                        <div class="mb-4">
                            <label
                                for="foto"
                                class="block text-sm font-medium text-gray-700"
                                >Upload Foto KTP Pemohon/Suami/Istri:</label
                            >
                            <div
                                class="p-4 border-2 border-dashed border-gray-300 rounded-md cursor-pointer"
                                @click="triggerFileInput('foto')"
                            >
                                <input
                                    type="file"
                                    id="foto"
                                    @change="
                                        (event) => previewImage(event, imageSrc)
                                    "
                                    class="w-full p-3 hidden"
                                />
                                <img
                                    id="suamiIstri"
                                    v-show="imageSrc"
                                    :src="imageSrc"
                                    class="mt-4 max-w-full h-auto"
                                    style="display: none"
                                />
                                <div
                                    v-if="!imageSrc"
                                    class="text-center text-gray-500"
                                >
                                    Klik untuk mengupload gambar
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label
                                for="fotokk"
                                class="block text-sm font-medium text-gray-700"
                                >Upload Foto Kartu Keluarga:</label
                            >
                            <div
                                class="p-4 border-2 border-dashed border-gray-300 rounded-md cursor-pointer"
                                @click="triggerFileInput('fotokk')"
                            >
                                <input
                                    type="file"
                                    id="fotokk"
                                    @change="previewkkImage"
                                    class="w-full p-3 hidden"
                                />
                                <img
                                    id="kartuKeluarga"
                                    v-show="imagekkSrc"
                                    :src="imagekkSrc"
                                    class="mt-4 max-w-full h-auto"
                                    style="display: none"
                                />
                                <div
                                    v-if="!imagekkSrc"
                                    class="text-center text-gray-500"
                                >
                                    Klik untuk mengupload gambar
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label
                                for="fotoSuratNikah"
                                class="block text-sm font-medium text-gray-700"
                                >Upload Foto Surat Nikah atau Cerai:</label
                            >
                            <div
                                class="p-4 border-2 border-dashed border-gray-300 rounded-md cursor-pointer"
                                @click="triggerFileInput('fotoSuratNikah')"
                            >
                                <input
                                    type="file"
                                    id="fotoSuratNikah"
                                    @change="previewfotoSuratNikahImage"
                                    class="w-full p-3 hidden"
                                />
                                <img
                                    id="imgfotoSuratNikah"
                                    v-show="fotoSuratNikahSrc"
                                    :src="fotoSuratNikahSrc"
                                    class="mt-4 max-w-full h-auto"
                                    style="display: none"
                                />
                                <div
                                    v-if="!fotoSuratNikahSrc"
                                    class="text-center text-gray-500"
                                >
                                    Klik untuk mengupload gambar
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label
                                for="fotoRekeningKoran"
                                class="block text-sm font-medium text-gray-700"
                                >Upload Rekening Koran 3 Bulan Terakhir:</label
                            >
                            <div
                                class="p-4 border-2 border-dashed border-gray-300 rounded-md cursor-pointer"
                                @click="triggerFileInput('fotoRekeningKoran')"
                            >
                                <input
                                    type="file"
                                    id="fotoRekeningKoran"
                                    @change="previewfotoRekeningKoranImage"
                                    class="w-full p-3 hidden"
                                />
                                <img
                                    id="imgfotoRekeningKoran"
                                    v-show="fotoRekeningKoranSrc"
                                    src="/assets/icons/paper-icon.png"
                                    class="mt-4 max-w-full h-auto"
                                    style="
                                        display: none;
                                        width: 50px;
                                        height: 50px;
                                    "
                                />
                                <div
                                    v-if="!fotoRekeningKoranSrc"
                                    class="text-center text-gray-500"
                                >
                                    Klik untuk mengupload gambar
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label
                                for="fotoSlipGaji"
                                class="block text-sm font-medium text-gray-700"
                                >Upload Slip Gaji:</label
                            >
                            <div
                                class="p-4 border-2 border-dashed border-gray-300 rounded-md cursor-pointer"
                                @click="triggerFileInput('fotoSlipGaji')"
                            >
                                <input
                                    type="file"
                                    id="fotoSlipGaji"
                                    @change="previewfotoSlipGajiImage"
                                    class="w-full p-3 hidden"
                                />

                                <div
                                    v-if="!fotoSlipGajiSrc"
                                    class="text-center text-gray-500"
                                >
                                    Klik atau seret file ke sini untuk
                                    mengupload
                                </div>
                                <div
                                    v-else
                                    class="flex items-center gap-2 mt-4"
                                >
                                    <img
                                        src="/assets/icons/paper-icon.png"
                                        alt="File Icon"
                                        style="width: 50px; height: 50px"
                                    />
                                    <!-- Tambahkan path ke ikon file Anda -->
                                    <span>{{ fotoSlipGajiSrc.name }}</span>
                                    <!-- Menampilkan nama file -->
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <input
                                type="checkbox"
                                id="agreement"
                                v-model="agreement"
                                class="mr-2"
                            />
                            <label
                                for="agreement"
                                class="text-sm font-medium text-gray-700"
                            >
                                Saya menyatakan bahwa dokumen dipercayakan
                                kepada ORumah untuk dipergunakan proses
                                pengajuan BI checking/KPR untuk dipergunakan
                                seperlunya.
                            </label>
                            <a
                                href="#"
                                @click="toggleModal"
                                class="text-blue-500 hover:text-blue-700 text-sm ml-2"
                            >
                                Baca lebih lanjut
                            </a>
                        </div>

                        <!-- Modal -->
                        <div
                            v-if="showModal"
                            class="fixed inset-0 bg-black bg-opacity-50 z-50"
                        >
                            <div
                                class="flex justify-center items-center h-full"
                            >
                                <div class="bg-white p-5 rounded-lg">
                                    <h2 class="text-lg font-bold">
                                        Kebijakan Persetujuan
                                    </h2>
                                    <p>
                                        Detail kebijakan persetujuan akan
                                        dijelaskan di sini...
                                    </p>
                                    <button
                                        @click="toggleModal"
                                        class="mt-3 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                                    >
                                        Tutup
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end mt-6">
                            <button
                                type="submit"
                                class="bg-teal-500 hover:bg-teal-600 text-white font-bold py-2 px-4 rounded-md"
                            >
                                Kirim
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </FrontLayout>
</template>
<style scoped>
.container {
    max-width: 7xl;
}
</style>
