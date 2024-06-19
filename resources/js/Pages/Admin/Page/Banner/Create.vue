<template>
    <ListingLayout>
        <Head title="Dashboard" />
        <div class="pb-36">
            <div class="bg-white shadow-md rounded-lg p-4">
                <!-- Card Header -->

                <div class="flex items-center justify-between pb-4 mb-4">
                    <h3 class="text-xl font-semibold text-gray-800">
                        Add Banner
                    </h3>
                </div>

                <!-- Card Body -->
                <div>
                    <form>
                        <label
                            for="name"
                            class="block font-medium text-gray-700"
                            >Name:</label
                        >
                        <input
                            type="text"
                            id="name"
                            v-model="name"
                            class="w-full px-3 py-2 mt-1 border rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        />

                        <label
                            for="description"
                            class="block font-medium text-gray-700"
                            >Description:</label
                        >
                        <input
                            type="text"
                            id="description"
                            v-model="description"
                            class="w-full px-3 py-2 mt-1 border rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        />

                        <label for="url" class="block font-medium text-gray-700"
                            >URL:</label
                        >
                        <input
                            type="text"
                            id="url"
                            v-model="url"
                            class="w-full px-3 py-2 mt-1 border rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        />
                        <label
                            for="show_on"
                            class="block font-medium text-gray-700"
                            >Show On:</label
                        >
                        <select
                            id="show_on"
                            v-model="show_on"
                            class="w-full px-3 py-2 mt-1 border rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        >
                            <option value="homepage">Homepage</option>
                            <option value="lelang">Lelang</option>
                            <option value="ofood">Ofood</option>
                            <option value="omarchent">Omarchent</option>
                        </select>

                        <label
                            for="image"
                            class="block font-medium text-gray-700"
                            >Image:</label
                        >
                        <input
                            type="file"
                            id="image"
                            @change="previewImage"
                            class="w-full px-3 py-2 mt-1 border rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        />
                        <img
                            v-if="imagePreview"
                            :src="imagePreview"
                            alt="Preview Image"
                            class="mt-2 max-w-full"
                        />

                        <label
                            for="is_active"
                            class="block font-medium text-gray-700"
                            >Is Active:</label
                        >
                        <label class="switch">
                            <input
                                type="checkbox"
                                id="is_active"
                                v-model="is_active"
                                class="form-checkbox h-0 w-0 opacity-0"
                            />
                            <span class="slider round"></span>
                        </label>

                        <label
                            for="order"
                            class="block font-medium text-gray-700"
                            >Order:</label
                        >
                        <input
                            type="number"
                            id="order"
                            v-model="order"
                            class="w-full px-3 py-2 mt-1 border rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        />

                        <button
                            type="button"
                            class="ml-3 px-4 py-2 bg-green-500 text-white rounded-md mt-3"
                            @click="addBanner"
                        >
                            Add Banner
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </ListingLayout>
</template>

<script setup>
import ListingLayout from "@/Pages/Listing/components/ListingLayout.vue";
import { defineProps, ref } from "vue";
import axios from "axios";
const form = ref({
    name: "",
    description: "",
    url: "",
    image: "https://via.placeholder.com/1120x340",
    is_active: true,
    show_on: "homepage",
    order: null,
});
const name = ref("");
const description = ref("");
const url = ref("");
const image = ref("");
const is_active = ref(true);
const show_on = ref("homepage");
const order = ref(null);
const addBanner = () => {
    const formData = new FormData();
    formData.append("image", form.image);
    formData.append("name", name.value);
    formData.append("description", description.value);
    formData.append("url", url.value);
    formData.append("is_active", is_active.value);
    formData.append("show_on", show_on.value);
    formData.append("order", order.value);
    console.log(formData);
    axios
        .post(route("admin.nav.banner.store"), formData, {
            headers: {
                "Content-Type": "multipart/form-data",
            },
        })
        .then((response) => {
            console.log("Response from Laravel:", response.data);

            window.location.href = route("admin.nav.banner");
        })
        .catch((error) => {
            console.error("Error submitting form:", error);
        });
};

const imagePreview = ref(null);

const previewImage = (event) => {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = () => {
            imagePreview.value = reader.result;
        };
        reader.readAsDataURL(file);
        form.image = file;
    }
};
</script>

<style>
.switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
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
    -webkit-transition: 0.4s;
    transition: 0.4s;
    border-radius: 34px;
}

.slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: 0.4s;
    transition: 0.4s;
    border-radius: 50%;
}

input:checked + .slider {
    background-color: #2196f3;
}

input:focus + .slider {
    box-shadow: 0 0 1px #2196f3;
}

input:checked + .slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
}

.slider.round {
    border-radius: 34px;
}

.slider.round:before {
    border-radius: 50%;
}
</style>
