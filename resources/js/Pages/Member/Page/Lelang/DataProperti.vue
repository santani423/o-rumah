<template>
    <div class="table-container">
        <table class="table">
            <tbody>
                <!-- Loop through data to create table rows -->
                <tr v-for="(property, index) in properties" :key="property.id">
                    <td>
                        <div style="display: flex; align-items: center">
                            <img
                                :src="property.image"
                                alt="Iklan Image"
                                style="
                                    max-width: 200px;
                                    max-height: 200px;
                                    margin-right: 10px;
                                    border-radius: 10px; /* Menambahkan border-radius untuk membuat sisi tumpul */
                                "
                            />
                            <div>
                                <span
                                    class="text-xl font-semibold text-gray-800"
                                    >{{ property.title }}</span
                                ><br />
                                <span
                                    style="display: flex; align-items: center"
                                >
                                    <img
                                        src="/assets/icons/location_on.png"
                                        style="
                                            max-width: 20px;
                                            max-height: 20px;
                                            margin-right: 10px;
                                            border-radius: 10px; /* Menambahkan border-radius untuk membuat sisi tumpul */
                                        "
                                    />
                                    {{ property.address }} </span
                                ><br />
                                <span>Perkiraan Harga</span><br />
                                <span
                                    class="text-xl font-semibold text-blue-800"
                                    >{{ formatRupiah(property.price) }}
                                </span>
                                <br /><button
                                    @click="showModal(property)"
                                    class="ml-2 px-4 py-2 bg-[#1CD6D0] text-white rounded-md"
                                >
                                    Pasang Iklan
                                </button>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="property-dimension" v-if="property.lb"
                            >LB {{ property.lb }} m&sup2;</span
                        >
                        <span class="property-dimension" v-if="property.lt"
                            >LT {{ property.lt }} m&sup2;</span
                        >
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- Modal -->
    <div v-if="showPropertyModal" class="modal" @click.self="closeModal()">
        <div
            class="modal-content"
            style="
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
            "
        >
            <img
                src="/assets/icons/Illustration.png"
                style="
                    max-width: 60px;
                    max-height: 60px;
                    margin-right: 10px;
                    border-radius: 10px; /* Menambahkan border-radius untuk membuat sisi tumpul */
                "
            />
            <span class="text-xl font-semibold text-gray-800"
                >Apakah Anda Yakin?</span
            >
            <p>
                Anda akan memasang properti Lelang, Kredit anda akan berkurang
                sebanyak -{{ adControll.nilai }}
            </p>
            <div style="display: flex; justify-content: center; width: 100%">
                <button
                    class="ml-2 px-4 py-2 bg-gray-400 text-white rounded-md"
                    @click="closeModal()"
                >
                    Kembali
                </button>
                <button
                    class="ml-2 px-4 py-2 bg-[#1CD6D0] text-white rounded-md"
                    @click="addLelangProperti()"
                >
                    Lanjutkan
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { defineProps, ref } from "vue";
import axios from "axios";

const props = defineProps({
    properties: Array,
    adControll: Array,
});

const showPropertyModal = ref(false);
const selectedProperty = ref({});

const showModal = (property) => {
    selectedProperty.value = property;
    showPropertyModal.value = true;
};

const closeModal = () => {
    showPropertyModal.value = false;
};

const formatRupiah = (value) => {
    const numberFormat = new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
        minimumFractionDigits: 0,
    });
    return numberFormat.format(value);
};
const addLelangProperti = () => {
    // Pastikan bahwa selectedProperty memiliki semua data yang diperlukan
    console.log("Data properti tidak lengkap.", props.adControll.code);

    axios
        .post(route("ad.take.auction"), {
            properti_id: selectedProperty.value.id,
            code: props.adControll.code,
        })
        .then((response) => {
            console.log("HTTP request sent successfully:", response.data);
            // Logika untuk menambahkan properti ke lelang
            console.log(
                "Properti ditambahkan ke lelang:",
                selectedProperty.value
            );
            // Tutup modal setelah menambahkan
            closeModal();
        })
        .catch((error) => {
            console.error("Error sending HTTP request:", error);
        });
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
    padding: 8px;
    border: none; /* Menghilangkan border */
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

.property-dimension {
    display: inline-block;
    margin-right: 10px;
    font-weight: bold;
    color: #333;
}

.modal {
    display: block; /* Changed from none to block */
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);
}

.modal-content {
    position: relative;
    background-color: #fefefe;
    margin: 10% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 50%; /* Adjusted for better responsiveness */
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    animation-name: animatetop;
    animation-duration: 0.4s;
    border-radius: 10px; /* Menambahkan border-radius untuk membuat sudut tumpul */
}

@keyframes animatetop {
    from {
        top: -300px;
        opacity: 0;
    }
    to {
        top: 0;
        opacity: 1;
    }
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}
</style>
