<script setup>
import { Head, usePage, useForm } from "@inertiajs/vue3";
import { ref } from "vue";

import FrontLayout from "@/Layouts/FrontLayout.vue";

import Breadcrumbs from "@/Components/Front/Base/Breadcrumbs.vue";
import MobileComingSoon from "@/Components/Front/Base/MobileComingSoon.vue";
import RightAds from "@/Components/Front/Widgets/RightSection.vue";
import InputError from "@/Components/Front/Form/InputError.vue";
import Card from "@/Components/Front/Widgets/Card.vue";
import FormInput from "@/Pages/Listing/components/FormInput.vue";
import { CheckCircleIcon, XCircleIcon } from "@heroicons/vue/24/solid";

const user = usePage().props.auth.user;

const file = ref(null);
const fileCompany = ref(null);

const form = useForm({
    id: user.id,
    image: null,
    previewImage: user.image,
    name: user.name,
    bio: user.bio,
    username: user.username,
    email: user.email,
    phone: user.phone,
    wa_phone: user.wa_phone,

    company_name: user.company_name,
    company_image: null,
    previewCompanyImage: user.company_image,

    bank_name: user.bank_name,
    bank_number: user.bank_number,
});

const passwordForm = useForm({
    old_password: "",
    password: "",
    password_confirmation: "",
});

function selectImage() {
    file.value.click();
}

function onSelectFile(e) {
    form.image = e.target.files[0];

    let fileSrc = URL.createObjectURL(form.image);
    form.previewImage = fileSrc;
    setTimeout(() => {
        URL.revokeObjectURL(fileSrc);
    }, 1000);
}

function selectCompanyImage() {
    fileCompany.value.click();
}

function onSelectCompanyFile(e) {
    form.company_image = e.target.files[0];

    let fileSrc = URL.createObjectURL(form.company_image);
    form.previewCompanyImage = fileSrc;
    setTimeout(() => {
        URL.revokeObjectURL(fileSrc);
    }, 1000);
}

const submit = () => {
    form.post(route("updateProfile"));
};

const submitPassword = () => {
    passwordForm.post(route("updatePassword"), {
        preserveScroll: true,
    });
};
</script>

<template>
    <MobileComingSoon />
    <FrontLayout>
        <Head :title="`Edit Profil | ${user.name}`" />

        <div class="px-4 mx-auto space-y-6 max-w-7xl sm:p-6 lg:p-8">
            <div class="flex gap-12">
                <div class="w-4/5 space-y-6">
                    <!-- Breadcrumbs -->
                    <Breadcrumbs
                        :pages="[
                            { name: 'Edit Profil', url: null, current: true },
                        ]"
                    />

                    <!-- Flash Message -->
                    <div
                        class="md:flex justify-between mt-5 border-green-600 border-[1px] bg-green-50 p-4 rounded-sm text-green-600"
                        v-if="$page.props.flash.success"
                    >
                        <div class="flex items-center">
                            <CheckCircleIcon class="w-6 h-6 text-green-600" />
                            <p class="ml-3 text-sm">
                                {{ $page.props.flash.success }}
                            </p>
                        </div>
                    </div>

                    <!-- Flash Message -->
                    <div
                        class="md:flex justify-between mt-5 border-red-600 border-[1px] bg-red-50 p-4 rounded-sm text-red-600"
                        v-if="$page.props.flash.error"
                    >
                        <div class="flex items-center">
                            <XCircleIcon class="w-6 h-6 text-red-600" />
                            <p class="ml-3 text-sm">
                                {{ $page.props.flash.error }}
                            </p>
                        </div>
                    </div>

                    <!-- Form -->
                    <form>
                        <div class="mb-5">
                            <Card :card-title="'Informasi Umum'">
                                <div class="mb-3">
                                    <label
                                        for="avatar"
                                        class="block text-sm font-medium leading-6 text-neutral-900"
                                        >Foto Profil
                                    </label>
                                    <div class="flex items-center mt-2 gap-x-3">
                                        <div
                                            v-if="form.previewImage != null"
                                            class="w-16 h-16"
                                        >
                                            <img
                                                :src="form.previewImage"
                                                :alt="form.previewImage"
                                                class="w-full h-full object-cover rounded-full"
                                            />
                                        </div>
                                        <svg
                                            v-else
                                            class="w-16 h-16 text-neutral-300"
                                            viewBox="0 0 24 24"
                                            fill="currentColor"
                                            aria-hidden="true"
                                        >
                                            <path
                                                fill-rule="evenodd"
                                                d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"
                                                clip-rule="evenodd"
                                            />
                                        </svg>
                                        <input
                                            id="file-upload"
                                            ref="file"
                                            name="file-upload"
                                            type="file"
                                            class="sr-only"
                                            hidden
                                            @change="onSelectFile"
                                        />
                                        <button
                                            type="button"
                                            class="rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-neutral-900 shadow-sm ring-1 ring-inset ring-neutral-300 hover:bg-neutral-50"
                                            @click="selectImage()"
                                        >
                                            Ubah Foto
                                        </button>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <FormInput
                                        :title="'Nama Lengkap'"
                                        :placeholder="'Masukkan nama lengkap'"
                                        v-model="form.name"
                                    />
                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.name"
                                    />
                                </div>
                                <div class="mb-3">
                                    <FormInput
                                        :title="'Username'"
                                        :placeholder="'Masukkan username'"
                                        v-model="form.username"
                                    />
                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.username"
                                    />
                                </div>
                                <div class="mb-3">
                                    <FormInput
                                        :title="'Alamat Email'"
                                        :placeholder="'Masukkan email'"
                                        v-model="form.email"
                                    />
                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.email"
                                    />
                                </div>
                                <div class="mb-3">
                                    <div class="block">
                                        <p class="mb-3 text-sm font-medium">
                                            Deskripsi singkat tentang anda
                                        </p>
                                        <textarea
                                            v-model="form.bio"
                                            rows="3"
                                            class="border-neutral-300 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-300 focus:border-neutral-500 dark:focus:border-neutral-600 focus:ring-neutral-500 dark:focus:ring-neutral-600 rounded-md shadow-sm w-full placeholder:text-sm text-sm"
                                        ></textarea>
                                        <small class="text-xs text-neutral-500"
                                            >*) maks. 100 karakter</small
                                        >
                                    </div>
                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.bio"
                                    />
                                </div>
                                <div class="mb-3">
                                    <FormInput
                                        :title="'No. Handphone'"
                                        :placeholder="'Masukkan nomor handphone'"
                                        v-model="form.phone"
                                    />
                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.phone"
                                    />
                                </div>
                                <div class="mb-3">
                                    <FormInput
                                        :title="'Nomor WhatsApp'"
                                        :placeholder="'Masukkan nomor WhatsApp'"
                                        v-model="form.wa_phone"
                                    />
                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.wa_phone"
                                    />
                                </div>
                            </Card>
                        </div>

                        <div class="mb-5">
                            <Card :card-title="'Ganti Password'">
                                <div
                                    class="md:flex justify-between mb-4 border-green-600 border-[1px] bg-green-50 p-4 rounded-sm text-green-600"
                                    v-if="$page.props.flash.success"
                                >
                                    <div class="flex items-center">
                                        <CheckCircleIcon
                                            class="w-6 h-6 text-green-600"
                                        />
                                        <p class="ml-3 text-sm">
                                            {{ $page.props.flash.success }}
                                        </p>
                                    </div>
                                </div>

                                <div
                                    class="md:flex justify-between mb-4 border-red-600 border-[1px] bg-red-50 p-4 rounded-sm text-red-600"
                                    v-if="$page.props.flash.error"
                                >
                                    <div class="flex items-center">
                                        <XCircleIcon
                                            class="w-6 h-6 text-red-600"
                                        />
                                        <p class="ml-3 text-sm">
                                            {{ $page.props.flash.error }}
                                        </p>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <FormInput
                                        :title="'Masukkan password lama'"
                                        type="password"
                                        v-model="passwordForm.old_password"
                                    />
                                    <InputError
                                        class="mt-2"
                                        :message="
                                            passwordForm.errors.old_password
                                        "
                                    />
                                </div>
                                <div class="mb-3">
                                    <FormInput
                                        :title="'Masukkan password baru'"
                                        type="password"
                                        v-model="passwordForm.password"
                                    />
                                    <InputError
                                        class="mt-2"
                                        :message="passwordForm.errors.password"
                                    />
                                </div>
                                <div class="mb-4">
                                    <FormInput
                                        :title="'Ulangi password baru'"
                                        type="password"
                                        v-model="
                                            passwordForm.password_confirmation
                                        "
                                    />
                                    <InputError
                                        class="mt-2"
                                        :message="
                                            passwordForm.errors
                                                .password_confirmation
                                        "
                                    />
                                </div>
                                <div class="flex justify-end">
                                    <button
                                        type="button"
                                        class="bg-[#1CD6D0] hover:bg-teal-500 disabled:bg-[#EAEBF0] disabled:text-[#B1B2CE] text-white py-2 px-4 rounded-md"
                                        :class="{
                                            'bg-[#EAEBF0]':
                                                passwordForm.processing,
                                            'text-[#B1B2CE]':
                                                passwordForm.processing,
                                        }"
                                        :disabled="passwordForm.processing"
                                        @click="submitPassword()"
                                    >
                                        Ganti Password
                                    </button>
                                </div>
                            </Card>
                        </div>

                        <div class="mb-5">
                            <Card :card-title="'Profil Perusahaan'">
                                <div class="mb-3">
                                    <div class="mb-3">
                                        <FormInput
                                            :title="'Nama Perusahaan'"
                                            :placeholder="'Masukkan nama perusahaan'"
                                            v-model="form.company_name"
                                        />
                                        <InputError
                                            class="mt-2"
                                            :message="form.errors.company_name"
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <label
                                            for="avatar"
                                            class="block text-sm font-medium leading-6 text-neutral-900"
                                            >Logo Perusahaan</label
                                        >
                                        <div
                                            class="flex items-center mt-2 gap-x-3"
                                        >
                                            <div
                                                v-if="
                                                    form.previewCompanyImage !=
                                                    null
                                                "
                                                class="w-16 h-16"
                                            >
                                                <img
                                                    :src="
                                                        form.previewCompanyImage
                                                    "
                                                    alt=""
                                                    class="w-full h-full object-cover rounded-full"
                                                />
                                            </div>
                                            <svg
                                                v-else
                                                class="w-16 h-16 text-neutral-300"
                                                viewBox="0 0 24 24"
                                                fill="currentColor"
                                                aria-hidden="true"
                                            >
                                                <path
                                                    fill-rule="evenodd"
                                                    d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"
                                                    clip-rule="evenodd"
                                                />
                                            </svg>
                                            <input
                                                ref="fileCompany"
                                                type="file"
                                                class="sr-only"
                                                hidden
                                                @change="onSelectCompanyFile"
                                            />
                                            <button
                                                type="button"
                                                class="rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-neutral-900 shadow-sm ring-1 ring-inset ring-neutral-300 hover:bg-neutral-50"
                                                @click="selectCompanyImage()"
                                            >
                                                Ubah Foto
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </Card>
                        </div>

                        <div class="mb-5">
                            <Card :card-title="'Profil Perusahaan'">
                                <div class="mb-3">
                                    <div class="mb-3">
                                        <label
                                            for="bank_name"
                                            class="block text-sm font-medium leading-6 text-neutral-900"
                                            >Nama Bank</label
                                        >
                                        <select
                                            id="bank_name"
                                            name="bank_name"
                                            v-model="form.bank_name"
                                            class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-neutral-900 ring-1 ring-inset ring-neutral-300 focus:ring-2 focus:ring-neutral-600 sm:text-sm sm:leading-6"
                                        >
                                            <option selected>Pilih Bank</option>
                                            <option value="BCA">
                                                Bank BCA
                                            </option>
                                            <option value="BNI">
                                                Bank BNI
                                            </option>
                                            <option value="BRI">
                                                Bank BRI
                                            </option>
                                            <option value="OCBC">
                                                Bank OCBC
                                            </option>
                                        </select>
                                        <InputError
                                            class="mt-2"
                                            :message="form.errors.bank_name"
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <FormInput
                                            :title="'No. Rekening Bank'"
                                            :placeholder="'Masukkan nomor rekening bank'"
                                            v-model="form.bank_number"
                                        />
                                        <InputError
                                            class="mt-2"
                                            :message="form.errors.bank_number"
                                        />
                                    </div>
                                </div>
                            </Card>
                        </div>

                        <div class="flex justify-end my-3">
                            <button
                                type="button"
                                class="bg-[#1CD6D0] hover:bg-teal-500 disabled:bg-[#EAEBF0] disabled:text-[#B1B2CE] text-white py-2 px-4 rounded-md"
                                :class="{
                                    'bg-[#EAEBF0]': form.processing,
                                    'text-[#B1B2CE]': form.processing,
                                }"
                                :disabled="form.processing"
                                @click="submit()"
                            >
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>

                <!-- <div class="w-1/5">
                    <RightAds />
                </div> -->
            </div>
        </div>
    </FrontLayout>
</template>
