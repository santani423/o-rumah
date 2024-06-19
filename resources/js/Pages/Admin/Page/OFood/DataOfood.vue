<template>
    <div class="table-container">
        <div class="table-responsive">
            <!-- Tambahkan div untuk mengelilingi tabel -->
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Gambar Iklan</th>
                        <th>Judul Iklan</th>
                        <th>Di Upload Oleh</th>
                        <th>Stastus Iklan</th>
                        <th>Aktif</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Loop through data to create table rows -->
                    <tr v-for="(property, index) in OFood" :key="property.id">
                        <td>{{ index + 1 }}</td>
                        <td>
                            <img
                                :src="property.image_path"
                                alt="Iklan Image"
                                style="max-width: 100px; max-height: 100px"
                            />
                        </td>
                        <td>{{ property.title }}</td>
                        <td>{{ property.name_user }}</td>
                        <td>
                            <span
                                :class="{
                                    'badge-green':
                                        property.status.toLowerCase() ===
                                        'available',
                                    'badge-red':
                                        property.status.toLowerCase() !==
                                        'available',
                                }"
                            >
                                {{ property.status }}
                            </span>
                        </td>
                        <td>
                            <!-- Custom style switch button -->
                            <label
                                class="switch"
                                @click="toggleActive(property)"
                            >
                                <input
                                    type="checkbox"
                                    :checked="property.is_active == 1"
                                    disabled
                                />
                                <span class="slider round"></span>
                            </label>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script setup>
import { defineProps } from "vue";
import axios from "axios"; 

// Define props to receive data from parent component
const props = defineProps({
    OFood: Array,
});

// Function to toggle is_active property and send HTTP request
const toggleActive = (property) => {
    // Toggle the is_active property (0 to 1 or 1 to 0)
    property.is_active = property.is_active === 1 ? 0 : 1;

    // Send HTTP request to the specified URL
    axios
        .post(route("managementAds.setActifity"), {
            is_active: property.is_active,
            ads_id: property.ads_id,
        })
        .then((response) => {
            console.log("HTTP request sent successfully:", response.data);
        })
        .catch((error) => {
            console.error("Error sending HTTP request:", error);
        });
};

// Debugging to check props received
console.log("Received OFood in component:", props);
</script>

<style scoped>
/* Styling for the table container */
.table-container {
    width: 100%;
    overflow-x: auto; /* Mengaktifkan horizontal scrolling saat melebihi lebar layar */
}

/* Styling for the responsive table */
.table-responsive {
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
    white-space: nowrap; /* Mencegah teks panjang wrap ke baris baru */
}

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
</style>
