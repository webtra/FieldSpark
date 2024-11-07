<template>
    <AppLayout title="Agrochemical Program">
        <div class="overflow-x-hidden overflow-y-auto">
            <div class="block md:flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-base font-semibold leading-6 text-gray-900">Agrochemical Program Management</h1>
                    <p class="mt-1 text-gray-500">Total Agrochemical Programs: {{ filteredAgrochemicalPrograms.length }}
                        (Filtered from
                        {{ agrochemicalProgramCount }})</p>
                </div>

                <div class="mt-4 md:mt-0 flex items-center space-x-2 md:space-x-4">
                    <!-- Search Bar -->
                    <TextInput type="text" v-model="searchTerm" placeholder="Search Agrochemical Programs..."
                        class="w-96" />

                    <div class="w-full md:w-fit">
                        <PrimaryButton @click="openCreateModal">
                            Create Program
                        </PrimaryButton>
                    </div>
                </div>
            </div>

            <!-- Modal for Creating an Agrochemical Program -->
            <div v-if="showCreateAgrochemicalModal" class="fixed z-50 inset-0 flex items-center justify-center">
                <!-- Black overlay (backdrop) -->
                <div class="fixed inset-0 bg-black opacity-50"></div>

                <!-- Modal content -->
                <div class="relative bg-white rounded p-6 w-full max-w-2xl z-50">
                    <h3 class="text-lg font-semibold mb-4">Create New Program</h3>

                    <!-- Program Creation Form -->
                    <div class="space-y-4">
                        <div>
                            <!-- Loop through each row in rows array -->
                            <div v-for="(row, index) in rows" :key="index"
                                class="block md:flex items-center space-y-4 md:space-y-0 md:space-x-4 mb-4">
                                <!-- Crop Dropdown -->
                                <div class="w-full">
                                    <InputLabel :for="'crop' + index" value="Crop" />
                                    <select :id="'crop' + index" v-model="row.crop_id"
                                        class="w-full text-xs mt-1 placeholder:text-xs border-gray-300 focus:border-[#BCDA84] focus:ring-[#BCDA84] rounded">
                                        <option v-for="crop in crops" :key="crop.id" :value="crop.id">
                                            {{ crop.block_number }}
                                        </option>
                                    </select>
                                </div>

                                <!-- Agrochemical Dropdown -->
                                <div class="w-full">
                                    <InputLabel :for="'agrochemical' + index" value="Agrochemical" />
                                    <select :id="'agrochemical' + index" v-model="row.agrochemical_id"
                                        class="w-full text-xs mt-1 placeholder:text-xs border-gray-300 focus:border-[#BCDA84] focus:ring-[#BCDA84] rounded">
                                        <option v-for="agrochemical in agrochemicals" :key="agrochemical.id"
                                            :value="agrochemical.id">
                                            {{ agrochemical.mixing_order }} - {{ agrochemical.name }}
                                        </option>
                                    </select>
                                </div>

                                <!-- Planned Application Date -->
                                <div class="w-full">
                                    <InputLabel :for="'plannedApplicationDate' + index"
                                        value="Planned Application Date" />
                                    <input type="date" :id="'plannedApplicationDate' + index"
                                        v-model="row.planned_application_date"
                                        class="mt-1 block w-full text-xs border-gray-300 focus:border-[#BCDA84] focus:ring-[#BCDA84] rounded" />
                                </div>

                                <!-- Remove Row Button, shown only if there are more than one row -->
                                <button v-if="rows.length > 1" @click="removeRow(index)"
                                    class="text-red-500 hover:text-red-700 pt-5">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="square" stroke-linejoin="round"
                                            d="M6 18 18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <!-- Add Row Button -->
                            <div class="flex justify-end pt-4">
                                <button @click="addRow" class="text-xs underline text-gray-600 hover:text-gray-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="square" stroke-linejoin="round"
                                            d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 text-gray-500 flex justify-end space-x-4">
                        <CancelButton @click="showCreateAgrochemicalModal = false">
                            Cancel
                        </CancelButton>

                        <PrimaryButton @click="createAgrochemicalProgram">
                            Create Program
                        </PrimaryButton>
                    </div>
                </div>
            </div>

            <!-- Table of Agrochemical Programs -->
            <div class="mt-4" v-if="groupedProgramsByDateAndOrder.length > 0">
                <div class="border border-gray-300 rounded-md overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="text-black bg-white">
                            <tr>
                                <th class="px-4 py-4 text-left text-xs font-medium uppercase tracking-wider">Planned Application Date</th>
                                <th class="px-4 py-4 text-right text-xs font-medium uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <template v-for="(group, index) in groupedProgramsByDateAndOrder" :key="group.date">
                                <!-- Main grouped date row as an accordion header -->
                                <tr @click="toggleAccordion(index)" class="cursor-pointer text-xs font-bold">
                                    <td colspan="2" class="px-4 py-2">
                                        <div class="flex justify-between items-center space-x-4">
                                            <span>{{ group.date }}</span>
                                            <div class="flex items-center space-x-4">
                                                <!-- Button next to the accordion icon -->
                                                <div class="flex items-center space-x-4">
                                                    <PrimaryButton @click.prevent="handleButtonClick(group.date)"
                                                        class="whitespace-nowrap">
                                                        Generate Application Sheet
                                                    </PrimaryButton>
                                                    <SecondaryButton class="whitespace-nowrap font-normal"
                                                        @click.prevent="openEditModal(group)">
                                                        Edit
                                                    </SecondaryButton>

                                                    <!-- Edit Modal -->
                                                    <div v-if="showEditAgrochemicalModal"
                                                        class="fixed z-50 inset-0 flex items-center justify-center">
                                                        <div class="fixed inset-0 bg-black opacity-20"></div>
                                                        <div
                                                            class="relative bg-white rounded p-6 w-full max-w-2xl z-50">
                                                            <h3 class="text-lg font-semibold mb-4">Edit Program</h3>
                                                            <div class="space-y-4 font-normal">
                                                                <div>
                                                                    <div v-for="(row, index) in rows" :key="index"
                                                                        @click.stop
                                                                        class="block md:flex items-center space-y-4 md:space-y-0 md:space-x-4 mb-4">
                                                                        <div class="w-full">
                                                                            <InputLabel :for="'crop' + index"
                                                                                value="Crop" />
                                                                            <select :id="'crop' + index"
                                                                                v-model="row.crop_id"
                                                                                class="w-full text-xs mt-1 placeholder:text-xs border-gray-300 focus:border-[#BCDA84] focus:ring-[#BCDA84] rounded">
                                                                                <option v-for="crop in crops"
                                                                                    :key="crop.id" :value="crop.id">
                                                                                    {{ crop.block_number }}
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="w-full">
                                                                            <InputLabel :for="'agrochemical' + index"
                                                                                value="Agrochemical" />
                                                                            <select :id="'agrochemical' + index"
                                                                                v-model="row.agrochemical_id"
                                                                                class="w-full text-xs mt-1 placeholder:text-xs border-gray-300 focus:border-[#BCDA84] focus:ring-[#BCDA84] rounded">
                                                                                <option
                                                                                    v-for="agrochemical in agrochemicals"
                                                                                    :key="agrochemical.id"
                                                                                    :value="agrochemical.id">
                                                                                    {{ agrochemical.mixing_order }} - {{
                                                                                        agrochemical.name }}
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="w-full">
                                                                            <InputLabel
                                                                                :for="'plannedApplicationDate' + index"
                                                                                value="Planned Application Date" />
                                                                            <input type="date"
                                                                                :id="'plannedApplicationDate' + index"
                                                                                v-model="row.planned_application_date"
                                                                                class="mt-1 block w-full text-xs border-gray-300 focus:border-[#BCDA84] focus:ring-[#BCDA84] rounded" />
                                                                        </div>
                                                                        <button v-if="rows.length > 1"
                                                                            @click.stop="removeRow(index)"
                                                                            class="text-red-500 hover:text-red-700 pt-5">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                fill="none" viewBox="0 0 24 24"
                                                                                stroke-width="2" stroke="currentColor"
                                                                                class="size-6">
                                                                                <path stroke-linecap="sqaure"
                                                                                    stroke-linejoin="round"
                                                                                    d="M6 18 18 6M6 6l12 12" />
                                                                            </svg>
                                                                        </button>
                                                                    </div>
                                                                    <div class="flex justify-end pt-4">
                                                                        <button @click.stop="addRow"
                                                                            class="text-xs underline text-gray-600 hover:text-gray-800">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                fill="none" viewBox="0 0 24 24"
                                                                                stroke-width="2" stroke="currentColor"
                                                                                class="size-6">
                                                                                <path stroke-linecap="sqaure"
                                                                                    stroke-linejoin="round"
                                                                                    d="M12 4.5v15m7.5-7.5h-15" />
                                                                            </svg>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="mt-6 text-gray-500 flex justify-end space-x-4">
                                                                <CancelButton @click.stop="closeEditModal">
                                                                    Cancel
                                                                </CancelButton>
                                                                <PrimaryButton @click.stop="updateAgrochemicalProgram">
                                                                    Save Changes
                                                                </PrimaryButton>
                                                            </div>
                                                        </div>
                                                    </div>
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
                                <!-- Accordion content with white background -->
                                <tr v-if="openAccordionIndex === index" class="bg-white">
                                    <td colspan="2">
                                        <table class="min-w-full bg-white">
                                            <thead>
                                                <tr class="bg-gray-200">
                                                    <th class="px-4 py-2 text-left text-xs font-medium">Planned
                                                        Application Date</th>
                                                    <th class="px-10 py-2 text-left text-xs font-medium">Mixing Order
                                                    </th>
                                                    <th class="px-10 py-2 text-left text-xs font-medium">Agrochemical
                                                        Name</th>
                                                    <th class="px-10 py-2 text-left text-xs font-medium">Crop/Block Number</th>
                                                    <th class="px-4 py-2 text-right text-xs font-medium">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="program in (group.programs || [])" :key="program.id"
                                                    class="bg-white">
                                                    <td class="px-4 py-2 text-xs text-gray-500">{{
                                                        program.planned_application_date }}</td>
                                                    <td class="px-10 py-2 text-xs text-gray-500">{{
                                                        program.agrochemical?.mixing_order }}</td>
                                                    <td class="px-10 py-2 text-xs text-gray-500">{{
                                                        program.agrochemical?.name }}</td>
                                                    <td class="px-10 py-2 text-xs text-gray-500">{{
                                                        program.crop?.block_number }}
                                                    </td>
                                                    <td class="text-right px-4 py-2 text-xs text-gray-500">
                                                        <button @click="openDrawer([program])" class="underline">View
                                                            Details</button>
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
                <p>No agrochemical programs found</p>
            </div>


            <!-- Drawer to display program details -->
            <div v-if="showDrawer">
                <div class="fixed inset-0 bg-black/50 z-40" @click="showDrawer = false"></div>
                <div class="fixed inset-y-0 right-0 w-[35%] bg-white shadow-lg z-50 flex flex-col h-full">
                    <div class="py-4 px-8 border-b border-gray-200 flex items-center justify-between">
                        <h3 class="text-lg font-medium">Program Details for {{
                            selectedProgramDetails[0]?.planned_application_date }}</h3>
                        <button @click="showDrawer = false" class="text-gray-600 hover:text-gray-800">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6">
                                <path stroke-linecap="square" stroke-linejoin="square" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="py-4 px-8 space-y-4 overflow-y-auto flex-1">
                        <div v-for="program in selectedProgramDetails" :key="program.id" class="mb-4">
                            
                            <p><strong>Mixing Order:</strong> {{ program.agrochemical?.mixing_order }}</p>
                            <p><strong>Crop/Block Number:</strong> {{ program.crop?.block_number }}</p>
                            <p><strong>Agrochemical Name:</strong> {{ program.agrochemical?.name }}</p>
                            <p><strong>Planned Application Date:</strong> {{ program.planned_application_date }}</p>
                            <hr class="my-4 border-gray-300" />
                        </div>
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
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import CancelButton from '@/Components/CancelButton.vue';
import { toast } from 'vue3-toastify';
import InputLabel from '@/Components/InputLabel.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const { agrochemicalPrograms, agrochemicalProgramCount } = defineProps({
    agrochemicalPrograms: Array,
    agrochemicalProgramCount: Number,
});

const searchTerm = ref('');
const displayedItems = ref(10);
const showCreateAgrochemicalModal = ref(false);
const showEditAgrochemicalModal = ref(false);
const showDrawer = ref(false);
const selectedAgrochemicalProgram = ref(null);
const openAccordionIndex = ref(null);

// Function to handle opening the modal and resetting the form
const openCreateModal = () => {
    // Reset the rows array to its initial state with one empty row
    rows.value = [{ crop_id: null, agrochemical_id: null, planned_application_date: null }];
    // Show the modal
    showCreateAgrochemicalModal.value = true;
};

// Toggle the accordion
const toggleAccordion = (index) => {
    openAccordionIndex.value = openAccordionIndex.value === index ? null : index;
};

const formData = ref({
    crop_id: '',
    agrochemical_id: '',
    planned_application_date: '',
});

const editForm = ref({ ...formData.value });

const filteredAgrochemicalPrograms = computed(() => {
    if (!searchTerm.value) return agrochemicalPrograms;
    const term = searchTerm.value.toLowerCase();
    return agrochemicalPrograms.filter(program =>
        program.crop_id.toString().includes(term) ||
        program.agrochemical_id.toString().includes(term) ||
        program.block.toLowerCase().includes(term)
    );
});

const paginatedAgrochemicalPrograms = computed(() => filteredAgrochemicalPrograms.value.slice(0, displayedItems.value));

const loadMore = () => { displayedItems.value += 10; };

const selectedProgramDetails = ref([]);

const openDrawer = (programs) => {
    selectedProgramDetails.value = programs;
    showDrawer.value = true;
};

// Function to close the edit modal
const closeEditModal = () => {
    showEditAgrochemicalModal.value = false;
};

const fetchCrops = async () => {
    try {
        const response = await axios.get('/api/fetch-crops');
        crops.value = response.data;

        // console.log("Fetched Crops:", response.data);
    } catch (error) {
        console.error("Error fetching crops:", error);
    }
};

const fetchAgrichemicals = async () => {
    try {
        const response = await axios.get('/api/fetch-agrochemicals');
        agrochemicals.value = response.data.sort((a, b) => a.mixing_order - b.mixing_order);
        // console.log("Fetched Agrochemicals:", response.data);
    } catch (error) {
        console.error("Error fetching agrochemicals:", error);
    }
};

// Reactive arrays to hold data
const crops = ref([]);
const agrochemicals = ref([]);
const rows = ref([
    { crop_id: null, agrochemical_id: null, planned_application_date: null }
]);
const originalRows = ref([]);

// Function to open the edit modal
const openEditModal = (group) => {
    showEditAgrochemicalModal.value = true;
    rows.value = group.programs.map(program => ({
        id: program.id, // Ensure the ID is included for proper comparison
        crop_id: program.crop_id,
        agrochemical_id: program.agrochemical_id,
        planned_application_date: program.planned_application_date
    }));

    // Save the original rows for comparison
    originalRows.value = JSON.parse(JSON.stringify(rows.value)); // Deep copy to avoid reference issues
};


const updateAgrochemicalProgram = async () => {
    try {
        // Identify deleted rows: rows that exist in originalRows but not in current rows
        const deletedRows = originalRows.value.filter(
            originalRow => !rows.value.some(row => row.id === originalRow.id)
        );

        // Identify new rows: rows that do not have an ID
        const newRows = rows.value.filter(row => !row.id);

        // Identify updated rows: rows that exist in both arrays but have differences in data
        const updatedRows = rows.value.filter(row => {
            const originalRow = originalRows.value.find(orig => orig.id === row.id);
            return (
                originalRow &&
                (originalRow.crop_id !== row.crop_id ||
                    originalRow.agrochemical_id !== row.agrochemical_id ||
                    originalRow.planned_application_date !== row.planned_application_date)
            );
        });

        // Log the changes to the console
        console.log('Deleted Rows:', deletedRows);
        console.log('New Rows:', newRows);
        console.log('Updated Rows:', updatedRows);

        // Handle deleted rows: send a DELETE request for each deleted row
        if (deletedRows.length > 0) {
            for (const row of deletedRows) {
                console.log('Deleting row with ID:', row.id); // Log deleted row ID
                await axios.delete(`/agrochemical-program/${row.id}`);
            }
        }

        // Handle new rows: send a POST request with the new rows
        if (newRows.length > 0) {
            console.log('Adding new rows:', newRows);
            await axios.post('/agrochemical-program/store', { rows: newRows });
        }

        // Handle updated rows: send a PUT request with the updated rows
        if (updatedRows.length > 0) {
            console.log('Updating rows:', updatedRows);
            for (const row of updatedRows) {
                await axios.put(`/agrochemical-program/${row.id}`, row);
            }
        }

        showEditAgrochemicalModal.value = false;
        toast("Agrochemical program updated successfully!", {
            theme: "colored",
            type: "success",
            position: "top-center",
            hideProgressBar: true,
        });

        // Refresh the data to reflect changes
        window.location.reload();
    } catch (error) {
        toast("Error updating agrochemical program!", {
            theme: "colored",
            type: "error",
            position: "top-center",
        });
        console.error("Error updating program:", error);
    }
};

// Add a new row with empty fields
const addRow = () => {
    rows.value.push({ crop_id: null, agrochemical_id: null, planned_application_date: null });
};

// Remove a row by index
const removeRow = (index) => {
    if (rows.value.length > 1) {
        rows.value.splice(index, 1); // This should modify `rows` directly
    }
};


const createAgrochemicalProgram = async () => {
    try {
        await axios.post('/agrochemical-program/store', { rows: rows.value });
        showCreateAgrochemicalModal.value = false;
        toast("Agrochemical program created successfully!", { theme: "colored", type: "success", position: "top-center", hideProgressBar: true });
        window.location.reload();
    } catch (error) {
        toast("Error creating agrochemical program!", { theme: "colored", type: "error", position: "top-center" });
        console.error("Error:", error);
    }
};

const groupedProgramsByDateAndOrder = computed(() => {
    console.log('Computing grouped programs...'); // Check if this runs
    if (!agrochemicalPrograms || agrochemicalPrograms.length === 0) {
        return []; // Return an empty array if no programs are found
    }

    const groupedByDate = agrochemicalPrograms.reduce((acc, program) => {
        const date = program.planned_application_date;
        if (!acc[date]) {
            acc[date] = { date, programs: [] }; // Ensure each group has a date and programs array
        }
        acc[date].programs.push(program);
        return acc;
    }, {});

    console.log('Grouped data:', groupedByDate); // Log the structure of grouped data

    return Object.values(groupedByDate)
        .sort((a, b) => new Date(a.date) - new Date(b.date))
        .map(group => ({
            ...group,
            programs: group.programs.sort((a, b) => (a.mixing_order || 0) - (b.mixing_order || 0)), // Ensure mixing_order has a fallback
        }));
});


onMounted(() => {
    fetchCrops();
    fetchAgrichemicals();
    console.log('Component mounted');
    console.log('Grouped Programs by Date and Order:', groupedProgramsByDateAndOrder.value);
});
</script>
