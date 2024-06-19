<template>
    <form @submit.prevent="submit" class="flex flex-col gap-6">
        <!-- Social Login -->
        <!-- <div class="flex flex-col gap-3">
            <a :href="route('auth.google')" tabindex="-1" as="button"
                class="inline-flex items-center gap-2 px-5 py-3 bg-white border rounded-lg border-neutral-200 hover:bg-neutral-50">

                <GoogleIcon class="w-6 h-6 shrink" />
                <div class="mx-auto text-sm font-medium leading-none text-center text-neutral-900">
                    Masuk dengan Google</div>
            </a>
        </div> -->

        <!-- Divider -->
        <!-- <Divider text="Atau" /> -->

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
            <div class="flex flex-col">
                <InputPassword
                    type="password"
                    name="password"
                    label="Password"
                    v-model="form.password"
                />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>
        </div>

        <!--        <button @click="$emit('update:currentStep', 3)" type="button"-->
        <!--            class="text-sm text-left text-blue-500 hover:underline">-->
        <!--            Lupa Password?-->
        <!--        </button>-->

        <button
            type="submit"
            tabindex="1"
            class="inline-flex items-center justify-center gap-2 px-5 py-3 bg-teal-400 rounded-lg hover:bg-teal-500 disabled:bg-neutral-200"
            :disabled="form.processing"
        >
            <h6
                class="text-base font-bold leading-none tracking-wide text-center text-white uppercase"
                v-html="form.processing ? 'Loading...' : 'Login'"
            ></h6>
        </button>

        <span class="text-sm text-center">
            Belum punya akun?
            <button
                type="button"
                tabindex="-1"
                @click="$emit('update:currentStep', 2)"
                class="text-blue-500 hover:underline"
            >
                Daftar sekarang
            </button>
        </span>
    </form>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
import Divider from "@/Components/Front/Base/Divider.vue";
import Input from "@/Components/Front/Form/Input.vue";
import InputPassword from "@/Components/Front/Form/InputPassword.vue";
import InputError from "@/Components/Front/Form/InputError.vue";
import GoogleIcon from "@/Components/Front/Icon/GoogleIcon.vue";

import useEmmiter from "@/lib/useEmitter";

defineEmits(["update:currentStep"]);

const form = useForm({
    email: "",
    password: "",
    remember: false,
});

const emitter = useEmmiter();

const submit = () => {
    form.post(route("login"), {
        onSuccess: () => emitter.emit("isLoggedIn", true),
        onError: () => {
            form.reset("password");
        },
    });
};
</script>
