<template>
    <ListingLayout>
        <Head title="Dashboard" />
        <div class="pb-36 flex justify-center items-center">
            <div class="bg-white shadow-md rounded-lg p-4">
                <!-- Card Header -->
                <div
                    class="flex items-center justify-between border-b border-gray-300 pb-4 mb-4"
                >
                    <h3 class="text-xl font-semibold text-gray-800">Pesanan</h3>
                </div>

                <!-- Content Area -->
                <div class="text-center">
                    <div
                        class="h-auto w-80 bg-gray-100 rounded-lg flex justify-center items-center p-4 mb-4"
                    >
                        <!-- Inner Content -->
                        <div>
                            <p class="text-sm">
                                {{ plan.name }} Masa aktif 1 Tahun
                            </p>
                            <h4
                                class="text-blue-500 text-lg font-semibold my-2"
                            >
                                {{ plan.max_ads_posted }} Poin
                            </h4>
                            <!-- Payment Structure Layout in Table Format with Left-aligned Titles and Right-aligned Content -->
                            <table
                                class="border-collapse border border-gray-300 mt-8"
                            >
                                <tr>
                                    <td
                                        class="border border-gray-300 px-4 py-2 text-left"
                                    >
                                        Pembayaran
                                    </td>
                                    <td
                                        class="border border-gray-300 px-4 py-2 text-right"
                                    >
                                        {{ formattedPrice }}
                                    </td>
                                </tr>
                                <tr>
                                    <td
                                        class="border border-gray-300 px-4 py-2 text-left"
                                    >
                                        PPN 11%
                                    </td>
                                    <td
                                        class="border border-gray-300 px-4 py-2 text-right"
                                    >
                                        {{ formattedPricePPN }}
                                    </td>
                                </tr>
                                <tr>
                                    <td
                                        class="border border-gray-300 px-4 py-2 text-left"
                                    >
                                        Total Bayar
                                    </td>
                                    <td
                                        class="border border-gray-300 px-4 py-2 text-right"
                                    >
                                        {{ formattedPriceTotal }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Upload Form -->
                    <form @submit.prevent="submitPayment">
                        <!-- Submit Button -->
                        <button
                            type="submit"
                            class="bg-blue-500 text-white px-4 py-2 rounded mt-4"
                        >
                            Submit
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </ListingLayout>
</template>

<script setup>
import ListingLayout from "@/Pages/Listing/components/ListingLayout.vue";
import { onMounted, ref } from "vue";

import axios from "axios"; // Import axios library

const imageUrl = ref(null);
const transactionId = ref(null);
const amount = ref(null);

const props = defineProps({
    formattedPrice: String,
    formattedPricePPN: String,
    formattedPriceTotal: String,
    formattedPriceTotal: String,
    slug: String,
    total: String,
    transaction: Object,
    plan: Object,
    user: Object,
});
console.log("props", props);
onMounted(() => {
    // Set default value for transactionId
    transactionId.value = props.transaction.id;
    amount.value = props.total;
    console.log("amount", amount);
});

function submitPayment() {
    const amount = props.total;
    const payer_email = props.user.email;
    const description =
        "Plan : " +
        props.plan.name +
        " max_ads_posted : " +
        props.plan.max_ads_posted;
    axios
        .post(route("payments"), {
            payer_email: payer_email,
            description: description,
            amount: amount,
            slug: props.plan.slug,
        })
        .then((response) => {
            console.log("Response:", response.data.payment.checkout_link);
            alert(response.data.message);
            window.location.href = response.data.payment.checkout_link;
        })
        .catch((error) => {
            console.error("Error:", error);
            alert("Failed to upload payment proof. Please try again.");
            // Redirect ke halaman lain
        });

    console.log("amount", amount);
}
</script>

<style scoped>
/* Styling for card content */
.bg-gray-100 {
    background-color: #f1f1f1; /* Light gray background */
}

/* Styling for blue text 



*/
.text-blue-500 {
    color: #007bff; /* Blue text color */
}

/* Styling for countdown parts */
.countdown-part {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background-color: #007bff; /* Blue background */
    color: white; /* White text color */
    padding: 6px 12px; /* Padding for countdown parts */
    border-radius: 5px; /* Rounded corners */
    margin: 0 8px; /* Margin between countdown parts */
}
.countdown-part p {
    margin: 0; /* Remove default margin */
}
</style>
