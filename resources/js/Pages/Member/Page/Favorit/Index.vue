<script setup>
import { Head, Link } from "@inertiajs/vue3";

import FrontLayout from "@/Layouts/FrontLayout.vue";
import ComingSoonIcon from "@/Components/Front/Icon/ComingSoonIcon.vue";
import { defineProps } from "vue";

const props = defineProps({
    favorits: Array,
});
console.log(props.favorits);
</script>

<template>
    <FrontLayout>
        <Head title="Daftar Properti Favorit" />

        <div
            class="grid px-4 mx-auto my-8 space-y-8 max-w-7xl sm:px-6 lg:px-8 md:my-12 md:space-y-12 place-items-center"
        >
            <div
                class="inline-flex flex-col items-center justify-center w-full max-w-md gap-6 px-6 py-10 bg-white border border-neutral-200 rounded-3xl"
                style="width: auto; min-width: 100%"
            >
                <table class="min-w-full divide-y divide-gray-200">
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr
                            v-for="(favorit, index) in favorits"
                            :key="favorit.id"
                        >
                            <td>
                                <img
                                    :src="favorit.image"
                                    :alt="favorit.image"
                                    style="max-width: 100px; max-height: 100px"
                                />
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ favorit.title }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ favorit.type }}
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                            >
                                <a
                                    href="#"
                                    class="text-indigo-600 hover:text-indigo-900"
                                    >Hapus</a
                                >
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </FrontLayout>
</template>
