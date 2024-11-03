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
                        <PrimaryButton @click="showCreateAgrochemicalModal = true">
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
                            <div v-for="(row, index) in rows" :key="index" class="flex items-center space-x-4 mb-4">
                                <!-- Crop Dropdown -->
                                <div class="w-full">
                                    <InputLabel :for="'crop' + index" value="Crop" />
                                    <select :id="'crop' + index" v-model="row.crop_id"
                                        class="w-full text-xs mt-1 placeholder:text-xs border-gray-300 focus:border-[#BCDA84] focus:ring-[#BCDA84] rounded">
                                        <option value="" disabled>Select a crop</option>
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
                                        <option value="" disabled>Select an agrochemical</option>
                                        <option v-for="agrochemical in agrochemicals" :key="agrochemical.id"
                                            :value="agrochemical.id">
                                            {{ agrochemical.name }}
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
                                    class="text-red-500 hover:text-red-700 mt-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="sqaure" stroke-linejoin="round"
                                            d="M6 18 18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <!-- Add Row Button -->
                            <div class="flex justify-end pt-4">
                                <button @click="addRow" class="text-xs underline text-gray-600 hover:text-gray-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="sqaure" stroke-linejoin="round"
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

                        <PrimaryButton @click="generatApplicationSheet">
                            Generate Sheet
                        </PrimaryButton>
                    </div>
                </div>
            </div>

            <!-- Table of Agrochemical Programs -->
            <div class="mt-4" v-if="paginatedAgrochemicalPrograms && paginatedAgrochemicalPrograms.length > 0">
                <div class="border border-gray-300 rounded-md overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="text-black bg-white">
                            <tr>
                                <th class="px-4 py-4 text-left text-xs font-medium uppercase tracking-wider">ID</th>
                                <th class="px-4 py-4 text-left text-xs font-medium uppercase tracking-wider">Crop ID
                                </th>
                                <th class="px-4 py-4 text-left text-xs font-medium uppercase tracking-wider">
                                    Agrochemical ID</th>
                                <th class="px-4 py-4 text-left text-xs font-medium uppercase tracking-wider">Planned
                                    Date</th>
                                <th class="px-4 py-4 text-left text-xs font-medium uppercase tracking-wider">Application
                                    Date</th>
                                <th class="px-4 py-4 text-left text-xs font-medium uppercase tracking-wider">Block</th>
                                <th class="px-4 py-4 text-left text-xs font-medium uppercase tracking-wider">Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="program in paginatedAgrochemicalPrograms" :key="program.id"
                                class="cursor-pointer odd:bg-white even:bg-gray-50">
                                <td class="px-4 py-2 text-xs text-gray-500" @click="openDrawer(program)">{{ program.id
                                    }}</td>
                                <td class="px-4 py-2 text-xs text-gray-500" @click="openDrawer(program)">{{
                                    program.crop_id }}</td>
                                <td class="px-4 py-2 text-xs text-gray-500" @click="openDrawer(program)">{{
                                    program.agrochemical_id }}</td>
                                <td class="px-4 py-2 text-xs text-gray-500" @click="openDrawer(program)">{{
                                    program.planned_application_date }}</td>
                                <td class="px-4 py-2 text-xs text-gray-500" @click="openDrawer(program)">{{
                                    program.application_date }}</td>
                                <td class="px-4 py-2 text-xs text-gray-500" @click="openDrawer(program)">{{
                                    program.block }}</td>
                                <td class="px-4 py-2 text-xs text-gray-500 space-x-4 flex items-center">
                                    <button @click="openEditModal(program)" class="underline">Edit</button>
                                    <button @click="openDeleteModal(program)" class="underline">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div v-else>
                <p>No agrochemical programs found</p>
            </div>

            <!-- Drawer to display program details -->
            <div v-if="showDrawer">
                <!-- Black overlay (backdrop) -->
                <div class="fixed inset-0 bg-black/50 z-40" @click="showDrawer = false"></div>

                <!-- Drawer Content -->
                <div class="fixed inset-y-0 right-0 w-[35%] bg-white shadow-lg z-50 flex flex-col h-full">
                    <!-- Header with Close Button -->
                    <div class="py-4 px-8 border-b border-gray-200 flex items-center justify-between">
                        <h3 class="text-lg font-medium">Agrochemical Program Details</h3>
                        <button @click="showDrawer = false" class="text-gray-600 hover:text-gray-800">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6">
                                <path stroke-linecap="square" stroke-linejoin="square" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Drawer Body - Scrollable Content -->
                    <div class="py-4 px-8 space-y-4 overflow-y-auto flex-1">
                        <p><strong>Crop ID:</strong> {{ selectedAgrochemicalProgram.crop_id }}</p>
                        <p><strong>Agrochemical ID:</strong> {{ selectedAgrochemicalProgram.agrochemical_id }}</p>
                        <p><strong>Planned Application Date:</strong> {{
                            selectedAgrochemicalProgram.planned_application_date }}</p>
                        <p><strong>Recommendations:</strong> {{ selectedAgrochemicalProgram.recommendations }}</p>

                        <h4 class="mt-4 font-semibold">Actual Application Details</h4>
                        <p><strong>Application Date:</strong> {{ selectedAgrochemicalProgram.application_date }}</p>
                        <p><strong>Block:</strong> {{ selectedAgrochemicalProgram.block }}</p>
                        <p><strong>Application Time:</strong> {{ selectedAgrochemicalProgram.application_time }}</p>
                        <p><strong>Tractor Hours Start:</strong> {{ selectedAgrochemicalProgram.tractor_hours_start }}
                        </p>
                        <p><strong>Tractor Hours End:</strong> {{ selectedAgrochemicalProgram.tractor_hours_end }}</p>
                        <p><strong>Tank Number:</strong> {{ selectedAgrochemicalProgram.tank_number }}</p>
                        <p><strong>Liters Sprayed:</strong> {{ selectedAgrochemicalProgram.liters_sprayed }}</p>
                        <p><strong>Operator Name:</strong> {{ selectedAgrochemicalProgram.operator_name }}</p>
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
const showDrawer = ref(false);
const selectedAgrochemicalProgram = ref(null);
const showEditModal = ref(false);
const showDeleteModal = ref(false);

const formData = ref({
    crop_id: '',
    agrochemical_id: '',
    planned_application_date: '',
    recommendations: '',
    application_date: '',
    block: '',
    application_time: '',
    tractor_hours_start: '',
    tractor_hours_end: '',
    tank_number: '',
    liters_sprayed: '',
    operator_name: '',
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

const createAgrochemicalProgram = async () => {
    try {
        await axios.post('/agrochemical-programs', formData.value);
        showCreateAgrochemicalModal.value = false;
        toast("Agrochemical program created successfully!", { theme: "colored", type: "success", position: "top-center", hideProgressBar: true });
        window.location.reload();
    } catch (error) {
        toast("Error creating agrochemical program!", { theme: "colored", type: "error", position: "top-center" });
        console.error("Error:", error);
    }
};

// Open the drawer to display program details
const openDrawer = (program) => {
    selectedAgrochemicalProgram.value = program;
    showDrawer.value = true;
};

// Open the edit modal and populate it with the selected program's data
const openEditModal = (program) => {
    selectedAgrochemicalProgram.value = program;
    editForm.value = { ...program }; // Populate editForm with program details
    showEditModal.value = true;
};

// Function to handle editing the agrochemical program
const editAgrochemicalProgram = async () => {
    try {
        await axios.put(`/agrochemical-programs/${selectedAgrochemicalProgram.value.id}`, editForm.value);
        showEditModal.value = false;

        toast("Agrochemical program updated successfully!", { theme: "colored", type: "success", position: "top-center", hideProgressBar: true });

        // Optionally, you can refresh the data without a full reload:
        selectedAgrochemicalProgram.value = { ...editForm.value };
        window.location.reload();
    } catch (error) {
        toast("Error updating agrochemical program!", { theme: "colored", type: "error", position: "top-center" });
        console.error("Error updating program:", error);
    }
};

// Open delete modal and set selected program
const openDeleteModal = (program) => {
    selectedAgrochemicalProgram.value = program;
    showDeleteModal.value = true;
};

// Function to delete the selected agrochemical program
const deleteAgrochemicalProgram = async () => {
    try {
        await axios.delete(`/agrochemical-programs/${selectedAgrochemicalProgram.value.id}`);
        showDeleteModal.value = false;

        toast("Agrochemical program deleted successfully!", { theme: "colored", type: "success", position: "top-center", hideProgressBar: true });
        window.location.reload();
    } catch (error) {
        toast("Error deleting agrochemical program!", { theme: "colored", type: "error", position: "top-center" });
        console.error("Error deleting program:", error);
    }
};

// Reactive arrays to hold data
const crops = ref([]);
const agrochemicals = ref([]);
const rows = ref([
    { crop_id: null, agrochemical_id: null, planned_application_date: null }
]);

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
        agrochemicals.value = response.data;

        // console.log("Fetched Agrochemicals:", response.data);
    } catch (error) {
        console.error("Error fetching agrochemicals:", error);
    }
};

onMounted(() => {
    fetchCrops();
    fetchAgrichemicals();
});

// Add a new row with empty fields
const addRow = () => {
    rows.value.push({ crop_id: null, agrochemical_id: null, planned_application_date: null });
};

// Remove a row by index
const removeRow = (index) => {
    if (rows.value.length > 1) {
        rows.value.splice(index, 1);
    }
};
</script>