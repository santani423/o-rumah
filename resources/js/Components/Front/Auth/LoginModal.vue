<template>
    <TransitionRoot appear :show="isOpen" as="template">
        <Dialog as="div" @close="setIsOpen(false)" class="relative z-10">
            <TransitionChild
                as="template"
                enter="duration-300 ease-out"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="duration-200 ease-in"
                leave-from="opacity-100"
                leave-to="opacity-0"
            >
                <div class="fixed inset-0 bg-black/25" />
            </TransitionChild>

            <div class="fixed inset-0 overflow-y-auto">
                <div
                    class="flex items-center justify-center min-h-full p-4 text-center"
                >
                    <TransitionChild
                        as="template"
                        enter="duration-300 ease-out"
                        enter-from="opacity-0 scale-95"
                        enter-to="opacity-100 scale-100"
                        leave="duration-200 ease-in"
                        leave-from="opacity-100 scale-100"
                        leave-to="opacity-0 scale-95"
                    >
                        <DialogPanel
                            class="w-full overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl"
                            :class="contentMaxWidth"
                        >
                            <div
                                class="flex items-center p-4"
                                :class="contentMaxWidth"
                            >
                                <DialogTitle
                                    as="h3"
                                    class="ml-auto text-2xl font-bold text-center text-neutral-900"
                                >
                                    {{ formattedTitle }}
                                </DialogTitle>
                                <!-- Transparent button with X icon -->
                                <button
                                    type="button"
                                    tabindex="-1"
                                    class="ml-auto text-sm font-semibold bg-white rounded-md text-neutral-900"
                                    @click="setIsOpen(true)"
                                >
                                    <XMarkIcon
                                        class="w-7 h-7"
                                        aria-hidden="true"
                                    />
                                </button>
                            </div>

                            <Divider />

                            <!-- Login -->
                            <div class="p-6 step-1" v-if="checkCurrentStep(1)">
                                <LoginStepOne
                                    @update:current-step="setCurrentStep"
                                />
                            </div>

                            <!-- Register -->
                            <div class="p-6 step-2" v-if="checkCurrentStep(2)">
                                <LoginStepTwo
                                    @update:current-step="setCurrentStep"
                                />
                            </div>

                            <!-- Forget Password -->
                            <div class="p-6 step-3" v-if="checkCurrentStep(3)">
                                <LoginStepThree
                                    @update:current-step="setCurrentStep"
                                />
                            </div>

                            <!-- Check Email -->
                            <div class="p-6 step-4" v-if="checkCurrentStep(4)">
                                <LoginStepFour />
                            </div>

                            <!-- Enter New Password -->
                            <div class="p-6 step-5" v-if="checkCurrentStep(5)">
                                <LoginStepFive
                                    @update:current-step="setCurrentStep"
                                />
                            </div>

                            <!-- Reset Success -->
                            <div class="p-6 step-6" v-if="checkCurrentStep(6)">
                                <LoginStepSix
                                    @update:current-step="setCurrentStep"
                                />
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script setup>
import { computed, ref } from "vue";
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
} from "@headlessui/vue";
import { XMarkIcon } from "@heroicons/vue/24/outline";
import { DialogTitle } from "@headlessui/vue";
import Divider from "@/Components/Front/Base/Divider.vue";
import LoginStepOne from "@/Components/Front/Auth/LoginStepOne.vue";
import LoginStepTwo from "@/Components/Front/Auth/LoginStepTwo.vue";
import LoginStepThree from "@/Components/Front/Auth/LoginStepThree.vue";
import LoginStepFour from "@/Components/Front/Auth/LoginStepFour.vue";
import LoginStepFive from "./LoginStepFive.vue";
import LoginStepSix from "./LoginStepSix.vue";

// Define props
const { isOpen } = defineProps({
    isOpen: Boolean,
});

// Define emits
const emit = defineEmits(["update:isOpen"]);

// Auth step
let currentStep = ref(1);

// Modal title
let title = ref("Login sebagai");

const formattedTitle = computed(() => {
    switch (currentStep.value) {
        case 1:
            return "Login";
        case 2:
            return "Daftar Akun Baru";
        case 3:
            return "Lupa Password";
        case 4:
            return "Cek Email";
        case 5:
            return "Masukkan Password Baru";
        default:
            return "Reset Berhasil";
    }
});

const contentMaxWidth = computed(() => {
    switch (currentStep.value) {
        default:
            return "max-w-96";
    }
});

function checkCurrentStep(stepNum) {
    return currentStep.value === stepNum;
}

function setCurrentStep(stepNum) {
    currentStep.value = stepNum;
}

function setIsOpen(value) {
    emit("update:isOpen", value);
    setTimeout(() => resetState(), 500);
}

function resetState() {
    currentStep.value = 1;
    title.value = "";
}
</script>
