<template>
  <RadioGroup v-model="selectedMailingLists">
    <div class="mt-4 grid grid-cols-5 gap-y-6 sm:gap-x-4">
      <RadioGroupOption as="template" v-for="radioList in radioLists" :key="radioList.id" :value="radioList.id"
        v-slot="{ checked, active }">
        <div
          :class="[checked ? 'border-transparent' : 'border-neutral-300', active ? 'border-neutral-600 ring-2 ring-neutral-600' : '', 'relative flex cursor-pointer rounded-lg border bg-white p-3 shadow-sm focus:outline-none']">
          <CheckCircleIcon :class="[!checked ? 'invisible' : '', 'h-5 w-5 text-neutral-600 mr-3']" aria-hidden="true" />
          <span class="flex flex-1">
            <span class="flex flex-col">
              <RadioGroupLabel as="span" class="block text-sm font-medium text-neutral-900">{{ radioList.title }}
              </RadioGroupLabel>
            </span>
          </span>
          <span
            :class="[active ? 'border' : 'border-2', checked ? 'border-neutral-600' : 'border-transparent', 'pointer-events-none absolute -inset-px rounded-lg']"
            aria-hidden="true" />
        </div>
      </RadioGroupOption>
    </div>
  </RadioGroup>
</template>

<script setup>
import { ref } from 'vue'
import { RadioGroup, RadioGroupLabel, RadioGroupOption } from '@headlessui/vue'
import { CheckCircleIcon } from '@heroicons/vue/20/solid'

const props = defineProps({
  radioLists: Array
})

const selectedMailingLists = ref('')
</script>
