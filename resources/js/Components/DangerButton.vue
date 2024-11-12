<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
});
</script>

<template>
    <button :type="type" class="w-fit inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-lg text-xs text-white hover:bg-red-500 active:bg-red-700 transition ease-in-out duration-150">
        <slot />
    </button>
</template>
