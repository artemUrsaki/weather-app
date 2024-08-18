<script setup>
import { onMounted, ref } from 'vue';

const model = defineModel({
    type: String,
    required: true,
});

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <div>
        <label for="city-search" class="relative left-7 z-1">
            <fa-icon :icon="['fas', 'magnifying-glass']" class="text-blue-700" />
        </label>
        
        <input
            id="city-search"
            class="border-gray-300 focus:border-blue-500 focus:ring-cyan-500 rounded-md shadow-sm px pl-10 z-[-1]"
            placeholder="Search your city"
            v-model="model"
            ref="input"
        />
    </div>
</template>
