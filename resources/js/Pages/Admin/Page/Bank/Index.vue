<template>
    <ListingLayout>
        <Head title="Dashboard" />
        <div class="pb-36">
            <div class="bg-white shadow-md rounded-lg p-4">
                <!-- Card Header -->
                <div
                    class="flex items-center justify-between border-b border-gray-300 pb-4 mb-4"
                >
                    <h3 class="text-xl font-semibold text-gray-800">Bank</h3>
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
                    <!-- Tampilkan isi card body di sini, contoh menggunakan MyAds component -->
                    <Databank :bank="bank" />
                </div>
            </div>
        </div>
    </ListingLayout>
</template>

<script setup>
import ListingLayout from "@/Pages/Listing/components/ListingLayout.vue";
import Databank from "@/Pages/Admin/Page/Bank/DataBank.vue";
import { defineProps } from "vue";

// Define props to receive data from parent component
const props = defineProps({
    bank: Array, // Menggunakan Array untuk menerima array of objects bank
});

// Debugging to check props received
console.log("Received bank:", props);
</script>
