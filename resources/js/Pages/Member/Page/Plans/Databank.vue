<template>
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Bank</th>
                    <th>Nama Bank</th>
                    <th>Kota</th>
                </tr>
            </thead>
            <tbody>
                <!-- Loop through data to create table rows -->
                <tr v-for="(bank, index) in bank" :key="bank.id">
                    <td>{{ index + 1 }}</td>
                    <td>{{ bank.bank }}</td>
                    <td>
                        <p>{{ bank.alias_name }}</p>
                        <p></p>
                        <p style="color: gray">{{ bank.address }}</p>
                        <p></p>
                    </td>
                    <td>
                        <a
                            :href="
                                route('member.plans.paymentMessage', {
                                    slug: slug,
                                    codeBank: bank.code,
                                })
                            "
                        >
                            <button
                                class="ml-2 px-4 py-2 bg-blue-500 text-white rounded-md"
                            >
                                Pilih Bank
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
    bank: Array,
    slug: Array,
});
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
