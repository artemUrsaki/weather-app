<script setup>
import { onMounted, ref } from 'vue';
import jQuery from 'jquery';

window.$ = jQuery;

const input = ref(null);

const formatData = function (data) {
    const info = data.text.split(';');
    return $(
        '<span class="flex justify-between"><p>' + info[0] + '</p><p>' + info[1] + '</p></span>'
    );
}

const formatSelection = function (data) {
    const city = data.text.split(';')[0];
    return city;  
}

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }

    $('#city-search').select2({
        placeholder: 'Select your city',
        ajax: {
            url: '/getcities',
            dataType: 'json',
            data: function (params) {
                return {
                    city: params.term
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            }
        },
        templateResult: formatData,
        templateSelection: formatSelection
    });
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <div class="w-52">
        <select
            id="city-search"
            class="w-full"
            ref="input"
            style=""
        >
        </select>
    </div>
</template>

<!-- border-gray-300 focus:border-blue-700 focus:ring-cyan-500 rounded-md shadow-sm pl-10 z-[-1] -->