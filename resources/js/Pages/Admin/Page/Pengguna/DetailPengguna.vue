<template>
    <ListingLayout>
        <Head title="Dashboard" />
        <div class="pb-36">
            <div class="bg-white shadow-md rounded-lg p-4">
                <!-- Card Header -->
                <div
                    class="flex items-center justify-between border-b border-gray-300 pb-4 mb-4"
                >
                    <h3 class="text-xl font-semibold text-gray-800">
                        Detail User
                    </h3>
                </div>

                <!-- Card Body -->
                <div>
                    <ProfileLayout :user="user" />
                </div>
            </div>
        </div>
    </ListingLayout>
</template>

<script setup>
import ListingLayout from "@/Pages/Listing/components/ListingLayout.vue";
import ProfileLayout from "@/Pages/Admin/Page/Pengguna/ProfileLayout.vue";
import { defineProps } from "vue";
const props = defineProps({
    user: Array,
});
</script>
