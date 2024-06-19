<template>
    <ListingLayout>
        <Head title="Invoice" />
        <div class="pb-36">
            <div id="invoiceContent" class="bg-white shadow-md rounded-lg p-4">
                <!-- Card Header -->
                <div
                    class="flex items-center justify-between border-b border-gray-300 pb-4 mb-4"
                >
                    <h3 class="text-xl font-semibold text-gray-800">Invoice</h3>
                </div>

                <!-- Invoice Details -->
                <div class="mb-8">
                    <div class="flex justify-between mb-2">
                        <span class="font-semibold">Invoice Date:</span>
                        <span>{{ transaksi.updated_at }}</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span class="font-semibold">Plans:</span>
                        <span>{{ transaksi.name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-semibold">Saldo Iklan:</span>
                        <span>{{ transaksi.ad_balance }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-semibold">Status Transaksi:</span>
                        <span>{{ transaksi.transaction_status }}</span>
                    </div>
                </div>

                <!-- Display Image with Zoom Effect
                <div class="mb-4" style="position: relative">
                    <img
                        :src="transaksi.proof_of_transaction"
                        alt="Bukti Pembayaran"
                        style="
                            max-width: 300px;
                            max-height: 300px;
                            cursor: pointer;
                        "
                        @mouseover="zoomInImage"
                        @mouseleave="zoomOutImage"
                    />
                </div> -->

                <!-- Total Amount -->
                <div class="flex justify-end items-center mt-4">
                    <div class="font-semibold">Total Amount:</div>
                    <div class="ml-2">Rp. {{ transaksi.amount }}</div>
                </div>

                <!-- Action Buttons
                <div class="flex justify-end mt-4 space-x-4">
                    <button
                        class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md"
                        @click="approveTransaction"
                    >
                        Approve
                    </button>
                    <button
                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md"
                        @click="cancelTransaction"
                    >
                        Cancel
                    </button>
                </div> -->

                <button
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded download-pdf-button"
                    @click="downloadPdf"
                >
                    Download PDF
                </button>
            </div>
        </div>
    </ListingLayout>
</template>

<script setup>
import ListingLayout from "@/Pages/Listing/components/ListingLayout.vue";
import { defineProps } from "vue";
import axios from "axios"; // Import axios library
import { jsPDF } from "jspdf";

// Define props to receive data from parent component
const props = defineProps({
    transaksi: Object, // Menggunakan Object untuk menerima data transaksi
});

// Method to handle transaction approval
const approveTransaction = async () => {
    console.log(
        "🚀 ~ response ~ props.transaksi.id:",
        props.transaksi.transaksis_id
    );
    try {
        const response = await axios.post(route("admin.approval.bukti.bayar"), {
            transaction_id: props.transaksi.transaksis_id,
        });
        //  console.log("🚀 ~ response ~ response:", response);
        window.location.href = route("admin.nav.transaksi.success");
    } catch (error) {
        console.error("Error approving transaction:", error);
    }
};
// Method to handle transaction cancellation
const cancelTransaction = async () => {
    // Lakukan tindakan cancel transaksi di sini
    console.log("Transaction Cancelled");
    try {
        const response = await axios.post(route("admin.canceled.bukti.bayar"), {
            transaction_id: props.transaksi.transaksis_id,
        });
        window.location.href = route("admin.nav.transaksi.canceled");
        console.log("Transaction Approved");
        console.log("Response:", response.data); // Log respon dari server jika diperlukan
    } catch (error) {
        console.error("Error approving transaction:", error);
    }
};

// Method to zoom in image on hover
const zoomInImage = (event) => {
    event.target.style.transform = "scale(2)";
    event.target.style.transition = "transform 0.3s ease";
};

// Method to zoom out image when mouse leaves
const zoomOutImage = (event) => {
    event.target.style.transform = "scale(1)";
    event.target.style.transition = "transform 0.3s ease";
};

const downloadPdf = () => {
    const doc = new jsPDF();
    const downloadButton = document.querySelector(".download-pdf-button");
    downloadButton.classList.add("hide-on-pdf"); // Sembunyikan tombol

    const source = document.getElementById("invoiceContent");

    doc.html(source, {
        callback: function (doc) {
            downloadButton.classList.remove("hide-on-pdf"); // Tampilkan kembali tombol
            doc.save("invoice.pdf");
        },
        x: 10,
        y: 10,
        windowWidth: document.getElementById("invoiceContent").scrollWidth,
    });
};
</script>

<style scoped>
/* Custom styles for the invoice layout */
.hide-on-pdf {
    display: none;
}

#invoiceContent {
    font-size: 12px; /* Atur ukuran font untuk konten invoice */
}
</style>
