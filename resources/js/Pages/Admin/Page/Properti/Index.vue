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
                        {{ title }}
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
                    <button
                        @click="addNewItem"
                        class="px-4 py-2 bg-green-500 text-white rounded-md"
                    >
                        Add
                    </button>
                </div>

                <!-- Card Body -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">
                        Card Body
                    </h3>
                    <!-- Tampilkan isi card body di sini, contoh menggunakan MyAds component -->
                    <DataDisplay :properties="properties" />
                    <!-- Pagination controls -->
                    <div class="pagination-container">
                        <button
                            @click="fetchPreviousPage"
                            :disabled="pagination.current_page === 1"
                        >
                            Previous
                        </button>
                        <span
                            >Page {{ pagination.current_page }} of
                            {{ pagination.last_page }}</span
                        >
                        <button
                            @click="fetchNextPage"
                            :disabled="
                                pagination.current_page === pagination.last_page
                            "
                        >
                            Next
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </ListingLayout>
</template>

<script setup>
import ListingLayout from "@/Pages/Listing/components/ListingLayout.vue";
import DataDisplay from "@/Pages/Admin/Page/Properti/DataProperti.vue";
import { defineProps } from "vue";

// Define props to receive data from parent component
const props = defineProps({
    properties: Array,
    pagination: Array,
    title: Object,
});

// Debugging to check props received
console.log("Received properties:", props);

const fetchPreviousPage = () => {
    if (properties.current_page > 1) {
        axios.get(properties.prev_page_url).then((response) => {
            properties = response.data;
        });
    }
};

const fetchNextPage = () => {
    if (properties.current_page < properties.last_page) {
        axios.get(properties.next_page_url).then((response) => {
            properties = response.data;
        });
    }
};

const addNewItem = () => {
    // Add your logic to handle adding a new item here
    window.location.href = route("admin.nav.lelang.create");
};
</script>
<style scoped>
/* Add your scoped styles here */
.table-container {
    width: 100%;
    overflow-x: auto;
}

.table {
    width: 100%;
    border-collapse: collapse;
}

.table th,
.table td {
    border: 1px solid #ccc;
    padding: 8px;
}

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

.pagination-container {
    margin-top: 20px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.pagination-container button {
    margin: 0 5px;
    padding: 8px 12px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.pagination-container button:disabled {
    background-color: #ccc;
    cursor: not-allowed;
}
</style>
