<script setup>
import PageLayout from '@/Layouts/PageLayout.vue';

defineProps({
    error: String
});
</script>

<template>
    <div class="absolute z-[-1] h-full w-full animate-fadeBg bg-cover bg-gradient-to-b from-[#141E30] to-[#243B55]"></div>
    <PageLayout>
        <div class="flex flex-col items-center text-white h-screen">
            <h1 class="font-bold uppercase text-4xl tracking-wider">Error!</h1>
            <p class="mt-2">{{ error }}</p>
        </div>
    </PageLayout>
</template>