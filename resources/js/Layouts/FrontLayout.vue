<script setup>
import Navbar from '@/Components/Front/Base/Navbar.vue'
import Footer from '@/Components/Front/Base/Footer.vue'
</script>

<template>
    <div class="flex flex-col h-full">
        <Navbar />
        <div class="flex-1 mt-16 min-h-[600px]">
            <slot />
        </div>
        <Footer />
    </div>
</template>
