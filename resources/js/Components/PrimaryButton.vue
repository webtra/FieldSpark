<template>
    <button :type="type" @click="$emit('click')"
            class="text-[#00434b] w-full inline-flex justify-center items-center px-4 py-2 bg-[#BCDA84] border border-transparent rounded-lg font-medium text-xs tracking-wide hover:bg-[#BCDA84]/80 transition ease-in-out duration-150">
        <slot />
    </button>
</template>

<script setup>
import { defineProps } from 'vue';

defineProps({
    type: {
        type: String,
        default: 'submit',
    },
});
</script>
