<script setup>
import TextInput from '@/Components/TextInput.vue';
import { Head } from '@inertiajs/vue3';
import FooterItem from '@/Components/FooterItem.vue';
</script>

<template>
    <Head title="Forecast" />
        <header class="px-12 py-3 shadow-md bg-white animate-slideIn">
            <nav class="flex items-center justify-between">
                <a href="/">
                    <img class="max-w-12 drop-shadow-md" src="img/logo.ico" alt="logo">
                </a>
        
                <TextInput />
            </nav>
        </header>

        <main class="mt-24">
            <slot />
        </main>

        <footer class="mt-8 bg-transparent/80">
            <div class="container mx-auto px-4 py-10 md:pt-12 md:pb-6">
                <div class="flex justify-around md:justify-center md:gap-6">
                    <FooterItem url="/" image="logo.ico"/>
                    <FooterItem url="https://www.ip2location.io/" image="ip2.svg"/>
                    <FooterItem url="https://openweathermap.org/" image="openweather.png"/>
                </div>
            </div>
            <p class="text-white text-xs pl-4 pb-4">Made By: Artem Ursaki</p>
        </footer>
</template>
