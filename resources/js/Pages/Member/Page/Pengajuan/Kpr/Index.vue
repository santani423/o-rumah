<script setup>
import { Head } from "@inertiajs/vue3";
import FrontLayout from "@/Layouts/FrontLayout.vue";
import { format } from "date-fns";

import { defineProps, ref } from "vue";
// Fungsi untuk memformat angka sebagai mata uang
const props = defineProps({
    pengajuanKpr: Array,
    pengajuanLelang: Array,
});
const formatCurrency = (value) => {
    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
    }).format(value);
};
const formatDate = (dateString) => {
    return format(new Date(dateString), "yyyy-MM-dd HH:mm");
};
</script>

<template>
    <FrontLayout>
        <Head title="Daftar Pengajuan KPR" />

        <div
            class="grid px-4 mx-auto my-8 space-y-8 max-w-7xl sm:px-6 lg:px-8 md:my-12 md:space-y-12 place-items-center"
        >
            <div
                class="inline-flex flex-col items-center justify-center w-full px-6 py-10 bg-white border border-neutral-200 rounded-3xl"
            >   <caption class="text-lg font-semibold text-gray-900 py-4">Daftar Pengajuan KPR</caption>
                <!-- Tabel Pengajuan KPR -->
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th
                                scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Tanggal Pengajuan
                            </th>
                            <th
                                scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Nama Agen
                            </th>
                            <th
                                scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Status
                            </th>
                            <th
                                scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Nama Bank
                            </th>
                        
                             
                            <th
                                scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                    Nama BPR
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="item in pengajuanKpr" :key="item.id">
                        <td class="px-6 py-4 whitespace-nowrap">
                                 <td>{{formatDate(item.created_at) }}</td>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ item.namaAgen }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ item.status }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ item.bank_umum_name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ item.bank_bpr_name }}
                            </td> 
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div
            class="grid px-4 mx-auto my-8 space-y-8 max-w-7xl sm:px-6 lg:px-8 md:my-12 md:space-y-12 place-items-center"
        >
            <div
                class="inline-flex flex-col items-center justify-center w-full px-6 py-10 bg-white border border-neutral-200 rounded-3xl"
            >
                <!-- Tabel Pengajuan KPR -->   <caption class="text-lg font-semibold text-gray-900 py-4">Daftar Pengajuan Lelang</caption>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th
                                scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Tanggal Pengajuan
                            </th>
                            <th
                                scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Nama Agen
                            </th>
                            <th
                                scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Status
                            </th> 
                        
                           
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="item in pengajuanLelang" :key="item.id">
                        <td class="px-6 py-4 whitespace-nowrap">
                                 <td>{{formatDate(item.created_at) }}</td>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ item.namaAgen }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ item.status }}
                            </td> 
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </FrontLayout>
</template>
