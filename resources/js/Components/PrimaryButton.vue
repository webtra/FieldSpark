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
        class="w-full inline-flex justify-center items-center px-4 py-2 bg-blue-500 border border-transparent rounded font-medium text-xs tracking-wide text-white hover:bg-blue-600 transition ease-in-out duration-150">
        <slot />
    </button>
</template>
