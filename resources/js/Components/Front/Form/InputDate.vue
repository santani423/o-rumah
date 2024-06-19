<script setup>
import { ref } from 'vue';
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'

const inputDate = ref();

defineProps({
    type: String,
    name: String,
    placeholder: String
});
</script>

<template>
    <div class="rounded-md">
        <VueDatePicker v-model="inputDate" format="dd/MM/yyyy" :enable-time-picker="false"></VueDatePicker>
    </div>
</template>

<style scoped>
.dp__theme_light {
    --dp-input-padding: 10px 30px 10px 12px;
}
</style>
