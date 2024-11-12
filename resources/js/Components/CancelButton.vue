<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
});
</script>

<template>
    <button :type="type"
            class="text-gray-700 w-fit inline-flex justify-center items-center px-4 py-2 bg-gray-200 border border-transparent rounded-lg font-medium text-xs tracking-wide hover:bg-gray-300 transition ease-in-out duration-150">
        <slot />
    </button>
</template>
