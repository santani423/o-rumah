<template>
    <ListingLayout>
        <Head title="Dashboard" />

        <form @submit.prevent="submit" enctype="multipart/form-data">
            <div class="pb-36">
                <!-- Existing Content -->

                <div class="bg-white shadow-md rounded-lg p-4 mt-4">
                    <!-- Card Header -->
                    <div
                        class="flex items-center justify-between border-b border-gray-300 pb-4 mb-4"
                    >
                        <h3 class="text-xl font-semibold text-gray-800">
                            Lokasi Properti
                        </h3>
                    </div>

                    <!-- Card Body -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Card Body info lokasi -->
                        <div class="flex items-center justify-between">
                            <div>
                                <h5 class="mb-1 font-medium">
                                    {{ data.district }}
                                </h5>
                                <p class="text-sm font-normal text-neutral-500">
                                    {{ data.alamat }}
                                </p>
                            </div>
                            <a
                                v-if="isUpdate == true"
                                class="px-4 py-2 text-sm rounded-md cursor-pointer bg-neutral-100 text-neutral-600"
                                :href="route('listing.editLocation', ads.id)"
                            >
                                Ubah Lokasi
                            </a>
                            <a
                                v-else
                                class="px-4 py-2 text-sm rounded-md cursor-pointer bg-neutral-100 text-neutral-600"
                                onclick="window.history.back()"
                            >
                                Ubah Lokasi
                            </a>
                        </div>
                    </div>
                </div>
                <div class="bg-white shadow-md rounded-lg p-4 mt-3">
                    <!-- Card Header -->
                    <div
                        class="flex items-center justify-between border-b border-gray-300 pb-4 mb-4"
                    >
                        <h3 class="text-xl font-semibold text-gray-800">
                            Iklan Properti
                        </h3>
                    </div>

                    <!-- Card Body -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Existing Form Elements -->
                        <div class="flex flex-col">
                            <label
                                for="adds"
                                class="text-sm font-medium text-gray-700 mb-2"
                                >Adds:</label
                            >
                            <input
                                id="addsInput"
                                type="text"
                                v-model="adds"
                                @change="handleAddsChange"
                                class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:border-blue-400"
                                placeholder="Enter Adds..."
                            />
                            <p v-if="adsUnique" class="text-sm text-red-500">
                                Judul iklan sudah digunakan. Harap masukkan
                                judul iklan yang unik.
                            </p>
                        </div>

                        <div class="flex flex-col">
                            <label
                                for="slug"
                                class="text-sm font-medium text-gray-700 mb-2"
                                >Slug:</label
                            >
                            <input
                                id="slugInput"
                                type="text"
                                v-model="slug"
                                class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:border-blue-400"
                                placeholder="Enter Slug..."
                                readonly
                            />
                        </div>

                        <div class="flex flex-col col-span-2">
                            <label
                                for="description"
                                class="text-sm font-medium text-gray-700 mb-2"
                                >Description:</label
                            >
                            <textarea
                                id="description"
                                v-model="description"
                                class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:border-blue-400"
                                placeholder="Enter Description..."
                                style="height: auto"
                            ></textarea>
                        </div>

                        <div class="flex flex-wrap gap-2">
                            <label
                                for="day"
                                class="text-sm font-medium text-gray-700 mb-2"
                            >
                                Tipe properti*
                            </label>
                            <div
                                class="break-inside-avoid pt-3 flex flex-wrap gap-2"
                                v-for="(prt, index) in propertyType"
                                :key="index"
                            >
                                <label
                                    class="fi-btn relative grid-flow-col items-center justify-center font-semibold outline-none transition duration-75 focus-visible:ring-2 rounded-lg cursor-pointer fi-color-custom fi-btn-color-primary fi-size-md fi-btn-size-md gap-1.5 px-3 py-2 text-sm inline-grid shadow-sm bg-blue text-gray-950 dark:bg-blue/5 dark:text-white ring-1 ring-gray-950/10 dark:ring-white/20 [input:checked+&amp;]:bg-custom-600 [input:checked+&amp;]:text-white [input:checked+&amp;]:ring-0 [input:checked+&amp;] dark:[input:checked+&amp;]:bg-custom-500 dark:[input:checked+&amp;]:hover:bg-custom-400 [input:checked:focus-visible+&amp;]:ring-custom-500/50 dark:[input:checked:focus-visible+&amp;]:ring-custom-400/50 [input:focus-visible+&amp;]:z-10 [input:focus-visible+&amp;]:ring-2 [input:focus-visible+&amp;]:ring-gray-950/10 dark:[input:focus-visible+&amp;]:ring-white/20"
                                    for="data.property.property_type-Apartemen"
                                    :class="{
                                        'bg-blue-500 text-white':
                                            selectedProperty === prt,
                                    }"
                                    @click="logPropertyType(prt)"
                                >
                                    <span class="fi-btn-label">
                                        {{ prt }}
                                    </span>
                                </label>
                            </div>
                        </div>
                        <div class="flex flex-col col-span-2 md:col-span-1">
                            <label
                                for="hargaInput"
                                class="text-sm font-medium text-gray-700 mb-2"
                            >
                                Harga
                            </label>
                            <div class="relative">
                                <span
                                    class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500"
                                >
                                    Rp
                                </span>
                                <input
                                    id="hargaInput"
                                    type="text"
                                    v-model="harga"
                                    class="border border-gray-300 rounded-md pl-10 pr-3 py-2 focus:outline-none focus:border-blue-400"
                                    placeholder="Enter Harga..."
                                />
                            </div>
                        </div>
                        <div class="flex flex-col col-span-2 md:col-span-1">
                            <label
                                for="day"
                                class="text-sm font-medium text-gray-700 mb-2"
                            >
                                Video
                            </label>
                            <input
                                id="videoYoutubeInput"
                                type="text"
                                v-model="videoYoutube"
                                @change="handleAddsChange"
                                class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:border-blue-400"
                                placeholder="Enter Video..."
                            />
                            <p class="text-sm text-gray-500">
                                Contoh:
                                https://www.youtube.com/watch?v=9bZkp7q19f0
                            </p>
                        </div>

                        <div class="flex flex-col col-span-2 md:col-span-1">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div
                                    class="flex flex-col col-span-2 md:col-span-1"
                                >
                                    <label
                                        for="status"
                                        class="text-sm font-medium text-gray-700 mb-2"
                                        >Aktif?</label
                                    >
                                    <label class="switch">
                                        <input
                                            type="checkbox"
                                            v-model="isActive"
                                            class="switch-input"
                                            @change="toggleActive"
                                        />
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div
                                    class="flex flex-col col-span-2 md:col-span-1"
                                >
                                    <label
                                        for="status"
                                        class="text-sm font-medium text-gray-700 mb-2"
                                        >Di Arsipkan?</label
                                    >
                                    <label class="switch">
                                        <input
                                            type="checkbox"
                                            v-model="isrchived"
                                            class="switch-input"
                                            @change="toggleArchived"
                                        />
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white shadow-md rounded-lg p-4 mt-4">
                    <!-- Card Header -->
                    <div
                        class="flex items-center justify-between border-b border-gray-300 pb-4 mb-4"
                    >
                        <h3 class="text-xl font-semibold text-gray-800">
                            Foto Iklan
                        </h3>
                    </div>

                    <!-- Card Body -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Image Upload Section -->
                        <div class="flex flex-col col-span-2">
                            <input
                                type="file"
                                multiple
                                @change="handleImageUpload"
                                class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:border-blue-400"
                            />
                            <div v-if="uploadedImages.length > 0" class="mt-4">
                                <h4
                                    class="text-sm font-medium text-gray-700 mb-2"
                                >
                                    Gambar yang diunggah:
                                </h4>
                                <div
                                    v-for="(image, index) in uploadedImages"
                                    :key="index"
                                    class="flex items-center mt-3"
                                >
                                    <img
                                        :src="image.url"
                                        alt="Uploaded Image"
                                        class="w-20 h-20 object-cover mr-2 rounded-md"
                                    />
                                    <button
                                        @click="deleteImage(index)"
                                        class="text-red-500 focus:outline-none"
                                    >
                                        Hapus
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white shadow-md rounded-lg p-4 mt-4">
                    <!-- Card Header -->
                    <div
                        class="flex items-center justify-between border-b border-gray-300 pb-4 mb-4"
                    >
                        <h3 class="text-xl font-semibold text-gray-800">
                            Informasi Tambahan
                        </h3>
                    </div>

                    <!-- Card Body -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex flex-col col-span-2">
                            <label
                                for="address"
                                class="text-sm font-medium text-gray-700 mb-2"
                                >Nama komplek:</label
                            >

                            <input
                                id="namaKomplekInput"
                                type="text"
                                v-model="namaKomplek"
                                @change="handleAddsChange"
                                class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:border-blue-400"
                                placeholder=" "
                            />
                        </div>
                        <div class="flex flex-col col-span-2">
                            <label
                                for="address"
                                class="text-sm font-medium text-gray-700 mb-2"
                                >Nama cluster:</label
                            >

                            <input
                                id="namaClusterInput"
                                type="text"
                                v-model="namaCluster"
                                @change="handleAddsChange"
                                class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:border-blue-400"
                                placeholder=" "
                            />
                        </div>
                        <div class="flex flex-col">
                            <label
                                for="luasTanah"
                                class="text-sm font-medium text-gray-700 mb-2"
                            >
                                Luas tanah:
                            </label>
                            <div class="relative flex items-center">
                                <input
                                    id="luasTanahInput"
                                    type="Number"
                                    v-model="luasTanah"
                                    class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:border-blue-400"
                                    placeholder="Enter Luas Tanah..."
                                />
                                <span class="text-gray-500 ml-3">M2</span>
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <label
                                for="luasBangunanInput"
                                class="text-sm font-medium text-gray-700 mb-2"
                                >Luas bangunan:</label
                            >
                            <div class="relative flex items-center">
                                <input
                                    id="luasBangunanInput"
                                    type="Number"
                                    v-model="luasBangunan"
                                    class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:border-blue-400"
                                    placeholder="Enter Luas Tanah..."
                                />
                                <span class="text-gray-500 ml-3">M2</span>
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <label
                                for="tahunDiBangunInput"
                                class="text-sm font-medium text-gray-700 mb-2"
                                >Tahun dibangun:</label
                            >
                            <input
                                id="tahunDiBangunInput"
                                type="Number"
                                v-model="tahunDiBangun"
                                class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:border-blue-400"
                                placeholder="Enter Tahun di bangun..."
                            />
                        </div>
                        <div class="flex flex-col">
                            <label
                                for="dayaListrikInput"
                                class="text-sm font-medium text-gray-700 mb-2"
                                >Daya listrik:</label
                            >
                            <div class="relative flex items-center">
                                <input
                                    id="dayaListrikInput"
                                    type="Number"
                                    v-model="dayaListrik"
                                    class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:border-blue-400"
                                    placeholder="Enter Daya Listrik..."
                                />
                                <span class="text-gray-500 ml-3">WAT</span>
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <label
                                for="kamarTidurInput"
                                class="text-sm font-medium text-gray-700 mb-2"
                                >Kamar tidur:</label
                            >
                            <input
                                id="kamarTidurInput"
                                type="Number"
                                v-model="kamarTidur"
                                class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:border-blue-400"
                                placeholder="Enter Kamar Tidur..."
                            />
                        </div>
                        <div class="flex flex-col">
                            <label
                                for="kamarMandiInput"
                                class="text-sm font-medium text-gray-700 mb-2"
                                >Kamar mandi:</label
                            >
                            <input
                                id="kamarMandiInput"
                                type="text"
                                v-model="kamarMandi"
                                class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:border-blue-400"
                                placeholder="Enter Kamar Mandi..."
                            />
                        </div>
                        <div class="flex flex-col">
                            <label
                                for="lantaiInput"
                                class="text-sm font-medium text-gray-700 mb-2"
                                >Lantai:</label
                            >
                            <input
                                id="lantaiInput"
                                type="text"
                                v-model="lantai"
                                class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:border-blue-400"
                                placeholder="Enter Jumlah Lantai..."
                            />
                        </div>
                        <div class="flex flex-col">
                            <label
                                for="jenisSertifikat"
                                class="text-sm font-medium text-gray-700 mb-2"
                            >
                                Jenis Sertifikat:
                            </label>
                            <select
                                v-model="jenisSertifikat"
                                class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:border-blue-400"
                            >
                                <option value="">
                                    Pilih Jenis Sertifikat...
                                </option>
                                <option
                                    v-for="(sertifikat, index) in certificate"
                                    :key="index"
                                    :value="sertifikat"
                                >
                                    {{ sertifikat }}
                                </option>
                            </select>
                        </div>
                        <div class="flex flex-col">
                            <div class="flex flex-col">
                                <label
                                    for="fasilitasRumah"
                                    class="text-sm font-medium text-gray-700 mb-2"
                                >
                                    Fasilitas rumah:
                                </label>
                                <div class="flex flex-col space-y-2">
                                    <div class="flex items-center">
                                        <input
                                            type="checkbox"
                                            id="ac"
                                            v-model="fasilitas"
                                            value="AC"
                                            class="telwin-checkbox"
                                        />
                                        <label for="ac" class="telwin-label"
                                            >AC</label
                                        >
                                    </div>
                                    <div class="flex items-center">
                                        <input
                                            type="checkbox"
                                            id="kolamRenang"
                                            v-model="fasilitas"
                                            value="Kolam Renang"
                                            class="telwin-checkbox"
                                        />
                                        <label
                                            for="kolamRenang"
                                            class="telwin-label"
                                            >Kolam Renang</label
                                        >
                                    </div>
                                    <div class="flex items-center">
                                        <input
                                            type="checkbox"
                                            id="tvKabel"
                                            v-model="fasilitas"
                                            value="TV Kabel"
                                            class="telwin-checkbox"
                                        />
                                        <label
                                            for="tvKabel"
                                            class="telwin-label"
                                            >TV Kabel</label
                                        >
                                    </div>
                                    <div class="flex items-center">
                                        <input
                                            type="checkbox"
                                            id="internet"
                                            v-model="fasilitas"
                                            value="Internet"
                                            class="telwin-checkbox"
                                        />
                                        <label
                                            for="internet"
                                            class="telwin-label"
                                            >Internet</label
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col">
                            <div class="flex flex-col">
                                <label
                                    for="kondisiPerabotan"
                                    class="text-sm font-medium text-gray-700 mb-2"
                                >
                                    Kondisi Perabotan:
                                </label>
                                <div class="flex items-center">
                                    <input
                                        type="radio"
                                        id="furnished"
                                        v-model="kondisiPerabotan"
                                        value="Furnished"
                                        class="telwin-radio"
                                        name="kondisiPerabotan"
                                    />
                                    <label for="furnished" class="telwin-label"
                                        >Furnished</label
                                    >
                                </div>
                                <div class="flex items-center">
                                    <input
                                        type="radio"
                                        id="semiFurnished"
                                        v-model="kondisiPerabotan"
                                        value="Semi-Furnished"
                                        class="telwin-radio"
                                        name="kondisiPerabotan"
                                    />
                                    <label
                                        for="semiFurnished"
                                        class="telwin-label"
                                        >Semi-Furnished</label
                                    >
                                </div>
                                <div class="flex items-center">
                                    <input
                                        type="radio"
                                        id="unfurnished"
                                        v-model="kondisiPerabotan"
                                        value="Unfurnished"
                                        class="telwin-radio"
                                        name="kondisiPerabotan"
                                    />
                                    <label
                                        for="unfurnished"
                                        class="telwin-label"
                                        >Unfurnished</label
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <label
                                for="fasilitasRumah"
                                class="text-sm font-medium text-gray-700 mb-2"
                            >
                                Kondisi Lingkungan:
                            </label>
                            <div class="flex flex-col space-y-2">
                                <div
                                    v-for="(
                                        condition, index
                                    ) in environmentalConditions"
                                    :key="index"
                                    class="flex items-center"
                                >
                                    <input
                                        type="checkbox"
                                        :id="condition"
                                        v-model="other_facility"
                                        :value="condition"
                                        class="telwin-checkbox"
                                    />
                                    <label
                                        :for="condition"
                                        class="telwin-label"
                                        >{{ condition }}</label
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end my-3">
                    <button
                        type="submit"
                        class="bg-neutral-600 disabled:bg-[#EAEBF0] disabled:text-[#B1B2CE] text-white py-2 px-4 rounded-md"
                    >
                        {{ isUpdate ? "Ubah" : "Buat" }} Iklan
                    </button>
                </div>
            </div>
        </form>
    </ListingLayout>
</template>

<script setup>
import ListingLayout from "@/Pages/Listing/components/ListingLayout.vue";
import { ref, watch } from "vue";
import axios from "axios";

const adds = ref("");
const slug = ref("");
const address = ref("");
const description = ref("");
const selectedProperty = ref("");
const adsUnique = ref(false);

const available = ref("");
const shop_available = ref("");
const isActive = ref(true); // Default status (Active)
const isrchived = ref(true); // Default status (Active)
const uploadedImages = ref([]);
const newWorkingDays = ref([]);
const harga = ref("");
const videoYoutube = ref("");
const namaKomplek = ref("");
const namaCluster = ref("");
const luasTanah = ref("");
const luasBangunan = ref("");
const tahunDiBangun = ref("");
const dayaListrik = ref("");
const kamarTidur = ref("");
const kamarMandi = ref("");
const lantai = ref("");
const jenisSertifikat = ref("");
const fasilitas = ref([]);
const other_facility = ref([]);
const kondisiPerabotan = ref("");

// Fungsi untuk mengubah format input harga menjadi format rupiah
const formatToRupiah = (value) => {
    const formatter = new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
        minimumFractionDigits: 0,
    });
    return formatter
        .format(value)
        .replace("Rp", "")
        .replace(/\D00(?=\D*$)/, "");
};

// Watcher untuk memantau perubahan pada input harga dan mengupdate nilai dengan format rupiah
watch(harga, (newValue) => {
    // Menghapus tanda titik sebelum mengubah format ke rupiah
    const numericValue = Number(newValue.replace(/\D/g, ""));
    harga.value = formatToRupiah(numericValue);
});

const props = defineProps({
    isUpdate: Boolean,
    ads: Object,
    data: Object,
    certificate: Object,
    apartmentType: Object,
    propertyType: Object,
    environmentalConditions: Object,
});
const district = ref(props.data ? props.data.district : "");
const districtId = ref(props.data ? props.data.districtId : "");
const kawasan = ref(props.data ? props.data.kawasan : "");
const alamat = ref(props.data ? props.data.alamat : "");
const districtLocationLat = ref(
    props.data ? props.data.districtLocation["lat"] : ""
);
const districtLocationLong = ref(
    props.data ? props.data.districtLocation["long"] : ""
);

const addWorkingDayForm = () => {
    newWorkingDays.value.push({
        day: "",
        open: "",
        close: "",
    });
};

const handleImageUpload = (event) => {
    const files = event.target.files;
    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        // Buat objek URL untuk gambar yang akan diunggah
        const imageUrl = URL.createObjectURL(file);
        // Tambahkan objek gambar ke daftar uploadedImages
        uploadedImages.value.push({ url: imageUrl, file });
    }
};

const deleteImage = (index) => {
    const deletedImage = uploadedImages.value.splice(index, 1);
    // Hapus objek URL yang telah dibuat sebelumnya dari revoked URL
    URL.revokeObjectURL(deletedImage[0].url);
};

const toggleActive = () => {};
const toggleArchived = () => {};

// Fungsi baru untuk menangani perubahan pada input adds
const handleAddsChange = (event) => {
    console.log("Nilai adds berubah menjadi:", event.target.value);
    const formData = new FormData();
    formData.append("adds", event.target.value);

    axios
        .post(route("member.tools.checkUniqueTitleAds"), formData, {
            headers: {
                "Content-Type": "multipart/form-data",
            },
        })
        .then((response) => {
            const addsInput = document.getElementById("addsInput");
            if (!response.data.isUnique) {
                addsInput.setCustomValidity(
                    "Judul iklan sudah digunakan. Harap masukkan judul iklan yang unik."
                );
            } else {
                addsInput.setCustomValidity("");
            }
        })
        .catch((error) => {
            console.error("Error checking ad title uniqueness:", error);
        });
};

watch(adds, (newValue, oldValue) => {
    console.log(`Nilai baru: ${newValue}, Nilai lama: ${oldValue}`);
    const formData = new FormData();

    formData.append("adds", newValue);
    axios
        .post(route("member.tools.checkUniqueTitleAds"), formData, {
            headers: {
                "Content-Type": "multipart/form-data", // Important for file uploads
            },
        })

        .then((response) => {
            const addsInput = document.getElementById("addsInput");
            if (!response.data.isUnique) {
                addsInput.setCustomValidity(
                    "Judul iklan sudah digunakan. Harap masukkan judul iklan yang unik."
                );
                adsUnique.value = true;
            } else {
                addsInput.setCustomValidity("");
                adsUnique.value = false;
            }
            console.log("Response from Laravel:", response.data);
        })
        .catch((error) => {
            console.error("Error submitting form:", error);
            // Handle error if any
        });
});

// Fungsi untuk mengubah nilai adds menjadi format slug
const formatToSlug = (text) => {
    return text
        .toLowerCase()
        .replace(/ /g, "-")
        .replace(/[^\w-]+/g, "");
};

// Watcher untuk memantau perubahan pada adds dan mengupdate nilai slug
watch(adds, (newValue) => {
    slug.value = formatToSlug(newValue);
});

const submit = () => {
    const formData = new FormData();
    formData.append("adds", adds.value);
    formData.append("slug", slug.value);
    formData.append("description", description.value);
    formData.append("selectedProperty", selectedProperty.value);
    formData.append("harga", harga.value);
    formData.append("videoYoutube", videoYoutube.value);
    formData.append("isActive", isActive.value);
    formData.append("isrchived", isrchived.value);
    // Append uploaded images to FormData
    uploadedImages.value.forEach((image) => {
        formData.append("uploadedImages[]", image.file);
    });
    formData.append("namaKomplek", namaKomplek.value);
    formData.append("namaCluster", namaCluster.value);
    formData.append("luasTanah", luasTanah.value);
    formData.append("luasBangunan", luasBangunan.value);
    formData.append("tahunDiBangun", tahunDiBangun.value);
    formData.append("dayaListrik", dayaListrik.value);
    formData.append("kamarTidur", kamarTidur.value);
    formData.append("kamarMandi", kamarMandi.value);
    formData.append("lantai", lantai.value);
    formData.append("jenisSertifikat", jenisSertifikat.value);
    formData.append("fasilitas", JSON.stringify(fasilitas.value));
    formData.append("kondisiPerabotan", kondisiPerabotan.value);
    formData.append("other_facility", JSON.stringify(other_facility.value));
    formData.append("districtId", districtId.value);
    formData.append("districtLocationLat", districtLocationLat.value);
    formData.append("districtLocationLong", districtLocationLong.value);
    formData.append("kawasan", kawasan.value);
    formData.append("alamat", alamat.value);

    axios
        .post(route("listing.storeAds"), formData, {
            headers: {
                "Content-Type": "multipart/form-data",
            },
        })
        .then((response) => {
            console.log("Response from Laravel:", response.data);
            window.location.href = route("listing.index");
        })
        .catch((error) => {
            console.error("Error submitting form:", error);
        });
};

const logPropertyType = (propertyType) => {
    console.log("Tipe Properti yang dipilih:", propertyType);
    selectedProperty.value = propertyType; // Mengubah nilai selectedProperty dengan nilai propertyType yang dipilih
};
</script>

<style scoped>
/* Styling for custom switch button */
.switch {
    position: relative;
    display: inline-block;
    width: 40px;
    height: 20px;
    cursor: pointer;
}

.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: 0.4s;
    border-radius: 20px;
}

.slider:before {
    position: absolute;
    content: "";
    height: 14px;
    width: 14px;
    left: 3px;
    bottom: 3px;
    background-color: white;
    transition: 0.4s;
    border-radius: 50%;
}

input:checked + .slider {
    background-color: #007bff; /* warna hijau ketika aktif */
}

input:checked + .slider:before {
    transform: translateX(20px);
}

/* Rounded sliders */
.slider.round {
    border-radius: 20px;
}

.slider.round:before {
    border-radius: 50%;
}

.custom-container {
    border: 1px solid #ccc; /* Border abu-abu */
    border-radius: 8px; /* Sudut melengkung */
    padding: 20px; /* Padding */
}
</style>
