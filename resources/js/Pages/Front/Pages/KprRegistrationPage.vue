<script setup>
import { Head } from '@inertiajs/vue3'
import { ArrowLeftIcon } from '@heroicons/vue/20/solid'

import FrontLayout from '@/Layouts/FrontLayout.vue'
import AgentSummary from '@/Components/Front/Widgets/AgentSummary.vue';
import KprForm from '@/Components/Front/Widgets/KprForm.vue';

const back = () => window.history.back();

defineProps({
    ads: Object,
    slug: String
})
</script>

<template>
    <FrontLayout>

        <Head :title="`${ads.title} | Ajukan KPR`" />

        <div class="gap-2 bg-white border-b border-neutral-200">
            <div class="px-4 py-4 mx-auto space-y-6 sm:px-6 lg:px-8 max-w-7xl">
                <div class="flex items-center gap-4">
                    <button type="button" @click="back()"
                        class="p-2 rounded-lg hover:bg-neutral-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-neutral-600">
                        <ArrowLeftIcon class="w-5 h-5" aria-hidden="true" />
                    </button>
                    <div class="text-lg font-bold leading-normal">Ajukan KPR</div>
                </div>
            </div>
        </div>

        <div class="px-4 mx-auto space-y-6 max-w-7xl sm:p-6 lg:p-8">
            <div class="flex space-x-6">
                <div class="w-2/5">
                    <AgentSummary :ads="ads" />
                </div>
                <div class="w-3/5">
                    <KprForm />
                </div>
            </div>
        </div>
    </FrontLayout>
</template>
