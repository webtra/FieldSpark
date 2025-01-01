<template>
    <AppLayout title="Organization Settings">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Organization Settings
            </h2>
        </template>

        <div>
            <div>
                <UpdateTeamNameForm :team="team" :permissions="permissions" />

                <TeamMemberManager
                    class="mt-10 sm:mt-0"
                    :team="team"
                    :available-roles="availableRoles"
                    :user-permissions="permissions"
                />

<!--                <template v-if="permissions.canDeleteTeam && ! team.personal_team">-->
<!--                    <SectionBorder />-->

<!--                    <DeleteTeamForm class="mt-10 sm:mt-0" :team="team" />-->
<!--                </template>-->
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import DeleteTeamForm from '@/Pages/Teams/Partials/DeleteTeamForm.vue';
import SectionBorder from '@/Components/SectionBorder.vue';
import TeamMemberManager from '@/Pages/Teams/Partials/TeamMemberManager.vue';
import UpdateTeamNameForm from '@/Pages/Teams/Partials/UpdateTeamNameForm.vue';

defineProps({
    team: Object,
    availableRoles: Array,
    permissions: Object,
});
</script>
