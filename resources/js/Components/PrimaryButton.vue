<template>
    <button :type="type" @click="handleClick"
            class="text-[#00434b] w-full inline-flex justify-center items-center px-4 py-2 bg-[#BCDA84] border border-transparent rounded-lg font-medium text-xs tracking-wide hover:bg-[#BCDA84]/80 transition ease-in-out duration-150"
            :disabled="loading">
        <!-- Show loader if loading, otherwise show slot content -->
        <div v-if="loading" class="flex items-center space-x-2">
            <svg class="animate-spin h-4 w-4 text-[#00434b]" xmlns="http://www.w3.org/2000/svg" fill="none"
                 viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C6.477 0 2 4.477 2 10h2z"></path>
            </svg>
            <span>Loading...</span>
        </div>
        <span v-else>
            <slot />
        </span>
    </button>
</template>

<script setup>
import { ref } from 'vue';

defineProps({
    type: {
        type: String,
        default: 'submit',
    },
});

// Create a reactive loading state
const loading = ref(false);

const handleClick = async (event) => {
    // Prevent multiple clicks if already loading
    if (loading.value) return;

    loading.value = true;
    // Emit the event to handle the action in the parent component
    event.target.dispatchEvent(new Event('start-loading', { bubbles: true }));

    // Simulate an action (e.g., API call or form submission) with a timeout
    // Remove or modify this part in production
    await new Promise(resolve => setTimeout(resolve, 2000));

    loading.value = false;
};
</script>
