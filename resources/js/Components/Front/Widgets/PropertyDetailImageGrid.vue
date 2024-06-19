<script setup>
import VueEasyLightbox, { useEasyLightbox } from "vue-easy-lightbox";

const { media } = defineProps({
    media: Array,
});

const getMedia = (idx) => (media[idx] ? media[idx].url : "/assets/noimage.jpg");

const { show, onHide, visibleRef, indexRef, imgsRef } = useEasyLightbox({
    imgs: media.map((m) => m.url),
    initIndex: 0,
});

const showTo = (idx) => show(idx);
</script>

<template>
    <Teleport to="body">
        <vue-easy-lightbox
            :visible="visibleRef"
            :imgs="imgsRef"
            :index="indexRef"
            @hide="onHide"
        />
    </Teleport>
    <div class="grid grid-cols-4 grid-rows-2 gap-2">
        <div @click="showTo(0)" class="col-span-2 row-span-2 cursor-pointer">
            <img
                :src="getMedia(0)"
                alt="First property image"
                class="object-cover w-full h-full aspect-square"
            />
        </div>
        <div @click="showTo(1)" class="cursor-pointer">
            <img
                :src="getMedia(1)"
                alt="Second property image"
                class="object-cover w-full h-full aspect-square"
            />
        </div>
        <div @click="showTo(2)" class="cursor-pointer">
            <img
                :src="getMedia(2)"
                alt="Third property image"
                class="w-full h-full object- aspect-square"
            />
        </div>
        <div @click="showTo(3)" class="cursor-pointer">
            <img
                :src="getMedia(3)"
                alt="Fourth property image"
                class="object-cover w-full h-full aspect-square"
            />
        </div>
        <div @click="showTo(0)" class="relative cursor-pointer">
            <img
                :src="getMedia(4)"
                alt="Fifth property image"
                class="absolute inset-0 object-cover w-full h-full aspect-square"
            />
            <div class="absolute inset-0 opacity-50 bg-neutral-900"></div>
            <div class="absolute inset-0 grid place-items-center">
                <div
                    class="flex flex-col items-center px-4 py-6 space-y-4 menu-item"
                >
                    <img
                        src="/assets/icons/lainnya.png"
                        alt="lainnya-icon"
                        class="w-8 h-8"
                    />
                    <h6 class="text-sm font-bold text-white">
                        Tampilkan semua foto
                    </h6>
                </div>
            </div>
            <a href="#" class="absolute inset-0"></a>
        </div>
    </div>
</template>
