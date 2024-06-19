<template>
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tanggal Pengajuan</th>
                    <th>Nama Agen</th>
                    <th>Nama Pengajuan</th>
                    <th>No HP Visitor</th>
                    <th>Nama Bank</th>
                    <th>Email PIC Bank</th>
                    <th>Nama Bank BPR</th>
                    <th>Email PIC Bank BPR</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(kpr, index) in kpr" :key="kpr.id">
                    <td>{{ index + 1 }}</td>
                    <td>{{ formatDate(kpr.created_at) }}</td>
                    <td>{{ kpr.namaAgen }}</td>
                    <td>{{ kpr.kpr_name }}</td>
                    <td>{{ kpr.kpr_phone }}</td>
                    <td>{{ kpr.bank_umum_name }}</td>
                    <td>{{ kpr.bank_umum_email }}</td>
                    <td>{{ kpr.bank_bpr_name }}</td>
                    <td>{{ kpr.bank_bpr_email }}</td>

                    <td>
                        <button
                            class="ml-2 px-4 py-2 bg-blue-500 text-white rounded-md"
                            @click="showDetails(kpr)"
                        >
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
import { format } from "date-fns";
import axios from "axios"; // Import axios library
const props = defineProps({
    kpr: Array,
});
const toggleActive = (property) => {
    // Toggle the is_active property (0 to 1 or 1 to 0)
    property.is_active = property.is_active === 1 ? 0 : 1;
};

const showDetails = (kpr) => {
    // Logika untuk menampilkan detail KPR
    console.log("Menampilkan detail untuk:", kpr);
    window.location.href = route("admin.pengajuan.kpr.detail", kpr.id);
};
const formatDate = (dateString) => {
    return format(new Date(dateString), "yyyy-MM-dd HH:mm");
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
