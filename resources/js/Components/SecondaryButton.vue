<template>
    <button :type="type" @click="$emit('click')"
            class="text-white w-full inline-flex justify-center items-center px-4 py-2 bg-[#00434b] border border-transparent rounded-lg text-xs tracking-wide hover:bg-[#00434b]/90 transition ease-in-out duration-150">
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
