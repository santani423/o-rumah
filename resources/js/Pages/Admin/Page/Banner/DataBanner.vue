<template>
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>banner</th>
                    <th>Nama banner</th>
                    <th>Tampilkan Di?</th>
                    <th>Aktif</th>
                </tr>
            </thead>
            <tbody>
                <!-- Loop through data to create table rows -->
                <tr v-for="(banner, index) in banner" :key="banner.id">
                    <td>{{ index + 1 }}</td>
                    <td>
                        <img
                            :src="'/storage/' + banner.image"
                            :alt="banner.image"
                            style="max-width: 100px; max-height: 100px"
                        />
                    </td>
                    <td>
                        <p>{{ banner.name }}</p>
                        <p></p>
                        <p style="color: gray">{{ banner.description }}</p>
                        <p></p>
                    </td>
                    <td>{{ banner.show_on }}</td>
                    <td>
                        <div class="action-buttons">
                            <label class="switch" @click="toggleActive(banner)">
                                <input
                                    type="checkbox"
                                    :checked="banner.is_active == 1"
                                    disabled
                                />
                                <span class="slider round"></span>
                            </label>
                            <button
                                class="btnedit ml-2"
                                @click="editBanner(banner.id)"
                            >
                                Edit
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
import { defineProps } from "vue";
import axios from "axios"; // Import axios library
import VLazyImage from "v-lazy-image";

// Define props to receive data from parent component
const props = defineProps({
    banner: Array,
});
const toggleActive = (property) => {
    // Toggle the is_active property (0 to 1 or 1 to 0)
    property.is_active = property.is_active === 1 ? 0 : 1;
};

const editBanner = (id) => {
    // Redirect to nav.banner.edit with the banner ID
    window.location.href = route("admin.nav.banner.edit", id);
};
</script>

<style scoped>
/* Styling for the table */
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

.btnedit {
    background-color: #4caf50; /* Warna latar hijau */
    color: white; /* Warna teks putih */
    padding: 8px 16px; /* Padding tombol */
    text-align: center; /* Teks rata tengah */
    text-decoration: none; /* Tanpa dekorasi teks */
    display: inline-block; /* Tampilan inline block */
    border-radius: 4px; /* Sudut bulat */
}

.btnedit:hover {
    background-color: #45a049; /* Warna latar hijau saat dihover */
}
</style>
