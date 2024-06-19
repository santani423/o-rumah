<script setup>
import { computed } from 'vue'
import { BuildingLibraryIcon } from '@heroicons/vue/24/outline'

const props = defineProps({
    ads: Object,
})

console.log(props.ads)

const isAdsTypeLelang = computed(() => props.ads.ads_type === 'Lelang')
</script>

<template>
    <div class="flex flex-col divide-y divide">
        <div class="flex flex-col pb-6 space-y-2">
            <h2 class="text-2xl font-bold text-blue-800">
                {{ ads.formatted_price }}
            </h2>
            <h1 class="text-base font-normal ">
                {{ ads.title }}
            </h1>
            <h6 class="text-base font-normal text-neutral-500">
                {{ ads.area }}
            </h6>
        </div>
        <div class="flex flex-col gap-6 py-6">
            <div class="text-xl font-semibold ">Informasi Properti
            </div>
            <div class="flex flex-col gap-8">
                <div v-if="ads.apartment_type !== null"
                     class="inline-flex items-center justify-start gap-4">
                    <div class="w-48 text-base font-normal text-neutral-500">
                        Tipe Apartemen
                    </div>
                    <div class="text-base font-semibold ">{{
                            ads.apartment_type
                        }}
                    </div>
                </div>
                <div v-if="ads.floor_location !== null"
                     class="inline-flex items-center justify-start gap-4">
                    <div class="w-48 text-base font-normal text-neutral-500">
                        Lokasi di Lantai
                    </div>
                    <div class="text-base font-semibold ">{{
                            ads.floor_location
                        }}
                    </div>
                </div>
                <div v-if="ads.jk !== null"
                     class="inline-flex items-center justify-start gap-4">
                    <div class="w-48 text-base font-normal text-neutral-500">
                        Kamar Tidur
                    </div>
                    <div class="text-base font-semibold ">{{ ads.jk }}</div>
                </div>
                <div v-if="ads.jkm !== null"
                     class="inline-flex items-center justify-start gap-4">
                    <div class="w-48 text-base font-normal text-neutral-500">
                        Kamar Mandi
                    </div>
                    <div class="text-base font-semibold ">{{ ads.jkm }}</div>
                </div>
                <div v-if="ads.lt !== null"
                     class="inline-flex items-center justify-start gap-4">
                    <div class="w-48 text-base font-normal text-neutral-500">
                        Luas Tanah
                    </div>
                    <div class="text-base font-semibold ">{{ ads.lt }} m2</div>
                </div>
                <div v-if="ads.lb !== null"
                     class="inline-flex items-center justify-start gap-4">
                    <div class="w-48 text-base font-normal text-neutral-500">
                        Luas Bangunan
                    </div>
                    <div class="text-base font-semibold ">{{ ads.lb }} m2</div>
                </div>
                <div v-if="ads.jl !== null"
                     class="inline-flex items-center justify-start gap-4">
                    <div class="w-48 text-base font-normal text-neutral-500">
                        Jumlah Lantai
                    </div>
                    <div class="text-base font-semibold ">{{ ads.jl }}</div>
                </div>
                <div v-if="ads.dl !== null"
                     class="inline-flex items-center justify-start gap-4">
                    <div class="w-48 text-base font-normal text-neutral-500">
                        Daya Listrik
                    </div>
                    <div class="text-base font-semibold ">{{ ads.dl }} watt
                    </div>
                </div>
                <div v-if="ads.certificate !== null"
                     class="inline-flex items-center justify-start gap-4">
                    <div class="w-48 text-base font-normal text-neutral-500">
                        Jenis Sertifikat
                    </div>
                    <div class="text-base font-semibold ">{{
                            ads.certificate
                        }}
                    </div>
                </div>
                <div v-if="ads.year_built !== null"
                     class="inline-flex items-center justify-start gap-4">
                    <div class="w-48 text-base font-normal text-neutral-500">
                        Tahun Dibangun
                    </div>
                    <div class="text-base font-semibold ">{{
                            ads.year_built
                        }}
                    </div>
                </div>
                <div v-if="ads.furniture_condition !== null"
                     class="inline-flex items-center justify-start gap-4">
                    <div class="w-48 text-base font-normal text-neutral-500">
                        Kondisi Furnitur
                    </div>
                    <div class="text-base font-semibold ">
                        {{ ads.furniture_condition }}
                    </div>
                </div>
                <div v-if="ads.house_facility !== null"
                     class="inline-flex justify-start gap-4">
                    <div class="w-48 text-base font-normal text-neutral-500">
                        Fasilitas Rumah
                    </div>
                    <ul>
                        <li class="font-semibold mb-2"
                            v-for="(facility, index) in ads.house_facility"
                            :key="index">{{ facility }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="flex flex-col gap-6 py-6">
            <div class="text-xl font-semibold ">Informasi Lingkungan
            </div>
            <div class="flex flex-col gap-8">
                <div v-if="ads.housing_name !== null"
                     class="inline-flex items-center justify-start gap-4">
                    <div class="w-48 text-base font-normal text-neutral-500">
                        Nama Komplek
                    </div>
                    <div class="text-base font-semibold ">{{
                            ads.housing_name
                        }}
                    </div>
                </div>
                <div v-if="ads.cluster_name !== null"
                     class="inline-flex items-center justify-start gap-4">
                    <div class="w-48 text-base font-normal text-neutral-500">
                        Nama Cluster
                    </div>
                    <div class="text-base font-semibold ">{{
                            ads.cluster_name
                        }}
                    </div>
                </div>
                <div v-if="ads.other_facility !== null"
                     class="inline-flex justify-start gap-4">
                    <div class="w-48 text-base font-normal text-neutral-500">
                        Kondisi Lingkungan
                    </div>
                    <ul>
                        <li class="font-semibold mb-2"
                            v-for="(facility, index) in ads.other_facility"
                            :key="index">{{ facility }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div v-if="ads.video !== null" class="flex flex-col gap-6 py-6">
            <div class="text-xl font-semibold">Video Rumah</div>
            <iframe height="400" :src="ads.video" />
        </div>
        <div class="flex flex-col gap-6 py-6">
            <div class="text-xl font-semibold">Deskripsi</div>
            <div class="text-base font-normal leading-relaxed">
                {{ ads.description }}
            </div>
            <div
                class="p-4 bg-teal-50 rounded-lg border border-teal-400 flex flex-col items-start gap-y-2"
                v-if="isAdsTypeLelang">
                <div
                    class="inline-flex items-center px-4 py-2 font-medium bg-teal-400 rounded-full group text-white pointer-events-none">
                    <BuildingLibraryIcon class="w-5 h-5"/>
                    <span class="ml-2">Tentang Aset Bank</span>
                </div>
                <p class="text-base font-normal text-neutral-500">
                    Properti aset bank adalah aset yang diambil alih oleh bank
                    ketika pemilik sebelumnya tidak bisa melunasi pinjaman.
                    Sehingga bank akan mengambil alih properti aset bank
                    tersebut untuk disewakan atau dijual kembali dengan harga
                    cenderung lebih murah.
                </p>
            </div>
        </div>
        <div class="flex flex-col gap-6 py-6">
            <div class="text-xl font-semibold ">Lokasi</div>
            <iframe
                :src="`https://maps.google.com/maps?q=${ads.lat},${ads.lng}&hl=id;z=15&output=embed`"
                height="450"
                style="border:0;" allowfullscreen="true" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
</template>
