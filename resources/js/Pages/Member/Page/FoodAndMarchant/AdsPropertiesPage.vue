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
                            Lokasi
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
                            Iklan Food
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

                        <div class="flex flex-col col-span-2 md:col-span-1">
                            <label
                                for="day"
                                class="text-sm font-medium text-gray-700 mb-2"
                            >
                                Toko Tersedia?
                            </label>
                            <select
                                v-model="shop_available"
                                class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:border-blue-400"
                            >
                                <option value="">Pilih Hari...</option>
                                <option value="Tersedia">Tersedia</option>
                                <option value="Tidak Tersedia">
                                    Tidak Tersedia
                                </option>
                            </select>
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
                                >Alamat:</label
                            >
                            <textarea
                                id="address"
                                v-model="address"
                                class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:border-blue-400"
                                placeholder="Enter Alamat..."
                                style="height: auto"
                            ></textarea>
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
const adsUnique = ref(false);

const available = ref("");
const shop_available = ref("");
const isActive = ref(true); // Default status (Active)
const isrchived = ref(true); // Default status (Active)
const uploadedImages = ref([]);
const newWorkingDays = ref([]);

const props = defineProps({
    isUpdate: Boolean,
    ads: Object,
    data: Object,
    certificate: Object,
    apartmentType: Object,
    propertyType: Object,
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

    // Append form data to FormData
    formData.append("adds", adds.value);
    formData.append("slug", slug.value);
    formData.append("description", description.value);
    formData.append("shop_available", shop_available.value);
    formData.append("isActive", isActive.value);
    formData.append("isrchived", isrchived.value);
    formData.append("address", address.value);

    formData.append("district", district.value);
    formData.append("districtId", districtId.value);
    formData.append("kawasan", kawasan.value);
    formData.append("alamat", alamat.value);
    formData.append("districtLocationLat", districtLocationLat.value);
    formData.append("districtLocationLong", districtLocationLong.value);

    // Append uploaded images to FormData
    uploadedImages.value.forEach((image) => {
        formData.append("uploadedImages[]", image.file);
    });

    // Append new working days to FormData (if needed)
    newWorkingDays.value.forEach((day) => {
        formData.append("newWorkingDays[]", JSON.stringify(day));
    });

    // Send POST request using Axios
    axios
        .post(route("member.food.store"), formData, {
            headers: {
                "Content-Type": "multipart/form-data", // Important for file uploads
            },
        })
        .then((response) => {
            console.log("Response from Laravel:", response.data);
            // Handle response if needed
            window.location.href = route("member.food");
        })
        .catch((error) => {
            console.error("Error submitting form:", error);
            // Handle error if any
        });
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
