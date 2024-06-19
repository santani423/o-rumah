<template>
    <ListingLayout>
        <Head title="Dashboard" />
        <div class="pb-36">
            <div class="bg-white shadow-md rounded-lg p-4">
                <!-- Card Header -->

                <div class="flex items-center justify-between pb-4 mb-4">
                    <h3 class="text-xl font-semibold text-gray-800">Banner</h3>
                    <div class="flex items-center">
                        <button
                            type="submit"
                            class="ml-3 px-4 py-2 bg-green-500 text-white rounded-md"
                            @click="addBanner"
                        >
                            Add Banner
                        </button>
                    </div>
                </div>

                <!-- Card Body -->
                <div>
                    <!-- Tampilkan isi card body di sini, contoh menggunakan MyAds component -->
                    <DataBanner :banner="banner" />
                </div>
            </div>
        </div>
    </ListingLayout>
</template>

<script setup>
import ListingLayout from "@/Pages/Listing/components/ListingLayout.vue";
import DataBanner from "@/Pages/Admin/Page/Banner/DataBanner.vue";
import { defineProps } from "vue";
import VLazyImage from "v-lazy-image";

// Define props to receive data from parent component
const props = defineProps({
    banner: Array,
});

// Debugging to check props received
console.log("Received bank:", props);

// Method to handle adding a banner
const addBanner = () => {
    // Add logic here to handle adding a banner
    window.location.href = route("admin.nav.banner.create");
};
</script>
