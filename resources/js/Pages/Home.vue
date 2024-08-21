<script setup>
import { Head, Link } from '@inertiajs/vue3';
import PageLayout from '@/Layouts/PageLayout.vue';

const props = defineProps({
    city: String,
    temp: Number,
    wind: Number,
    symbol: Number,
});

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}

const background = {
    1: ['from-[#FFFFFF]', 'via-[#6DD5FA]', 'to-[#2980B9]'],
};

const currentBg = background[props.symbol];

</script>

<template>    
    <PageLayout :class="currentBg">
        <div class="container mx-auto">
            <div class="flex flex-col items-center pt-40">
                <h1 class="text-3xl uppercase">{{ city }}</h1>
                <img :src="'img/' + symbol + '.svg'" alt="weather_symbol" class="max-h-60 mt-20 mb-14">
                <h2 class="text-xl">{{ temp }}&degC</h2>
            </div>
        </div>
    </PageLayout>
</template>
