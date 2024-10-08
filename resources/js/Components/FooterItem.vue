<script setup>
defineProps({
    url: {
        type: String,
        required: true
    },
    image: {
        type: String,
        required: true
    }
});
</script>

<template>
    <a :href="url">
        <img :src="'img/' + image" :alt="image" class="h-8 md:h-10">
    </a>
</template>