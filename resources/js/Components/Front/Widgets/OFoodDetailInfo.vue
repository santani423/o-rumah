<script setup>
const props = defineProps({
    title: String,
    price: String,
    area: String,
    description: String,
    workingDays: {
        type: Array,
        default: [],
    },
    lat: {
        type: Number,
        default: 0,
    },
    lng: {
        type: Number,
        default: 0,
    },
})

const mapDays = (dayName) =>
{
    switch (dayName) {
        case 'monday':
            return 'Senin'
        case 'tuesday':
            return 'Selasa'
        case 'wednesday':
            return 'Rabu'
        case 'thursday':
            return 'Kamis'
        case 'friday':
            return 'Jumat'
        case 'saturday':
            return 'Sabtu'
        default:
            return 'Minggu'
    }

}
</script>

<template>
    <div class="flex flex-col divide-y divide">
        <div class="flex flex-col pb-6 space-y-2">
            <h2 class="text-2xl font-bold text-blue-800">
                {{ price }}
            </h2>
            <h1 class="text-base font-normal ">
                {{ title }}
            </h1>
            <h6 class="text-base font-normal text-neutral-500">
                {{ area }}
            </h6>
        </div>
        <div class="flex flex-col gap-6 py-6">
            <div class="text-xl font-semibold ">Deskripsi</div>
            <div class="text-base font-normal leading-relaxed">
                {{ description }}
            </div>
        </div>
        <div v-if="workingDays.length > 0" class="flex flex-col gap-6 py-6">
            <div class="text-xl font-semibold ">Jam Buka</div>
            <ul>
                <li v-for="day in workingDays">
                    <span>{{ mapDays(day.days) }}</span> : <span
                    class="font-bold">{{ day.open_hours }} - {{
                        day.close_hours
                    }}</span>
                </li>
            </ul>
        </div>
        <div class="flex flex-col gap-6 py-6">
            <div class="text-xl font-semibold ">Lokasi</div>
            <iframe :src="`https://maps.google.com/maps?q=${lat},${lng}&hl=id;z=15&output=embed`" height="450"
                    style="border:0;" allowfullscreen="true" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
</template>
