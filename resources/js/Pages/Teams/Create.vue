<template>
    <AppLayout title="Create Organization">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create Organization
            </h2>
        </template>

        <div>
            <div>
                <CreateTeamForm />
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import CreateTeamForm from '@/Pages/Teams/Partials/CreateTeamForm.vue';
</script>
