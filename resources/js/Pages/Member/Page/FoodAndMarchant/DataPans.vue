<template>
    <div class="card">
        <div class="card-header">Daftar Iklan</div>
        <div class="card-body">
            <div class="card">
                <!-- Added card wrapper -->
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Gambar</th>
                                <th>Judul Iklan</th>
                                <th>Status Iklan</th>
                                <th>Aktif?</th>
                                <th>Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Loop through data to create table rows -->
                            <tr v-for="(ads, index) in ads" :key="ads.id">
                                <td class="text-center">{{ index + 1 }}</td>
                                <td class="img-container">
                                    <img
                                        :src="ads.image"
                                        :alt="ads.image"
                                        class="responsive-img"
                                    />
                                </td>
                                <!-- Changed for image display and responsiveness -->
                                <td>{{ ads.title }}</td>
                                <td>{{ ads.status }}</td>
                                <td>
                                    <label
                                        class="switch"
                                        @click="toggleActive(ads)"
                                    >
                                        <input
                                            type="checkbox"
                                            :checked="ads.is_active == 1"
                                            disabled
                                        />
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td>
                                    <button @click="editAd(ads)">Edit</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { defineProps } from "vue";
import axios from "axios";
const props = defineProps({
    ads: Array,
});
const toggleActive = (property) => {
    // Toggle the is_active property (0 to 1 or 1 to 0)
    property.is_active = property.is_active === 1 ? 0 : 1;
    console.log("property", property);
    const formData = new FormData();
    formData.append("is_active", property.is_active);
    formData.append("id", property.ads_id);
    axios
        .post(route("member.tools.food.foodSetActive"), formData, {
            headers: {
                "Content-Type": "multipart/form-data", // Important for file uploads
            },
        })
        .then((response) => {
            console.log("Response from Laravel:", response.data);
        })
        .catch((error) => {
            console.error("Error submitting form:", error);
            // Handle error if any
        });
};
const editAd = (ad) => {
    // Logic for editing the ad
    console.log("Editing ad:", ad);
    // Add your edit logic here
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
    border-top: 1px solid #ccc; /* Pertahankan garis horizontal atas */
    border-bottom: 1px solid #ccc; /* Pertahankan garis horizontal bawah */
    padding: 8px;
}

/* Menghilangkan garis vertikal antar kolom */
.table th {
    border-left: none; /* Hilangkan garis vertikal di sebelah kiri */
    border-right: none; /* Hilangkan garis vertikal di sebelah kanan */
}

.table td {
    border-left: none; /* Hilangkan garis vertikal di sebelah kiri */
    border-right: none; /* Hilangkan garis vertikal di sebelah kanan */
}

.text-center {
    text-align: center;
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

/* Styling for the card */
.card {
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.card-header {
    background-color: #f5f5f5;
    padding: 16px;
    font-weight: bold;
}

.card-body {
    padding: 16px;
}

.img-container {
    width: 100%; /* Atur lebar container sesuai dengan lebar kolom */
    text-align: center; /* Pusatkan gambar */
}

.responsive-img {
    max-width: 10vw; /* Membuat gambar responsive dan menyesuaikan dengan pembungkusnya */
    height: auto; /* Menjaga aspek rasio gambar */
    border-radius: 5px; /* Opsional: Tambahkan border-radius untuk estetika */
}

.table td.img-container {
    width: 11vw; /* Membuat lebar kolom menyesuaikan konten */
}
</style>
