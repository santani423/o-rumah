<template>
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tanggal</th>
                    <th>Deskripsi</th>
                    <th>Priode</th>
                    <th>Payment method</th>
                    <th>Total</th>
                    <th>Invoice</th>
                </tr>
            </thead>
            <tbody>
                <!-- Loop through data to create table rows -->
                <tr v-for="(transaksi, index) in transaksi" :key="transaksi.id">
                    <td>{{ index + 1 }}</td>
                    <td>{{ transaksi.tgl_transaksi }}</td>
                    <td>{{ transaksi.description }}</td>
                    <td>
                        {{ transaksi.updated_at_formatted }}-{{
                            transaksi.updated_at_plus_one_year
                        }}
                    </td>
                    <td>{{ transaksi.payment_method }}</td>
                    <td>{{ transaksi.amount }}</td>
                    <td>
                        <button
                            @click="generateInvoice(transaksi.id)"
                            class="bg-[#1CD6D0] text-white py-2 px-4 rounded-full"
                        >
                            Generate Invoice
                        </button>
                    </td>
                    <!-- Tombol invoice -->
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script setup>
import { defineProps } from "vue";
import axios from "axios"; // Import axios library

// Define props to receive data from parent component
const props = defineProps({
    transaksi: Array,
});
const toggleActive = (property) => {
    // Toggle the is_active property (0 to 1 or 1 to 0)
    property.is_active = property.is_active === 1 ? 0 : 1;
};
const generateInvoice = (transaksiId) => {
    // Fungsi untuk menghasilkan invoice
    console.log(`Generating invoice for transaction ID: ${transaksiId}`);
    // Tambahkan logika untuk menghasilkan invoice di sini
    window.location.href = route("member.plans.invoice", transaksiId);
};
</script>
<style scoped>
/* Styling for the table */
.table-container {
    width: 100%;
    overflow-x: auto;
    display: flex;
    justify-content: center;
}

.table {
    width: 100%; /* Ubah menjadi 100% agar lebar tabel menyesuaikan layar */
    border-collapse: collapse;
    text-align: center; /* Pastikan teks di seluruh kolom tetap terpusat */
}

.table th,
.table td {
    border-top: 1px solid #ccc;
    border-bottom: 1px solid #ccc;
    padding: 8px;
    border-left: none;
    border-right: none;
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
