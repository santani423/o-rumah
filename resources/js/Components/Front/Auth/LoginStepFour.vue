<script setup>
import ResetPasswordIcon from '@/Components/Front/Icon/ResetPasswordIcon.vue';
</script>

<template>
    <div class="flex flex-col gap-6">
        <!-- Form -->
        <div class="flex flex-col items-center gap-3">
            <ResetPasswordIcon class="w-16 h-16" />
            <div class="flex flex-col gap-2 text-center">
                <div class="text-lg font-semibold leading-normal text-neutral-900">Silahkan Periksa Email
                </div>
                <p>Kami telah mengirimkan link untuk mereset password kamu ke email <span
                        class="font-bold">user@gmail.com</span>
                </p>
            </div>
        </div>
    </div>
</template>
