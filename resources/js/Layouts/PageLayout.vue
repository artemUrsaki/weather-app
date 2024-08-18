<script setup>
import TextInput from '@/Components/TextInput.vue';

</script>

<template>
    <header class="px-12 py-3 shadow-md mb-10">
        <nav class="flex items-center justify-between">
            <a href="/">
                <img class="max-w-12 drop-shadow-md" src="img/logo.ico" alt="logo">
            </a>
    
            <TextInput />
        </nav>
    </header>

    <slot />
</template>
