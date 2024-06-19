<template>
    <form @submit.prevent="submit" class="flex flex-col gap-6">
        <!-- Form -->
        <div class="flex flex-col gap-3">
            <div class="flex flex-col">
                <InputPassword type="password" name="password" label="Masukkan password baru" v-model="form.password" />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>
            <div class="flex flex-col">
                <InputPassword type="password" name="password_confirmation" label="Ulangi password"
                    v-model="form.password_confirmation" />
                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>
        </div>

        <button
            class="inline-flex items-center justify-center gap-2 px-5 py-3 bg-teal-400 rounded-lg hover:bg-teal-500 disabled:bg-neutral-200"
            :disabled="form.processing">
            <h6 class="text-base font-bold leading-none tracking-wide text-center text-white uppercase" v-html="form.processing ?
                'Loading...' : 'Ganti Password'"></h6>
        </button>
    </form>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import InputPassword from '@/Components/Front/Form/InputPassword.vue'
import InputError from '@/Components/Front/Form/InputError.vue'

import useEmmiter from '@/lib/useEmitter'

const emit = defineEmits(['update:currentStep'])

const form = useForm({
    password: '',
    password_confirmation: '',
})

const emitter = useEmmiter();

const submit = () => {
    form.processing = true
    setTimeout(() => {
        emit('update:currentStep', 6)
        form.processing = false
    }, 2000)
}
</script>
