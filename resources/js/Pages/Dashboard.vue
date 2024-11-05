<template>
    <AppLayout title="Dashboard">
        <div>
            <div class="border border-red-100 bg-red-50 rounded px-4 py-4 text-red-600 ">
                <div class="flex items-center space-x-1">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-7">
                        <path fill-rule="evenodd"
                            d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z"
                            clip-rule="evenodd" />
                    </svg>
                    <p class="font-bold text-sm">Under Development</p>
                </div>
                <p class="font-medium ml-8">You are welcome to navigate through the pages and explore the available
                    features.</p>
            </div>
        </div>

        <div class="pt-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <!-- User Information Panel -->
            <div class="bg-white border border-gray-200 p-4 rounded">
                <h2 class="text-base font-semibold mb-4">User Information</h2>
                <div class="grid grid-cols1 md:grid-cols-2 items-end">
                    <div>
                        <p class="text-gray-600">{{ user.first_name }} {{ user.last_name }}</p>
                        <p class="text-gray-600">{{ user.email }}</p>
                        <p class="text-gray-600 mt-4">Role: {{ userRoleName }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 md:mt-2">Created At: {{ formattedCreatedAt }}</p>
                        <div class="h-fit mt-4 flex space-x-4">
                            <PrimaryButton @click="logout">
                                Update
                            </PrimaryButton>
                            <form @submit.prevent="logout" class="w-full">
                                <SecondaryButton as="button">
                                    Log Out
                                </SecondaryButton>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Panel -->
            <div class="text-center md:col-span-2 grid grid-cols-2 md:grid-cols-5 gap-4">
                <div v-for="(stat, index) in statCards" :key="index"
                    class="bg-white border border-gray-200 rounded flex flex-col items-center justify-center p-6">
                    <h3 class="text-gray-500 mb-2">{{ stat.title }}</h3>
                    <p class="text-4xl font-semibold">{{ stat.total }}</p>
                    <div class="mt-2">
                        <!-- Icon and Color Logic -->
                        <span class="flex items-center justify-center">
                            <svg v-if="stat.change > 0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"
                                fill="currentColor" :class="stat.upColorClass" class="size-4 mr-1">
                                <!-- Up Arrow Icon -->
                                <path fill-rule="evenodd"
                                    d="M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1Zm-.75 10.25a.75.75 0 0 0 1.5 0V6.56l1.22 1.22a.75.75 0 1 0 1.06-1.06l-2.5-2.5a.75.75 0 0 0-1.06 0l-2.5 2.5a.75.75 0 0 0 1.06 1.06l1.22-1.22v4.69Z"
                                    clip-rule="evenodd" />
                            </svg>

                            <svg v-else-if="stat.change < 0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"
                                fill="currentColor" :class="stat.downColorClass" class="size-4 mr-1">
                                <!-- Down Arrow Icon -->
                                <path fill-rule="evenodd"
                                    d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14Zm.75-10.25a.75.75 0 0 0-1.5 0v4.69L6.03 8.22a.75.75 0 0 0-1.06 1.06l2.5 2.5a.75.75 0 0 0 1.06 0l2.5-2.5a.75.75 0 1 0-1.06-1.06L8.75 9.44V4.75Z"
                                    clip-rule="evenodd" />
                            </svg>

                            <svg v-else xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                                class="size-4 mr-1 text-gray-400">
                                <!-- Neutral Icon (Gray) for 0% change -->
                                <path fill-rule="evenodd"
                                    d="M15 8A7 7 0 1 0 1 8a7 7 0 0 0 14 0ZM4.75 7.25a.75.75 0 0 0 0 1.5h4.69L8.22 9.97a.75.75 0 1 0 1.06 1.06l2.5-2.5a.75.75 0 0 0 0-1.06l-2.5-2.5a.75.75 0 0 0-1.06 1.06l1.22 1.22H4.75Z"
                                    clip-rule="evenodd" />
                            </svg>

                            <!-- Percentage Text Color Logic -->
                            <span :class="stat.change === 0 ? 'text-gray-400' : stat.changeColorClass"
                                class="font-semibold">
                                {{ formattedChange(stat.change) }}
                            </span>
                        </span>
                        <span class="text-gray-500 text-xs ml-1">Since last week</span>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

// Define props
const props = defineProps({
    user: Object,
});

const logout = () => {
    router.post(route('logout'));
};

// Format the `created_at` date to a readable format
const formattedCreatedAt = computed(() => {
    if (!props.user.created_at) return '';

    const date = new Date(props.user.created_at);
    return new Intl.DateTimeFormat('en-GB', {
        dateStyle: 'medium',
        timeStyle: 'short',
    }).format(date);
});

const stats = ref({
    totalCultivars: 0,
    totalCrops: 0,
    totalAgrochemicals: 0,
    totalPrograms: 0, // Add totalPrograms
    openTickets: 0,
    closedTickets: 0,
    changeCultivars: 0,
    changeCrops: 0,
    changeAgrochemicals: 0,
    changePrograms: 0, // Add changePrograms
    changeOpenTickets: 0,
    changeClosedTickets: 0
});

const recentActivities = ref([
    { id: 1, type: 'Program', description: 'Created Agrochemical Program for Crop A' },
    { id: 2, type: 'Support Ticket', description: 'Opened ticket for Crop B issue' },
    { id: 3, type: 'Cultivar', description: 'Added new cultivar "Alpha" to database' },
]);

const fetchData = async () => {
    try {
        // Replace with your actual API endpoints to fetch stats and activities
        const [statsResponse, activityResponse] = await Promise.all([
            axios.get('/dashboard/stats'),
            axios.get('/dashboard/activities')
        ]);

        stats.value = statsResponse.data;
        recentActivities.value = activityResponse.data;
    } catch (error) {
        console.error('Error fetching dashboard data:', error);
    }
};

onMounted(fetchData);

// Navigation functions
const goToAddCultivar = () => {
    // Navigate to add cultivar page
    window.location.href = '/cultivars/create';
};

const goToAddProgram = () => {
    // Navigate to add program page
    window.location.href = '/programs/create';
};

// Role ID to Role Name Mapping
const roleMap = {
    1: 'Super Admin',
    2: 'Admin',
    3: 'Manager',
    4: 'Staff'
};

// Computed role name based on user role_id
const userRoleName = computed(() => roleMap[props.user.role_id] || 'Unknown Role');

// Utility function to format percentage
const formattedChange = (change) => `${Math.abs(change).toFixed(1)}%`;

const statCards = computed(() => [
    {
        title: 'Total Cultivars',
        total: stats.value.totalCultivars,
        change: stats.value.changeCultivars,
        upColorClass: 'text-green-500',
        downColorClass: 'text-red-500',
        changeColorClass: stats.value.changeCultivars > 0 ? 'text-green-500' : 'text-red-500',
    },
    {
        title: 'Total Crops',
        total: stats.value.totalCrops,
        change: stats.value.changeCrops,
        upColorClass: 'text-green-500',
        downColorClass: 'text-red-500',
        changeColorClass: stats.value.changeCrops > 0 ? 'text-green-500' : 'text-red-500',
    },
    {
        title: 'Total Agrochemicals',
        total: stats.value.totalAgrochemicals,
        change: stats.value.changeAgrochemicals,
        upColorClass: 'text-green-500',
        downColorClass: 'text-red-500',
        changeColorClass: stats.value.changeAgrochemicals > 0 ? 'text-green-500' : 'text-red-500',
    },
    {
        title: 'Total Programs',
        total: stats.value.totalPrograms,
        change: stats.value.changePrograms,
        upColorClass: 'text-green-500',
        downColorClass: 'text-red-500',
        changeColorClass: stats.value.changePrograms > 0 ? 'text-green-500' : 'text-red-500',
    },
    {
        title: 'Open Tickets',
        total: stats.value.openTickets,
        change: stats.value.changeOpenTickets,
        // Special rule for tickets: up (increase) is red, down (decrease) is green
        upColorClass: 'text-red-500', // Up arrow should be red
        downColorClass: 'text-green-500', // Down arrow should be green
        changeColorClass: stats.value.changeOpenTickets > 0 ? 'text-red-500' : 'text-green-500',
    },
]);
</script>
