<template>
    <AppLayout title="Agrochemical Program Application Management">
        <div class="overflow-x-hidden overflow-y-auto">
            <div class="block md:flex items-center justify-between mb-4">
                <p class="text-sm mt-1 text-black font-medium">
                    <span class="font-bold">Total Agrochemical Program Applications:</span>
                    {{ filteredApplications.length }} (Filtered from {{ agrochemicalProgramApplications.length }})
                </p>

                <!-- Search Bar -->
                <TextInput type="text" v-model="searchTerm" placeholder="Search" class="w-96" />
            </div>

            <!-- Table of Applications -->
            <div class="mt-4" v-if="groupedApplicationsByDate && groupedApplicationsByDate.length > 0">
                <div class="rounded-lg overflow-x-auto">
                    <table class="min-w-full text-sm text-black">
                        <thead class="bg-white border-b-2 border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium w-28 whitespace-nowrap">Planned
                                    Application Date</th>
                                <th class="px-6 py-4 text-right text-xs font-medium w-28 whitespace-nowrap">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <template v-for="(group, index) in filteredApplications" :key="group.date">
                                <tr @click="toggleAccordion(index)" class="cursor-pointer text-xs font-bold">
                                    <td colspan="2" class="px-6 py-2">
                                        <div class="flex justify-between items-center space-x-4">
                                            <span class="font-medium text-gray-600">{{ group.date }}</span>
                                            <div class="flex items-center space-x-4">
                                                <div class="flex items-center space-x-4 font-normal">
                                                    <SecondaryButton @click.stop="redirectToFillInPage(group.date, group.applications)">
                                                        Fill In
                                                    </SecondaryButton>
                                                </div>
                                                <!-- Accordion icon -->
                                                <svg v-if="openAccordionIndex === index"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor" class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M5 15l7-7 7 7"></path>
                                                </svg>
                                                <svg v-else xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr v-if="openAccordionIndex === index" class="bg-white">
                                    <td colspan="2">
                                        <table class="min-w-full bg-white">
                                            <thead>
                                                <tr class="bg-gray-200">
                                                    <th class="px-6 py-2 text-left text-xs font-medium">Planned
                                                        Application Date</th>
                                                    <th class="px-10 py-2 text-left text-xs font-medium">Application
                                                        Date</th>
                                                    <th class="px-10 py-2 text-left text-xs font-medium">Time</th>
                                                    <th class="px-10 py-2 text-left text-xs font-medium">Tractor Start
                                                        Hours</th>
                                                    <th class="px-10 py-2 text-left text-xs font-medium">Tractor End
                                                        Hours</th>
                                                    <th class="px-10 py-2 text-left text-xs font-medium">Tank Number
                                                    </th>
                                                    <th class="px-10 py-2 text-left text-xs font-medium">Liters Applied
                                                    </th>
                                                    <th class="px-10 py-2 text-left text-xs font-medium">Notes</th>
                                                    <th class="px-6 py-2 text-right text-xs font-medium">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="application in (group.applications || [])"
                                                    :key="application.id" class="bg-white">
                                                    <td class="px-6 py-2 text-xs text-gray-600">
                                                        {{ application.agrochemical_program?.planned_application_date ||
                                                            'N/A' }}
                                                    </td>
                                                    <td class="px-10 py-2 text-xs text-gray-600">{{
                                                        application.application_date || 'N/A' }}</td>
                                                    <td class="px-10 py-2 text-xs text-gray-600">{{ application.time ||
                                                        'N/A' }}</td>
                                                    <td class="px-10 py-2 text-xs text-gray-600">{{
                                                        application.tractor_start_hours || 'N/A' }}</td>
                                                    <td class="px-10 py-2 text-xs text-gray-600">{{
                                                        application.tractor_end_hours || 'N/A' }}</td>
                                                    <td class="px-10 py-2 text-xs text-gray-600">{{
                                                        application.tank_number || 'N/A' }}</td>
                                                    <td class="px-10 py-2 text-xs text-gray-600">{{
                                                        application.liters_applied || 'N/A' }}</td>
                                                    <td class="px-10 py-2 text-xs text-gray-600">{{ application.notes ||
                                                        'N/A' }}</td>
                                                    <td class="text-right px-6 py-2 text-xs text-gray-600">
                                                        <button @click="openDrawer([application])"
                                                            class="underline">View Details</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
            <div v-else>
                <p>No applications found</p>
            </div>

            <!-- Drawer to display application details -->
            <div v-if="showDrawer">
                <!-- Black overlay (backdrop) -->
                <div class="fixed inset-0 bg-black/50 z-40" @click="showDrawer = false"></div>

                <!-- Drawer Content -->
                <div class="fixed inset-y-0 right-0 w-[35%] bg-white shadow-lg z-50 flex flex-col h-full">
                    <!-- Header with Close Button -->
                    <div class="py-4 px-8 border-b border-gray-200 flex items-center justify-between">
                        <h3 class="text-lg font-medium">Application Details</h3>
                        <button @click="showDrawer = false" class="text-gray-600 hover:text-gray-800">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6">
                                <path stroke-linecap="square" stroke-linejoin="square" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Drawer Body - Scrollable Content -->
                    <div class="py-4 px-8 space-y-4 overflow-y-auto flex-1" v-if="selectedApplicationDetails.length">
                        <!-- Planned Application Date -->
                        <div class="mb-4">
                            <InputLabel value="Planned Application Date" />
                            <TextInput id="planned_application_date" type="text"
                                :value="selectedApplicationDetails[0]?.agrochemical_program?.planned_application_date || 'N/A'"
                                class="mt-1 block w-full" placeholder="Planned Application Date" disabled />
                        </div>

                        <!-- Application Date -->
                        <div class="mb-4">
                            <InputLabel value="Application Date" />
                            <TextInput id="application_date" type="text"
                                :value="selectedApplicationDetails[0]?.application_date || 'N/A'"
                                class="mt-1 block w-full" placeholder="Application Date" disabled />
                        </div>

                        <!-- Time -->
                        <div class="mb-4">
                            <InputLabel value="Time" />
                            <TextInput id="time" type="text" :value="selectedApplicationDetails[0]?.time || 'N/A'"
                                class="mt-1 block w-full" placeholder="Time" disabled />
                        </div>

                        <div class="flex space-x-4">
                            <!-- Tractor Start Hours -->
                            <div class="w-full">
                                <InputLabel value="Tractor Start Hours" />
                                <TextInput id="tractor_start_hours" type="text"
                                    :value="selectedApplicationDetails[0]?.tractor_start_hours || 'N/A'"
                                    class="mt-1 block w-full" placeholder="Tractor Start Hours" disabled />
                            </div>

                            <!-- Tractor End Hours -->
                            <div class="w-full">
                                <InputLabel value="Tractor End Hours" />
                                <TextInput id="tractor_end_hours" type="text"
                                    :value="selectedApplicationDetails[0]?.tractor_end_hours || 'N/A'"
                                    class="mt-1 block w-full" placeholder="Tractor End Hours" disabled />
                            </div>
                        </div>

                        <!-- Tank Number -->
                        <div class="mb-4">
                            <InputLabel value="Tank Number" />
                            <TextInput id="tank_number" type="text"
                                :value="selectedApplicationDetails[0]?.tank_number || 'N/A'" class="mt-1 block w-full"
                                placeholder="Tank Number" disabled />
                        </div>

                        <!-- Liters Applied -->
                        <div class="mb-4">
                            <InputLabel value="Liters Applied" />
                            <TextInput id="liters_applied" type="text"
                                :value="selectedApplicationDetails[0]?.liters_applied || 'N/A'"
                                class="mt-1 block w-full" placeholder="Liters Applied" disabled />
                        </div>

                        <!-- Notes -->
                        <div class="mb-4">
                            <InputLabel value="Notes" />
                            <TextArea rows="5" id="notes" type="text"
                                :value="selectedApplicationDetails[0]?.notes || 'N/A'" class="mt-1 block w-full"
                                placeholder="Notes" disabled />
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </AppLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextArea from '@/Components/TextArea.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import CancelButton from '@/Components/CancelButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const { agrochemicalProgramApplications, agrochemicalProgramApplicationCount } = defineProps({
    agrochemicalProgramApplications: Array,
    agrochemicalProgramApplicationCount: Number,
});

console.log('Initial agrochemicalProgramApplications:', agrochemicalProgramApplications);

const searchTerm = ref('');
const showEditAgrochemicalModal = ref(false);
const openAccordionIndex = ref(null);
const rows = ref([]);
const showDrawer = ref(false);
const selectedApplicationDetails = ref([]);

const groupedApplicationsByDate = computed(() => {
    if (!agrochemicalProgramApplications || !Array.isArray(agrochemicalProgramApplications)) {
        return [];
    }

    const groupedByDate = agrochemicalProgramApplications.reduce((acc, app) => {
        const date = app.agrochemical_program?.planned_application_date || 'Not Set';
        if (!acc[date]) {
            acc[date] = { date, applications: [] }; // Ensure applications is initialized as an array
        }
        acc[date].applications.push(app);
        return acc;
    }, {});

    console.log('Grouped by Date:', groupedByDate);

    return Object.values(groupedByDate).map(group => ({
        ...group,
        applications: Array.isArray(group.applications) ? group.applications : [],
    })).sort((a, b) => new Date(a.date) - new Date(b.date));
});


const filteredApplications = computed(() => {
    if (!searchTerm.value) {
        console.log('Grouped Applications:', groupedApplicationsByDate.value);
        return groupedApplicationsByDate.value;
    }

    const term = searchTerm.value.trim().toLowerCase();
    return groupedApplicationsByDate.value.filter(group =>
        group.date.toLowerCase().includes(term) ||
        group.applications.some(app => app.program_id.toString().includes(term))
    );
});

const toggleAccordion = (index) => {
    openAccordionIndex.value = openAccordionIndex.value === index ? null : index;
};

const openDrawer = (applications) => {
    selectedApplicationDetails.value = applications;
    showDrawer.value = true;
};

onMounted(() => {
    console.log('Component mounted successfully');
});
</script>