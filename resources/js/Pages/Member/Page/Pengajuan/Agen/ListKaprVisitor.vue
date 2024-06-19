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
                        {{ title }}
                    </h3>
                </div>
                <DataPengajuanKpr :pengajuanKpr="pengajuanKpr" />
            </div>
        </div>
    </ListingLayout>
</template>

<script setup>
import ListingLayout from "@/Pages/Listing/components/ListingLayout.vue";
import DataPengajuanKpr from "@/Pages/Member/Page/Pengajuan/Agen/DataPengajuanKpr.vue";
const props = defineProps({
    pengajuanKpr: Array,
});
console.log(props);
</script>

<style scoped>
/* Style kosong */
</style>
