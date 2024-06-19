<script setup>
import { vMaska } from 'maska'
import { numberOptions } from '@/lib/utils'
import { computed } from 'vue'

const props = defineProps(['amount', 'countingOption'])
const emit = defineEmits(['update:amount', 'update:countingOption'])

const isMoneyCounting = computed(() => {
    return props.countingOption === 'money'
});
</script>

<template>
    <div>
        <div class="relative rounded-md">
            <div v-if="isMoneyCounting" class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <span class="text-neutral-500 sm:text-sm">Rp.</span>
            </div>
            <input type="text"
                   v-maska:[numberOptions]
                :value="props.amount"
                @input="emit('update:amount', $event.target.value)"
                   :class="isMoneyCounting ? 'pl-10' : 'pl-3'"
                class="block w-full py-2.5 pl-10 pr-20 border-0 rounded-md text-neutral-900 placeholder:text-neutral-400 ring-1 ring-inset ring-neutral-300 focus:ring-1 focus:ring-inset focus:ring-neutral-300 sm:text-sm sm:leading-6"
                placeholder="0" />
            <div class="absolute inset-y-0 right-0 flex items-center">
                <select
                    :value="props.countingOption"
                    @input="emit('update:countingOption', $event.target.value)"
                    class="h-full px-3 py-0 border-0 rounded-tr-md rounded-br-md text-neutral-500 pr-7 bg-zinc-100 sm:text-sm ring-1 ring-inset ring-neutral-300 focus:ring-1 focus:ring-inset focus:ring-neutral-300">
                    <option value="money">IDR</option>
                    <option value="percent">%</option>
                </select>
            </div>
        </div>
    </div>
</template>
