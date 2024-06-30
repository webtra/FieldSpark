<template>
    <AppLayout title="Dashboard">
        <div v-if="props.roleId === 1">
            <div class="flex justify-between">
                <h2>Welcome, Admin!</h2>
            </div>
        </div>
        <div v-else>
            <h2>Welcome to your Dashboard!</h2>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({
    isAdmin: Boolean,
    roleId: Number
});
</script>