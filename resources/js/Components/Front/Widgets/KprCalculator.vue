<script setup>
import { ref, watchEffect } from 'vue'

import CustomDropdown from '@/Components/Front/Form/CustomDropdown.vue'
import DefaultButton from '@/Components/Front/Widgets/DefaultButton.vue'
import InputWithDropdown from '@/Components/Front/Form/InputWithDropdown.vue'
import ShowKprResultModal
    from '@/Components/Front/Widgets/ShowKprResultModal.vue'

const { price } = defineProps({
    price: Number,
})

const isModalShow = ref(false)

const setIsModalShow = (value) => {
    isModalShow.value = value
}

const daysPerMonth = 30
const daysPerYear = 365
const monthInYear = 12

// format price to rupiah
const formatter = new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 0,
})

const formatPrice = (price) => {
    return formatter.format(price).replace('Rp', '').trim()
}

// const banks = [
//     {
//         id: 1,
//         name: 'Bank BTN',
//         avatar: 'https://via.placeholder.com/200',
//     },
//     {
//         id: 2,
//         name: 'Bank BSI',
//         avatar: 'https://via.placeholder.com/200',
//     },
// ]

const interestPeriod = [
    {
        id: 1,
        name: 'Fixed 5 tahun, 5.99% / tahun',
        value: 5.99,
        fixed: 5,
    },
    {
        id: 2,
        name: 'Fixed 10 tahun, 7.99% / tahun',
        value: 7.99,
        fixed: 10,
    },
]

const timePeriod = [
    {
        id: 1,
        name: '5 Tahun',
        value: 5,
    },
    {
        id: 2,
        name: '10 Tahun',
        value: 10,
    },
    {
        id: 3,
        name: '15 Tahun',
        value: 15,
    },
    {
        id: 4,
        name: '20 Tahun',
        value: 20,
    },
    {
        id: 5,
        name: '25 Tahun',
        value: 25,
    },
    {
        id: 6,
        name: '30 Tahun',
        value: 30,
    },
]

function floating (
    jumlahPinjaman,
    jangkaWaktu,
    sukuBunga,
    sbFloating,
    bulanFloating,
) {
    const angsuran = []
    let sisaPinjaman = jumlahPinjaman
    const pokok = jumlahPinjaman / jangkaWaktu

    sukuBunga = sukuBunga / 100

    for (let i = 0; i < jangkaWaktu; i++) {
        // looping starts from 0, so bulanFloating should be minus 1
        if (jangkaWaktu === (bulanFloating - 1)) {
            const bunga = sisaPinjaman * sbFloating *
                (daysPerMonth / daysPerYear)
        }

        const bunga = sisaPinjaman * sukuBunga * (daysPerMonth / daysPerYear)
        const jumlahAngsuran = (pokok + bunga)
        sisaPinjaman -= pokok

        angsuran.push({
            no: i + 1,
            pokok: parseInt(pokok.toFixed(2)),
            bunga: parseInt(bunga.toFixed(2)),
            jumlahAngsuran: parseInt(jumlahAngsuran.toFixed(2)),
            sisaPinjaman: parseInt(sisaPinjaman.toFixed(2)),
        })
    }

    return angsuran
}

let downPaymentAmount = ref(0)
let downPaymentType = ref('money')
let interestTotal = ref(interestPeriod[0])
let timePeriodTotal = ref(timePeriod[0])

let installmentsResult = ref([])

watchEffect(() => {
    if (downPaymentType.value === 'percent') {
        if (downPaymentAmount.value > 100) {
            downPaymentAmount.value = 100
        }
    }
})

const handleInterestTotalChange = (value) => {
    interestTotal.value = value
}

const handleTimePeriodTotalChange = (value) => {
    timePeriodTotal.value = value
}

const calculate = () => {
    downPaymentAmount.value = downPaymentAmount.value.replace(/,/g, '')

    const months = timePeriodTotal.value.value * monthInYear
    const annualInterest = interestTotal.value.value
    const fixedPeriod = interestTotal.value.fixed

    let finalPrice = 0

    if (downPaymentType.value === 'money') {
        finalPrice = price - downPaymentAmount.value
    }

    if (downPaymentType.value === 'percent') {
        finalPrice = (price * downPaymentAmount.value) / 100
    }

    installmentsResult.value = floating(finalPrice, months, annualInterest,
        annualInterest, (fixedPeriod * monthInYear))

    setIsModalShow(true)

}

</script>

<template>
    <div
        class="flex flex-col items-start justify-start bg-white border border-neutral-300 rounded-xl">
        <div class="w-full p-4 border-b border-neutral-300">
            <div class="text-xl font-semibold tracking-wide">Simulasi KPR</div>
        </div>
        <div class="flex flex-col w-full gap-4 p-4">
            <div class="flex-col gap-1.5 flex">
                <h6 class="text-xs font-normal capitalize text-neutral-600">
                    Harga Properti
                </h6>
                <span class="text-base font-semibold tracking-wide ">Rp. {{
                        formatPrice(price)
                    }}</span>
            </div>
            <!-- <div class="flex-col gap-1.5 flex">
                <div class="text-xs font-normal text-neutral-600">Bank</div>
                <CustomDropdown :options="banks" />
            </div> -->
            <div class=" flex-col gap-1.5 flex">
                <div class="text-xs font-normal text-neutral-600">Jumlah DP
                </div>
                <InputWithDropdown v-model:amount="downPaymentAmount"
                                   v-model:countingOption="downPaymentType"/>
            </div>
            <div class=" flex-col gap-1.5 flex">
                <div class="text-xs font-normal text-neutral-600">Suku Bunga
                </div>
                <CustomDropdown
                    :options="interestPeriod"
                    v-model:selected-options="interestTotal"
                    @update:selected-options="handleInterestTotalChange" />
            </div>
            <div class=" flex-col gap-1.5 flex">
                <div class="text-xs font-normal text-neutral-600">Jangka Waktu
                    (5-30 tahun)
                </div>
                <CustomDropdown
                    :options="timePeriod"
                    v-model:selected-options="timePeriodTotal"
                    @update:selected-options="handleTimePeriodTotalChange" />
            </div>
            <div class="flex-col gap-1.5 flex">
                <DefaultButton
                    @click="calculate"
                    class="w-full rounded-md justify-center text-white border border-teal-500 !bg-teal-500 hover:!bg-teal-600 hover:!border-teal-600">
                    Hitung
                </DefaultButton>
            </div>
        </div>
    </div>
    <ShowKprResultModal
        :is-open="isModalShow"
        @update:is-open="setIsModalShow(false)"
        :kpr-data="installmentsResult" />
</template>
