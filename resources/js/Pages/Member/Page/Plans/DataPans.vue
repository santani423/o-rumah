<template>
    <div class="table-container">
        <table class="table">
            <tbody>
                <!-- Loop through data to create table rows -->
                <tr v-for="(plans, index) in plans" :key="plans.id">
                    <td>{{ index + 1 }}</td>

                    <td>
                        <p>{{ plans.name }}</p>
                        <p></p>
                        <p style="color: gray">
                            {{ plans.max_ads_posted }} Poin
                        </p>
                        <p></p>
                    </td>
                    <td>{{ formatRupiah(plans.price) }}</td>
                    <td>
                        <a
                            :href="
                                route('member.plans.paymentMessage', {
                                    slug: plans.slug,
                                })
                            "
                        >
                            <!-- Tombol untuk mengarahkan ke tautan -->
                            <button
                                class="ml-2 px-4 py-2 bg-blue-500 text-white rounded-md"
                            >
                                Beli Member
                            </button>
                        </a>
                    </td>
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
    plans: Array,
});
const toggleActive = (property) => {
    // Toggle the is_active property (0 to 1 or 1 to 0)
    property.is_active = property.is_active === 1 ? 0 : 1;
};
const formatRupiah = (price) => {
    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
        minimumFractionDigits: 0,
    }).format(price);
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
