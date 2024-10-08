<script setup>
import { onMounted, ref } from 'vue';

defineProps(['weatherInfo']);

const hideDiv = ref('opacity-0');

onMounted(() => {
    setTimeout(() => {
        hideDiv.value = 'opacity-100';
    }, 400);
});
</script>

<template>
    <div class="flex flex-col items-center text-white relative mb-16 mx-auto">
        <div class="flex flex-col items-center animate-fade md:mb-8">
            <h1 class="text-4xl uppercase font-bold drop-shadow-up tracking-wider xl:text-5xl">{{ weatherInfo.city }}</h1>
            <h3 class="mt-2 capitalize xl:text-lg">{{ weatherInfo.desc }}</h3>
        </div>
        <div class="flex flex-col md:flex-row md:items-center md:justify-center md:gap-4 xl:gap-64">
            <img :src="'img/' + weatherInfo.icon + '.svg'" alt="weather_icon" class="w-64 mt-8 mb-8 drop-shadow-lg animate-scaleIn md:m-0 xl:w-72">
            <div class="flex flex-col items-center w-64 xl:w-72">
                <h2 class="text-3xl font-bold tracking-widest drop-shadow-lg animate-fade xl:text-4xl">{{ weatherInfo.temp }}&degC</h2>
                <div class="mt-8 w-full px-10 py-5 bg-transparent/10 rounded-xl animate-slideInFadeIn md:animate-XslideInFadeIn md:px-12 md:py-8" :class="hideDiv">
                    <ul class="relative min-w-44">
                        <li v-for="(value, name) in weatherInfo.other">
                            <p class="xl:text-lg">{{ name }}: <span class="absolute right-0 font-bold">{{ value }}</span></p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>