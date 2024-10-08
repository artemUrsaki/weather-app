<script setup>
import PageLayout from '@/Layouts/PageLayout.vue';
import { ref, onMounted } from 'vue';
import MainWeather from '@/Components/MainWeather.vue';
import Forecast from '@/Components/Forecast.vue';

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
});

const forecastRef = ref(props.forecast);

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
    forecastRef.value = newProps['forecast'];
    currentBg.value = background(weatherInfo.value.icon);
    changer.value += 1;
};

onMounted(() => {
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
    <div class="absolute z-[-1] h-full w-full animate-fadeBg bg-cover bg-gradient-to-b" :class="currentBg" :key="changer"></div>
    <PageLayout>
        <div class="container mx-auto px-4" :key="changer">
            <MainWeather :weatherInfo="weatherInfo" />
            
            <div class="md:flex md:gap-4 xl:gap-8">
                <Forecast :weather-list="forecastRef[0]" />
                <Forecast :weather-list="forecastRef[1]" />
            </div>
        </div>
    </PageLayout>
</template>