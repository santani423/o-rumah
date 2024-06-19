<template>
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Foto</th>
                    <th>Nama Pengguan</th>
                    <th>Nomor Telepon</th>
                    <th>Tipe Akun</th>
                    <th>Level</th>
                    <th>Tipe Aktif</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                <!-- Loop through data to create table rows -->
                <tr v-for="(user, index) in user" :key="user.id">
                    <td>{{ index + 1 }}</td>
                    <td
                        style="
                            display: flex;
                            justify-content: center;
                            align-items: center;
                        "
                    >
                        <img
                            :src="user.image"
                            alt="Pengguna Image"
                            style="
                                max-width: 100px;
                                max-height: 100px;
                                border-radius: 50%;
                            "
                        />
                    </td>
                    <td>
                        <p>{{ user.name }}</p>
                        <p>{{ user.username }}</p>
                    </td>
                    <td>
                        <p>{{ user.phone }}</p>
                        <p>{{ user.wa_phone }}</p>
                    </td>
                    <td>{{ user.type }}</td>
                    <td>-</td>
                    <td>
                        <!-- Custom style switch button -->
                        <label class="switch" @click="toggleActive(user)">
                            <input
                                type="checkbox"
                                :checked="user.is_active == 1"
                                disabled
                            />
                            <span class="slider round"></span>
                        </label>
                    </td>
                    <td>
                        <!-- Tombol detail pengguna -->
                        <button @click="redirectToUserDetail(user.id)">
                            Detail
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
import { defineProps } from "vue";
import axios from "axios"; // Import axios library
import { useRouter } from "vue-router";

// Define props to receive data from parent component
const props = defineProps({
    user: Array,
});

const router = useRouter();

// Function to toggle is_active property and send HTTP request
const toggleActive = (property) => {
    // Toggle the is_active property (0 to 1 or 1 to 0)
    property.is_active = property.is_active === 1 ? 0 : 1;

    // Send HTTP request to the specified URL
};

// Function to redirect to user detail page
const redirectToUserDetail = (userId) => {
    window.location.href = route("admin.nav.pengguna.detail", userId);
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
</style>
