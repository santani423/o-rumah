<template>
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Tipe Properti</th>
                    <th>Aktif?</th>
                </tr>
            </thead>
            <tbody>
                <!-- Loop through data to create table rows -->
                <tr
                    v-for="(PropertyType, index) in PropertyType"
                    :key="PropertyType.id"
                >
                    <td>{{ index + 1 }}</td>
                    <td>
                        <p>{{ PropertyType.name }}</p>
                        <p></p>
                        <p style="color: gray">{{ PropertyType.slug }}</p>
                        <p></p>
                    </td>
                    <td>
                        <!-- Custom style switch button -->
                        <label
                            class="switch"
                            @click="toggleActive(PropertyType)"
                        >
                            <input
                                type="checkbox"
                                :checked="PropertyType.is_active == 1"
                                disabled
                            />
                            <span class="slider round"></span>
                        </label>
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
    PropertyType: Array,
});

// Function to toggle is_active property and send HTTP request
const toggleActive = (property) => {
    // Toggle the is_active property (0 to 1 or 1 to 0)
    property.is_active = property.is_active === 1 ? 0 : 1;

    // Send HTTP request to the specified URL
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
