<script setup>
import PageLayout from '@/Layouts/PageLayout.vue';
import { ref, onMounted } from 'vue';

const props = defineProps({
    city: String,
    temp: Number,
    wind: Number,
    windGusts: Number,
    precip: Number,
    icon: String,
    desc: String,
    forecast: Array,  
});

const changer = ref(0);

const weatherInfo = ref({
    city: props.city,
    temp: props.temp,
    icon: props.icon,
    desc: props.desc,
    other: {
        'Wind': props.wind, 
        'Wind Gusts': props.windGusts,
        'Precipitation': props.precip,
    },
    forecast: props.forecast,
});

const hideDiv = ref('hidden');

const background = function(icon) {
    if (weatherInfo.value.icon.indexOf('n') > -1) 
        return ['from-[#000428]', 'to-[#004e92]'];
    
    switch (icon) {
        case '01d':
            return ['from-[#2980B9]', 'via-[#6DD5FA]', 'to-[#FFFFFF]'];
        case '02d':
        case '03d':
            return ['from-[#8e9eab]', 'to-[#eef2f3]'];
        case '04d':
        case '09d':
        case '11d':
        case '13d':
            return ['from-[#000C40]', 'to-[#F0F2F0]'];
        case '10d':
        case '50d':
            return ['from-[#19547b]', 'to-[#ffd89b]'];
    }
};

const currentBg = ref(background(weatherInfo.value.icon));

const updateProps = function (newProps) {
    for (const [key, value] of Object.entries(weatherInfo.value)) {
        if (key === 'other') {
            weatherInfo.value.other['Wind'] = newProps.wind;
            weatherInfo.value.other['Wind Gusts'] = newProps.windGusts;
            weatherInfo.value.other['Precipitation'] = newProps.precip;
        }
        else weatherInfo.value[key] = newProps[key];
    }
    currentBg.value = background(weatherInfo.value.icon);
    changer.value += 1;
};

onMounted(() => {
    setTimeout(() => {
        hideDiv.value = 'block';
    }, 500);

    $('#city-search').on('select2:select', function (data) {
        const info = data.params.data.text.split(';');
        $.ajax({
            url: '/getCityWeather?city_name=' + info[0] + '&latitude=' + info[2] + '&longitude=' + info[3],
            dataType: "json",
            success: function(data) {
                console.log(data);
                updateProps(data);
            }
        });
    });
});

</script>

<template>
    <div class="absolute z-[-1] h-screen w-full animate-fadeBg bg-cover bg-gradient-to-b" :class="currentBg" :key="changer"></div>
    <PageLayout>
        <div class="container mx-auto" :key="changer">
            <div class="flex flex-col md:flex-row items-center mt-40 text-white relative">
                <img :src="'img/' + weatherInfo.icon + '.svg'" alt="weather_icon" class="h-64 mt-32 mb-8 drop-shadow-lg animate-scaleIn md:m-0 md:h-45 md:ml-10">
                <h2 class="text-2xl font-bold tracking-widest drop-shadow-lg animate-fade md:absolute right-0 bottom-0">{{ weatherInfo.temp }}&degC</h2>
                <div class="absolute md:right-0 md:top-0 flex flex-col items-center animate-fade">
                    <h1 class="text-4xl uppercase font-bold drop-shadow-up tracking-wider">{{ weatherInfo.city }}</h1>
                    <h3 class="mt-2 capitalize">{{ weatherInfo.desc }}</h3>
                </div>
                <div class="mt-10 px-10 py-5 md:absolute right-0 bg-transparent/10 rounded-xl animate-slideInFadeIn" :class="hideDiv">
                    <ul class="relative min-w-44">
                        <li v-for="(value, name) in weatherInfo.other">
                            {{ name }}: <span class="absolute right-0 font-bold">{{ value }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </PageLayout>
</template>