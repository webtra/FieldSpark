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
            class="text-white w-full inline-flex justify-center items-center px-4 py-2 bg-[#00434b] border border-transparent rounded text-xs tracking-wide hover:bg-[#00434b]/90 transition ease-in-out duration-150">
        <slot />
    </button>
</template>