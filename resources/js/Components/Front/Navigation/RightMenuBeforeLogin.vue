<script setup>
import { ref } from "vue";
import LoginModal from "@/Components/Front/Auth/LoginModal.vue";
import useEmitter from "@/lib/useEmitter.js";

const emitter = useEmitter();

const isModalLoginShow = ref(false);
const isComingSoon = false;

const setIsModalLoginShow = (value) => {
    if (isComingSoon) {
        window.location.href = route("coming-soon");
        return;
    }

    isModalLoginShow.value = value;
};

emitter.on("setIsModalLoginShow", setIsModalLoginShow);
</script>

<template>
    <div class="hidden lg:ml-6 lg:flex lg:items-center">
        <div class="flex space-x-4">
            <button
                type="button"
                @click="setIsModalLoginShow(true)"
                class="rounded-md bg-white px-6 py-2.5 text-sm font-semibold text-neutral-900 ring-1 ring-inset ring-neutral-700 hover:bg-neutral-700 hover:text-white uppercase"
            >
                Iklankan properti
            </button>
            <button
                type="button"
                class="rounded-md bg-white px-3.5 py-2.5 text-sm font-semibold text-neutral-900 hover:bg-neutral-50 uppercase"
                @click="setIsModalLoginShow(true)"
            >
                Login / Daftar
            </button>
        </div>
    </div>
    <LoginModal
        :is-open="isModalLoginShow"
        @update:isOpen="setIsModalLoginShow(false)"
    />
</template>
