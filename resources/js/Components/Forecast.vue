<script setup>
import { onMounted, ref } from 'vue';

const props = defineProps({
    weatherList: {
        required: true
    },
});

const hideDiv = ref('opacity-0');
const listHasInfo = ref(props.weatherList.length > 0);

onMounted(() => {
    setTimeout(() => {
        hideDiv.value = 'opacity-100';
    }, 600);
});
</script>

<template>
    <ul class="w-full flex justify-center mx-auto mb-4 flex rounded-xl bg-transparent/10 py-4 animate-mdSlideInFadeIn md:flex-col md:h-min" :class="hideDiv">
        <li v-if="listHasInfo" v-for="(element, key) in weatherList" class="px-5 border-r border-transparent/[.07] last:border-none flex flex-col items-center text-white font-bold md:py-1 md:flex-row md:uppercase md:justify-around md:border-r-0 md:border-b">
            <p>{{ element['time'] }}</p>
            <img :src="'img/' + element['icon'] + '_s.svg'" class="w-10 md:w-14 " alt="weather-icon">
            <div class="flex flex-col items-center">
                <p>{{ element['temp'] }}&deg</p>
                <p class="ml-[-17px] flex items-center text-blue-500 text-sm md:text-base"><img class="mr-[-5px]" src="img/raindrop.png" width="25">{{ element['precip'] }}</p>
            </div>
        </li>

        <p v-else class="text-transparent/40">There is no information yet...</p>
    </ul>
</template>