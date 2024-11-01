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
        class="text-[#00434b] w-full inline-flex justify-center items-center px-4 py-2 bg-[#BCDA84] border border-transparent rounded font-medium text-xs tracking-wide [#00434b] hover:bg-[#BCDA84]/80 transition ease-in-out duration-150">
        <slot />
    </button>
</template>
