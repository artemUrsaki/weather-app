<script setup>
import TextInput from '@/Components/TextInput.vue';
</script>

<template>
    <Head title="Forecast" />
    <div class="h-screen w-full bg-cover bg-gradient-to-b">
        <header class="px-12 py-3 shadow-md">
            <nav class="flex items-center justify-between">
                <a href="/">
                    <img class="max-w-12 drop-shadow-md" src="img/logo.ico" alt="logo">
                </a>
        
                <TextInput />
            </nav>
        </header>

        <main class="mt-10">
            <slot />
        </main>
    </div>
</template>
