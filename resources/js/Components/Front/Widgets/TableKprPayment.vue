<template>
    <div>
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-base font-semibold leading-6 text-gray-900">
                    Hasil perhitungan KPR</h1>
                <p class="mt-2 text-sm text-gray-700">Daftar angsuran KPR yang harus dibayarkan</p>
            </div>
        </div>
        <div class="mt-4 max-h-[300px] overflow-y-scroll flow-root">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div
                    class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <div
                        class="overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                    Bulan
                                </th>
                                <th scope="col"
                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    Pokok
                                </th>
                                <th scope="col"
                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    Bunga
                                </th>
                                <th scope="col"
                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    Angsuran
                                </th>
                                <th scope="col"
                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    Sisa Pinjaman
                                </th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                            <tr v-for="data in kpr" :key="data.month">
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                    {{ data.no }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    Rp. {{ formatToNumber(data.pokok) }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    Rp. {{ formatToNumber(data.bunga) }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    Rp. {{ formatToNumber(data.jumlahAngsuran) }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    Rp. {{ formatToNumber(data.sisaPinjaman) }}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { formatToNumber } from '../../../lib/utils.js'

const { kprData } = defineProps({
    kprData: Object,
})

const emit = defineEmits(['update:kprData'])

const kpr = kprData
</script>
