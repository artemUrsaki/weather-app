<script setup>
import TextInput from '@/Components/TextInput.vue';
import { Head } from '@inertiajs/vue3';
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

        <main class="mt-20">
            <slot />
        </main>
</template>
