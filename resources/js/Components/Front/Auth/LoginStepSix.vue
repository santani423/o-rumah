<script setup>
import ResetPasswordSuccessIcon from '@/Components/Front/Icon/ResetPasswordSuccessIcon.vue';

defineEmits(['update:currentStep'])
</script>

<template>
    <div class="flex flex-col gap-6">
        <!-- Form -->
        <div class="flex flex-col items-center gap-3">
            <ResetPasswordSuccessIcon class="w-16 h-16" />
            <div class="flex flex-col gap-2 text-center">
                <div class="text-lg font-semibold leading-normal text-neutral-900">Reset Password Berhasil
                </div>
                <p>Silakan login kembali menggunakan email dan password baru anda</p>
            </div>
        </div>

        <button @click="$emit('update:currentStep', 1)"
            class="inline-flex items-center justify-center gap-2 px-5 py-3 bg-teal-400 rounded-lg hover:bg-teal-500 disabled:bg-neutral-200">
            <h6 class="text-base font-bold leading-none tracking-wide text-center text-white uppercase">Login sekarang</h6>
        </button>
    </div>
</template>
