<template>
    <ListingLayout>
        <Head title="Iklankan Properti" />
        <div class="mx-auto space-y-6 max-w-7xl">
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="text-lg font-bold">Buat Iklan Properti Anda!</h4>
                    <p class="text-sm font-normal">
                        Silahkan cari alamat terlebih dahulu.
                    </p>
                </div>
                <!-- <Link :href="route('profile')">
                    <DefaultButton @click="back()">
                        <ArrowLeftIcon class="w-4 h-4 mr-2 text-neutral-900" aria-hidden="true"/>
                        Kembali
                    </DefaultButton>
                </Link> -->
            </div>
            <div>
                <form @submit.prevent="submit">
                    <Card :card-title="'Lokasi'">
                        <div class="w-full">
                            <div class="mb-3">
                                <SimpleTypeahead
                                    id="typeahead_id"
                                    placeholder="Masukkan Kecamatan..."
                                    :items="data.districtList"
                                    :minInputLength="1"
                                    :itemProjection="itemProjectionFunction"
                                    @keyup="searchDistrict($event.target.value)"
                                    @selectItem="onSelectDistrict"
                                    class="w-full text-sm rounded-md shadow-sm border-neutral-300 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-300 focus:border-neutral-500 dark:focus:border-neutral-600 focus:ring-neutral-500 dark:focus:ring-neutral-600 placeholder:text-sm"
                                    v-model="form.district"
                                    :value="form.district ?? ''"
                                />
                                <InputError
                                    class="mt-2"
                                    v-if="errors.district"
                                    :message="errors.district"
                                />
                            </div>
                            <div
                                class="w-full mb-3"
                                :class="{ hidden: !form.districtLocation }"
                            >
                                <GMapMap
                                    :center="{
                                        lat: form.districtLocation?.lat ?? 0,
                                        lng: form.districtLocation?.long ?? 0,
                                    }"
                                    :zoom="15"
                                    map-type-id="terrain"
                                    style="width: 100%; height: 400px"
                                >
                                </GMapMap>
                            </div>
                            <div class="mb-3">
                                <FormInput
                                    :title="'Area/Kawasan'"
                                    :placeholder="'Masukkan nama area atau kawasan'"
                                    :id="'kawasan'"
                                    v-model="form.kawasan"
                                />
                                <InputError
                                    class="mt-2"
                                    v-if="errors.kawasan"
                                    :message="errors.kawasan"
                                />
                            </div>
                            <div class="mb-3">
                                <p class="mb-3 text-sm font-medium">
                                    Alamat Lengkap
                                </p>
                                <textarea
                                    class="w-full text-sm rounded-md shadow-sm border-neutral-300 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-300 focus:border-neutral-500 dark:focus:border-neutral-600 focus:ring-neutral-500 dark:focus:ring-neutral-600 placeholder:text-sm"
                                    rows="4"
                                    placeholder="Masukkan alamat lengkap"
                                    v-model="form.alamat"
                                ></textarea>
                                <InputError
                                    class="mt-2"
                                    :message="errors.alamat"
                                />
                            </div>
                        </div>
                    </Card>
                    <div class="flex justify-end my-3">
                        <button
                            type="submit"
                            class="bg-[#1CD6D0] disabled:bg-[#EAEBF0] disabled:text-[#B1B2CE] text-white py-2 px-4 rounded-md"
                            :class="{
                                'bg-[#EAEBF0]': form.processing,
                                'text-[#B1B2CE]': form.processing,
                            }"
                            :disabled="form.processing"
                        >
                            Gunakan Lokasi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </ListingLayout>
</template>

<script setup>
import { reactive, onMounted } from "vue";
import { Head, Link, router } from "@inertiajs/vue3";
import { ArrowLeftIcon } from "@heroicons/vue/24/outline";
import Card from "@/Components/Front/Widgets/Card.vue";
import FormInput from "./components/FormInput.vue";
import InputError from "@/Components/Front/Form/InputError.vue";
import axios from "axios";
import SimpleTypeahead from "vue3-simple-typeahead";
import "vue3-simple-typeahead/dist/vue3-simple-typeahead.css";
import DefaultButton from "@/Components/Front/Widgets/DefaultButton.vue";
import ListingLayout from "@/Pages/Listing/components/ListingLayout.vue";

var props = defineProps({
    errors: Object,
    id: Number,
    isUpdate: Boolean,
    data: Object,
});

const back = () => window.history.back();

const data = reactive({
    districtList: [],
});

const form = reactive({
    district: null,
    districtId: null,
    districtLocation: null,
    kawasan: null,
    alamat: null,
});

onMounted(() => {
    if (props.isUpdate) {
        const data = props.data;
        form.district = data.district;
        form.districtId = data.districtId;
        form.districtLocation = {
            lat: parseFloat(data.districtLocation?.lat),
            long: parseFloat(data.districtLocation?.long),
        };
        form.kawasan = data.kawasan;
        form.alamat = data.alamat;
    }
});

const setKecamatan = (place) => {
    form.district = place.formatted_address;
};

const itemProjectionFunction = (item) => {
    return item.name;
};

const searchDistrict = (kawasan) => {
    var url = route("listing.getDistrict", { name: kawasan });
    axios({
        method: "get",
        url: url,
    }).then((response) => {
        data.districtList = reactive(response.data);
    });
};

const onSelectDistrict = (event) => {
    form.district = event.name;
    form.districtId = event.id;
    form.districtLocation = {
        lat: parseFloat(event.meta.lat),
        long: parseFloat(event.meta.long),
    };
};

const submit = () => {
    if (props.isUpdate == true) {
        router.get(route("listing.edit", props.id), form, {
            preserveState: true,
        });
        return;
    }

    router.get(route("listing.storeLocation"), form, {
        preserveState: true,
    });
};
</script>
