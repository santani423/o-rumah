<script setup>
import CustomDropdown from '@/Components/Front/Form/CustomDropdown.vue'
import Input from '@/Components/Front/Form/Input.vue'
import InputDate from '@/Components/Front/Form/InputDate.vue'
import InputFile from '../Form/InputFile.vue';

const banks = [
    {
        id: 1,
        name: 'Bank BTN',
        avatar: 'https://via.placeholder.com/200',
    },
    {
        id: 2,
        name: 'Bank BSI',
        avatar: 'https://via.placeholder.com/200',
    },
]
</script>

<template>
    <div class="space-y-4">
        <div class="flex flex-col items-start justify-start bg-white border border-neutral-300 rounded-xl">
            <div class="w-full p-4 border-b border-neutral-300">
                <div class="text-lg font-semibold">Dokumen Pengajuan KPR</div>
                <div class="mt-1">Silahkan lengkapi seluruh dokumen untuk pengajuan KPR</div>
            </div>
            <form class="flex flex-col w-full gap-4 p-4">
                <div class="flex flex-col gap-3 md:flex-row md:gap-4">
                    <div class="flex-col gap-1.5 flex md:w-1/2">
                        <div class="text-xs font-normal text-neutral-600">Bank Umum</div>
                        <CustomDropdown :options="banks" />
                    </div>
                    <div class="flex-col gap-1.5 flex md:w-1/2">
                        <div class="text-xs font-normal text-neutral-600">Bank BPR</div>
                        <CustomDropdown :options="banks" />
                    </div>
                </div>
                <div class="flex-col gap-1.5 flex">
                    <div class="text-xs font-normal text-neutral-600">Nama lengkap</div>
                    <Input type="text" name="name" />
                </div>
                <div class="flex flex-col gap-3 md:flex-row md:gap-4">
                    <div class="flex-col gap-1.5 flex md:w-1/2">
                        <div class="text-xs font-normal text-neutral">Alamat email</div>
                        <Input type="email" name="email" />
                    </div>
                    <div class="flex-col gap-1.5 flex md:w-1/2">
                        <div class="text-xs font-normal text-neutral-600">Nomor telepon</div>
                        <Input type="text" name="phone" />
                    </div>
                </div>
                <div class="flex-col gap-1.5 flex">
                    <div class="text-xs font-normal text-neutral-600">KTP pemohon (Suami/Istri)</div>
                    <InputFile />
                </div>
                <div class="flex-col gap-1.5 flex">
                    <div class="text-xs font-normal text-neutral-600">Kartu keluarga</div>
                    <InputFile />
                </div>
                <div class="flex-col gap-1.5 flex">
                    <div class="text-xs font-normal text-neutral-600">NPWP</div>
                    <InputFile />
                </div>
                <div class="flex-col gap-1.5 flex">
                    <div class="text-xs font-normal text-neutral-600">Surat nikah / cerai</div>
                    <InputFile />
                </div>
                <div class="flex-col gap-1.5 flex">
                    <div class="text-xs font-normal text-neutral-600">Rekening koran 3 bulan terakhir</div>
                    <InputFile />
                </div>
                <div class="flex-col gap-1.5 flex">
                    <div class="text-xs font-normal text-neutral-600">Slip gaji</div>
                    <InputFile />
                </div>
                <fieldset>
                    <legend class="sr-only">Persetujuan</legend>
                    <div class="p-4 bg-neutral-100">
                        <div class="relative flex items-start">
                            <div class="flex items-center h-6">
                                <input id="tnc" aria-describedby="tnc-description" name="tnc" type="checkbox"
                                    class="w-4 h-4 text-teal-500 border-teal-300 rounded focus:ring-teal-500" />
                            </div>
                            <div class="ml-3 text-sm leading-6">
                                <label for="tnc" class="text-neutral-900">Saya menyetujui bahwa dokumen dipercayakan
                                    kepada ORumah untuk dipergunakan proses pengajuan BI checking/KPR untuk
                                    dipergunakan seperlu nya</label>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <button type="submit"
                    class="self-end inline-flex items-center gap-x-2 flex-1 justify-center rounded-md px-3.5 py-2.5 text-white ring-1 bg-teal-400 ring-inset ring-teal-400 hover:bg-teal-500">
                    Proses Data
                </button>
            </form>
        </div>
    </div>
</template>
