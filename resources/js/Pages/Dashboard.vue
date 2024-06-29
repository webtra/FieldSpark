<template>
    <AppLayout title="Dashboard">
        <div v-if="props.roleId === 1">
            <div class="flex justify-between">
                <h2>Welcome, Admin!</h2>
                <!-- 
                <Link href="/service/create"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Add Service
                </Link>
                -->
            </div>
        </div>

        <div v-else>
            <h2>Welcome to your Dashboard!</h2>
            <!-- General user content here -->
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    isAdmin: Boolean,
    roleId: Number
});

// console.log('isAdmin:', props.isAdmin);
// console.log('Role ID:', props.roleId);
</script>