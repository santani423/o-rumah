<template>
    <form @submit.prevent="submit" class="flex flex-col gap-6">
        <!-- Form -->
        <div class="flex flex-col gap-3">
            <div class="flex flex-col">
                <Input
                    type="text"
                    name="email"
                    label="Alamat email"
                    v-model="form.email"
                />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>
        </div>

        <button
            class="inline-flex items-center justify-center gap-2 px-5 py-3 bg-teal-400 rounded-lg hover:bg-teal-500 disabled:bg-neutral-200"
            :disabled="form.processing"
        >
            <h6
                class="text-base font-bold leading-none tracking-wide text-center text-white uppercase"
                v-html="form.processing ? 'Loading...' : 'Selanjutnya'"
            ></h6>
        </button>

        <span class="text-sm text-center">
            Sudah punya akun?
            <button
                type="button"
                @click="$emit('update:currentStep', 1)"
                class="text-blue-500 hover:underline"
            >
                Login sekarang
            </button>
        </span>
    </form>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
import Input from "@/Components/Front/Form/Input.vue";
import InputError from "@/Components/Front/Form/InputError.vue";

import useEmmiter from "@/lib/useEmitter";

const emit = defineEmits(["update:currentStep"]);

const form = useForm({
    email: "",
});

const emitter = useEmmiter();

const submit = () => {
    form.processing = true;
    setTimeout(() => {
        emit("update:currentStep", 4);
        form.processing = false;
    }, 2000);
};
</script>
