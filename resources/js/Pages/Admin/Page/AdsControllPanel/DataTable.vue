<template>
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Nilai</th>
                    <th>Klik</th>
                    <th>Deskripsi</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(data, index) in data" :key="data.id">
                    <td>{{ index + 1 }}</td>
                    <td>{{ data.title }}</td>
                    <td>
                        <input
                            type="number"
                            v-model="data.nilai"
                            class="form-input"
                        />
                    </td>
                    <td>
                        <input
                            type="number"
                            v-model="data.klik"
                            class="form-input"
                        />
                    </td>
                    <td>
                        <input
                            type="text"
                            v-model="data.description"
                            class="form-input"
                        />
                    </td>
                    <td>
                        <button
                            @click="saveData(data)"
                            type="button"
                            class="ml-2 px-4 py-2 bg-blue-500 text-white rounded-md"
                        >
                            Simpan
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
import { defineProps } from "vue";
import axios from "axios";

// Define props to receive data from parent component
const props = defineProps({
    data: Array,
});

const saveData = async (data) => {
    const formData = new FormData();
    Object.keys(data).forEach((key) => formData.append(key, data[key]));

    try {
        const response = await axios.post(
            route("admin.nav.ads.control-panel.update", { id: data.id }),
            formData,
            {
                headers: {
                    "Content-Type": "multipart/form-data", // Penting untuk upload file
                },
            }
        );
        console.log("Response from Laravel:", response.data);
        alert("Berhasil DI Simpan.");
    } catch (error) {
        console.error("Error submitting form:", error);
        alert("Gagal menyimpan data.");
    }
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
