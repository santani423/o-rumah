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
                        Transaksi
                    </h3>
                </div>

                <!-- Card Body -->
                <div>
                    <!-- Tampilkan isi card body di sini, contoh menggunakan MyAds component -->
                    <DataTransaksi :transaksi="transaksi" />
                </div>
            </div>
        </div>
    </ListingLayout>
</template>

<script setup>
import ListingLayout from "@/Pages/Listing/components/ListingLayout.vue";
import DataTransaksi from "@/Pages/Member/Page/Transaksi/DataTransaksi.vue";
import { defineProps } from "vue";

// Define props to receive data from parent component
const props = defineProps({
    transaksi: Array, // Menggunakan Array untuk menerima array of objects bank
});

// Debugging to check props received
console.log("Received bank:", props);
</script>
