<template>
    <ListingLayout>
        <Head title="Dashboard" />
        <div class="pb-36">
            <div class="bg-white shadow-md rounded-lg p-4">
                <!-- Card Header -->
                <div
                    class="flex items-center justify-between border-b border-gray-300 pb-4 mb-4"
                >
                    <h3 class="text-xl font-semibold text-gray-800">
                        Pengajuan KPR
                    </h3>
                    <form @submit.prevent="search" class="flex items-center">
                        <input
                            v-model="searchQuery"
                            type="text"
                            class="w-48 px-4 py-2 border border-gray-300 rounded-md focus:outline-none"
                            placeholder="Cari..."
                        />
                        <button
                            type="submit"
                            class="ml-2 px-4 py-2 bg-blue-500 text-white rounded-md"
                        >
                            Cari
                        </button>
                    </form>
                </div>

                <!-- Card Body -->
                <div>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Keterangan
                                </th>
                                <th
                                    scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Detail
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"
                                >
                                    Nama Pemohon
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
                                >
                                    {{ kpr.kpr_name }}
                                </td>
                            </tr>
                            <tr>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"
                                >
                                    Email
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
                                >
                                    {{ kpr.kpr_email }}
                                </td>
                            </tr>
                            <tr>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"
                                >
                                    Handphone
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 flex items-center"
                                >
                                    {{ kpr.kpr_phone }}
                                    <a
                                        :href="`https://wa.me/${kpr.kpr_phone}`"
                                        target="_blank"
                                        class="ml-4 px-3 py-1 bg-green-500 text-white rounded-md"
                                    >
                                        WhatsApp
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"
                                >
                                    Pekerjaan
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
                                >
                                    {{ kpr.kpr_occupation }}
                                </td>
                            </tr>
                            <tr>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"
                                >
                                    Bank Umum
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
                                >
                                    {{ kpr.bank_umum_name }}
                                </td>
                            </tr>
                            <tr>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"
                                >
                                    Bank BPR
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
                                >
                                    {{ kpr.bank_bpr_name }}
                                </td>
                            </tr>
                            <tr>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"
                                >
                                    Foto KTP Pemohon/Suami/Istri:
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
                                >
                                    <a :href="kpr.image_ktp" download>
                                        <img
                                            :src="kpr.image_ktp"
                                            :alt="kpr.image_ktp"
                                            class="w-32 h-auto zoom"
                                        />
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"
                                >
                                    Foto Kartu Keluarga:
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
                                >
                                    <a :href="kpr.image_kk" download>
                                        <img
                                            :src="kpr.image_kk"
                                            :alt="kpr.image_kk"
                                            class="w-32 h-auto zoom"
                                        />
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"
                                >
                                    Foto Surat Nikah atau Cerai:
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
                                >
                                    <a :href="kpr.image_surat_nikah" download>
                                        <img
                                            :src="kpr.image_surat_nikah"
                                            :alt="kpr.image_surat_nikah"
                                            class="w-32 h-auto zoom"
                                        />
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"
                                >
                                    Rekening Koran 3 Bulan Terakhir:
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
                                >
                                    <a
                                        :href="kpr.image_rekening_koran"
                                        download
                                    >
                                        <img
                                            :src="kpr.image_rekening_koran"
                                            :alt="kpr.image_rekening_koran"
                                            class="w-32 h-auto zoom"
                                        />
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"
                                >
                                    Slip Gaji:
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
                                >
                                    <a :href="kpr.image_slip_gaji" download>
                                        <img
                                            :src="kpr.image_slip_gaji"
                                            :alt="kpr.image_slip_gaji"
                                            class="w-32 h-auto zoom"
                                        />
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <button
                        @click="downloadAllImages"
                        class="mt-4 px-4 py-2 bg-blue-500 mr-4 text-white rounded-md"
                    >
                        Unduh Semua Dokumen
                    </button>
                    <button
                        @click="senEmail"
                        class="mt-4 px-4 py-2 bg-green-500 text-white rounded-md"
                        :disabled="isLoading"
                    >
                        <span
                            v-if="isLoading"
                            class="spinner-border spinner-border-sm"
                            role="status"
                            aria-hidden="true"
                        ></span>
                        <span v-else>Kirim Email Ke Bank</span>
                    </button>
                </div>
            </div>
        </div>
    </ListingLayout>
</template>

<script setup>
import JSZip from "jszip";
import { saveAs } from "file-saver";
import ListingLayout from "@/Pages/Listing/components/ListingLayout.vue";
import { defineProps, ref } from "vue";
import axios from "axios";

const props = defineProps({
    kpr: Array,
});

const downloadAllImages = async () => {
    const zip = new JSZip();
    const images = [
        props.kpr.image_ktp,
        props.kpr.image_kk,
        props.kpr.image_surat_nikah,
        props.kpr.image_rekening_koran,
        props.kpr.image_slip_gaji,
    ];

    images.forEach((image, index) => {
        const url = image;
        const filename = `Dokumen-${index + 1}.jpg`; // Sesuaikan format dan nama file sesuai kebutuhan

        fetch(url)
            .then((response) => response.blob())
            .then((blob) => {
                zip.file(filename, blob, { binary: true });
                if (index === images.length - 1) {
                    zip.generateAsync({ type: "blob" }).then((content) => {
                        saveAs(content, props.kpr.kpr_name + ".zip");
                    });
                }
            });
    });
};

const isLoading = ref(false);

const senEmail = async () => {
    isLoading.value = true;
    const formData = new FormData();
    formData.append("kpr_id", props.kpr.id);
    formData.append("bank_umum_email", props.kpr.bank_umum_email);
    formData.append("bank_bpr_email", props.kpr.bank_bpr_email);

    try {
        const response = await axios.post(route("admin.email.bank"), formData, {
            headers: {
                "Content-Type": "multipart/form-data",
            },
        });
        console.log("Response from Laravel:", response.data);
        alert(response.data.message);
    } catch (error) {
        console.error("Error submitting form:", error);
        alert("Email Gagal Dikirim");
    } finally {
        isLoading.value = false;
    }
};
</script>

<style scoped>
/* Tambahkan style yang diperlukan di sini */
.zoom:hover {
    transform: scale(2.5); /* Atur skala zoom sesuai kebutuhan */
    transition: transform 0.3s ease-in-out; /* Transisi yang halus */
}

@keyframes spin {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}
.spinner-border {
    display: inline-block;
    width: 1rem;
    height: 1rem;
    vertical-align: text-bottom;
    border: 0.25em solid currentColor;
    border-right-color: transparent;
    border-radius: 50%;
    animation: spin 0.75s linear infinite;
}
</style>
