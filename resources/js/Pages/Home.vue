<script setup>
import { Head, Link } from '@inertiajs/vue3';
import PageLayout from '@/Layouts/PageLayout.vue';

defineProps({
    temp: String
});

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>
    <Head title="Forecast" />
    
    <PageLayout>
        <main class="container">
            <h1>{{ temp }}</h1>
        </main>
    </PageLayout>
</template>
