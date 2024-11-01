<template>
    <AppLayout title="Cultivar">
        <div class="overflow-x-hidden overflow-y-auto">
            <div class="block md:flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-base font-semibold leading-6 text-gray-900">Cultivar Management</h1>
                    <p class="mt-1 text-gray-500">Total Cultivars: {{ filteredCultivars.length }} (Filtered from {{
                        cultivarCount }})</p>
                </div>

                <div class="mt-4 md:mt-0 flex items-center space-x-2 md:space-x-4">
                    <!-- Search Bar -->
                    <TextInput type="text" v-model="search" placeholder="Search Cultivar..." class="w-full md:w-96" />

                    <div class="w-full md:w-fit">
                        <PrimaryButton @click="showCreateCultivarModal = true">
                            Create Cultivar
                        </PrimaryButton>
                    </div>
                </div>
            </div>

            <!-- Modal for Creating a Cultivar -->
            <div v-if="showCreateCultivarModal" class="fixed z-50 inset-0 flex items-center justify-center">
                <!-- Black overlay (backdrop) -->
                <div class="fixed inset-0 bg-black opacity-50"></div>

                <!-- Modal content -->
                <div class="relative bg-white rounded p-6 w-full max-w-sm z-50">
                    <h3 class="text-lg font-semibold mb-4">Create New Cultivar</h3>

                    <div class="mb-4">
                        <InputLabel value="Cultivar Name" />
                        <TextInput id="name" type="text" v-model="formData.name" class="mt-1 block w-full"
                            placeholder="Cultivar Name" required />
                    </div>

                    <!-- Growth Season -->
                    <div class="mb-4">
                        <InputLabel value="Growth Season" />
                        <select v-model="formData.growth_season"
                            class="w-full text-xs mt-1 placeholder:text-xs border-gray-300 focus:border-[#BCDA84] focus:ring-[#BCDA84] rounded"
                            required>
                            <option value="spring">Spring</option>
                            <option value="summer">Summer</option>
                            <option value="autumn">Autumn</option>
                            <option value="winter">Winter</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <InputLabel value="Yield Potential" />
                        <p class="text-gray-400 text-[11px]">Kilograms per Hectare</p>
                        <TextInput type="number" v-model="formData.yield_potential" placeholder="Yield Potential"
                            class="mt-1 block w-full" />
                    </div>

                    <div class="mb-4">
                        <InputLabel value="Water Requirements" />
                        <p class="text-gray-400 text-[11px]">Litre per Week</p>
                        <TextInput type="text" v-model="formData.water_requirements" placeholder="Water Requirements"
                            class="mt-1 block w-full" />
                    </div>

                    <div class="mb-4">
                        <InputLabel value="Soil Type" />
                        <TextInput type="text" v-model="formData.soil_type" placeholder="Soil Type"
                            class="mt-1 block w-full" />
                    </div>

                    <div class="flex space-x-4">
                        <div class="mb-4">
                            <InputLabel value="Plant Spacing" />
                            <TextInput type="text" v-model="formData.plant_spacing" placeholder="Plant Spacing"
                                class="mt-1 block w-full" />
                        </div>

                        <div class="mb-4">
                            <InputLabel value="Root Depth" />
                            <TextInput type="text" v-model="formData.root_depth" placeholder="Root Depth"
                                class="mt-1 block w-full" />
                        </div>
                    </div>

                    <div class="mt-6 text-gray-500 flex justify-end space-x-4">
                        <CancelButton @click="showCreateCultivarModal = false">
                            Cancel
                        </CancelButton>
                        <PrimaryButton @click="createCultivar">
                            Create
                        </PrimaryButton>
                    </div>
                </div>
            </div>

            <!-- Table of Cultivars -->
            <div class="mt-4" v-if="paginatedCultivars && paginatedCultivars.length > 0">
                <div class="border border-gray-300 rounded-md overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="text-black bg-white">
                            <tr>
                                <th
                                    class="px-4 py-4 text-left text-xs font-medium uppercase tracking-wider w-32 whitespace-nowrap">
                                    ID</th>
                                <th
                                    class="px-4 py-4 text-left text-xs font-medium uppercase tracking-wider w-48 whitespace-nowrap">
                                    Variety Name</th>
                                <th
                                    class="px-4 py-4 text-left text-xs font-medium uppercase tracking-wider w-32 whitespace-nowrap">
                                    Season</th>
                                <th
                                    class="px-4 py-4 text-left text-xs font-medium uppercase tracking-wider w-48 whitespace-nowrap">
                                    Yield Potential</th>
                                <th
                                    class="px-4 py-4 text-left text-xs font-medium uppercase tracking-wider w-64 whitespace-nowrap">
                                    Water Requirements</th>
                                <th
                                    class="px-4 py-4 text-left text-xs font-medium uppercase tracking-wider w-48 whitespace-nowrap">
                                    Soil Type</th>
                                <th
                                    class="px-4 py-4 text-left text-xs font-medium uppercase tracking-wider w-48 whitespace-nowrap">
                                    Plant Spacing</th>
                                <th
                                    class="px-4 py-4 text-left text-xs font-medium uppercase tracking-wider w-48 whitespace-nowrap">
                                    Root Depth</th>
                                <th
                                    class="px-4 py-4 text-left text-xs font-medium uppercase tracking-wider w-48 whitespace-nowrap">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="cultivar in paginatedCultivars" :key="cultivar.id"
                                class="odd:bg-white even:bg-gray-50">
                                <td class="px-4 py-2 text-xs text-gray-500 w-32">{{ cultivar.id }}</td>
                                <td class="px-4 py-2 text-xs text-gray-500 w-48">{{ cultivar.name }}</td>
                                <td class="px-4 py-2 text-xs text-gray-500 w-32 capitalize">{{ cultivar.growth_season }}
                                </td>
                                <td class="px-4 py-2 text-xs text-gray-500 w-48">{{ cultivar.yield_potential || 'N/A' }}
                                </td>
                                <td class="px-4 py-2 text-xs text-gray-500 w-48">{{ cultivar.water_requirements || 'N/A'
                                    }}</td>
                                <td class="px-4 py-2 text-xs text-gray-500 w-48">{{ cultivar.soil_type || 'N/A' }}</td>
                                <td class="px-4 py-2 text-xs text-gray-500 w-48">{{ cultivar.plant_spacing || 'N/A' }}
                                </td>
                                <td class="px-4 py-2 text-xs text-gray-500 w-48">{{ cultivar.root_depth || 'N/A' }}</td>
                                <td class="px-4 py-2 text-xs text-gray-500 w-48 space-x-4 flex items-center">
                                    <!-- Delete button and modal -->
                                    <div>
                                        <button class="underline" @click="openDeleteModal(cultivar)">Delete</button>

                                        <div v-if="showDeleteModal"
                                            class="fixed z-50 inset-0 flex items-center justify-center">
                                            <!-- Black overlay (backdrop) -->
                                            <div class="fixed inset-0 bg-black/50"></div>

                                            <!-- Modal content -->
                                            <div class="relative bg-white rounded p-6 w-full max-w-sm z-50">
                                                <h3 class="text-black text-lg font-semibold mb-4">Confirm Delete</h3>
                                                <p>Are you sure you want to delete this crop?</p>

                                                <div class="mt-6 flex justify-end space-x-4">
                                                    <CancelButton @click="showDeleteModal = false">Cancel</CancelButton>
                                                    <DangerButton @click="deleteCultivar">Delete</DangerButton>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Edit button and modal -->
                                    <div>
                                        <button class="underline" @click="openEditModal(cultivar)">Edit</button>

                                        <div v-if="showEditModal"
                                            class="fixed z-50 inset-0 flex items-center justify-center">
                                            <!-- Black overlay (backdrop) -->
                                            <div class="fixed inset-0 bg-black/50"></div>

                                            <!-- Modal content -->
                                            <div class="relative bg-white rounded p-6 w-full max-w-sm z-50">
                                                <h3 class="text-lg font-semibold mb-4">Edit Cultivar</h3>

                                                <div class="mb-4">
                                                    <InputLabel value="Cultivar Name" />
                                                    <TextInput id="name" type="text" v-model="editForm.name"
                                                        class="mt-1 block w-full" placeholder="Cultivar Name"
                                                        required />
                                                </div>

                                                <!-- Growth Season -->
                                                <div class="mb-4">
                                                    <InputLabel value="Growth Season" />
                                                    <select v-model="editForm.growth_season"
                                                        class="w-full text-xs mt-1 placeholder:text-xs border-gray-300 focus:border-[#BCDA84] focus:ring-[#BCDA84] rounded"
                                                        required>
                                                        <option value="spring">Spring</option>
                                                        <option value="summer">Summer</option>
                                                        <option value="autumn">Autumn</option>
                                                        <option value="winter">Winter</option>
                                                    </select>
                                                </div>

                                                <div class="mb-4">
                                                    <InputLabel value="Yield Potential" />
                                                    <p class="text-gray-400 text-[11px]">Kilograms per Hectare</p>
                                                    <TextInput type="number" v-model="editForm.yield_potential"
                                                        placeholder="Yield Potential" class="mt-1 block w-full" />
                                                </div>

                                                <div class="mb-4">
                                                    <InputLabel value="Water Requirements" />
                                                    <p class="text-gray-400 text-[11px]">Litre per Week</p>
                                                    <TextInput type="text" v-model="editForm.water_requirements"
                                                        placeholder="Water Requirements" class="mt-1 block w-full" />
                                                </div>

                                                <div class="mb-4">
                                                    <InputLabel value="Soil Type" />
                                                    <TextInput type="text" v-model="editForm.soil_type"
                                                        placeholder="Soil Type" class="mt-1 block w-full" />
                                                </div>

                                                <div class="flex space-x-4">
                                                    <div class="mb-4">
                                                        <InputLabel value="Plant Spacing" />
                                                        <TextInput type="text" v-model="editForm.plant_spacing"
                                                            placeholder="Plant Spacing" class="mt-1 block w-full" />
                                                    </div>

                                                    <div class="mb-4">
                                                        <InputLabel value="Root Depth" />
                                                        <TextInput type="text" v-model="editForm.root_depth"
                                                            placeholder="Root Depth" class="mt-1 block w-full" />
                                                    </div>
                                                </div>

                                                <div class="mt-6 text-gray-500 flex justify-end space-x-4">
                                                    <CancelButton @click="showEditModal = false">
                                                        Cancel
                                                    </CancelButton>
                                                    <PrimaryButton @click="updateCultivar">
                                                        Create
                                                    </PrimaryButton>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Load More Button -->
                <div class="flex justify-center mt-4">
                    <PrimaryButton v-if="displayedItems < filteredCultivars.length" @click="loadMore">
                        Load More
                    </PrimaryButton>
                </div>
            </div>

            <!-- If no cultivars found -->
            <div v-else>
                <p>No cultivars found</p>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { toast } from 'vue3-toastify'
import { ref, computed, watch } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputLabel from "@/Components/InputLabel.vue";
import CancelButton from "@/Components/CancelButton.vue";
import DangerButton from '@/Components/DangerButton.vue';

const { cultivars, cultivarCount } = defineProps({
    cultivars: Array,
    cultivarCount: Number,
});

const showCreateCultivarModal = ref(false);

// Reactive properties
const search = ref('');
const displayedItems = ref(10); // Initial number of items to show

// Computed property for filtered cultivars based on search term
const filteredCultivars = computed(() => {
    if (!search.value) return cultivars;

    return cultivars.filter((cultivar) => {
        return (
            cultivar.variety_number.toLowerCase().includes(search.value.toLowerCase()) ||
            cultivar.prime_name.toLowerCase().includes(search.value.toLowerCase()) ||
            cultivar.country.toLowerCase().includes(search.value.toLowerCase()) ||
            cultivar.color_of_berry_skin.toLowerCase().includes(search.value.toLowerCase()) ||
            cultivar.country_of_origin.toLowerCase().includes(search.value.toLowerCase()) ||
            cultivar.species.toLowerCase().includes(search.value.toLowerCase())
        );
    });
});

// Computed property for paginated cultivars, limited by displayedItems
const paginatedCultivars = computed(() => {
    return filteredCultivars.value.slice(0, displayedItems.value);
});

// Load More function
const loadMore = () => {
    displayedItems.value += 10; // Increase the number of items by 10
};

const formData = ref({
    code: '', // Optional: Leave this if you want it generated by the backend
    name: '',
    growth_season: '',
    maturity_days: null,
    yield_potential: null,
    water_requirements: null,
    soil_type: '',
    plant_spacing: null,
    root_depth: null,
    notes: 'N/A',
});

const errors = ref(null);

async function createCultivar() {
    try {
        // Prepare the data, converting numeric fields as needed
        const payload = {
            // Remove `code` if it should be generated by the server
            name: formData.value.name,
            growth_season: formData.value.growth_season,
            maturity_days: formData.value.maturity_days ? Number(formData.value.maturity_days) : null,
            yield_potential: formData.value.yield_potential ? Number(formData.value.yield_potential) : null,
            water_requirements: formData.value.water_requirements ? Number(formData.value.water_requirements) : null,
            soil_type: formData.value.soil_type,
            plant_spacing: formData.value.plant_spacing ? Number(formData.value.plant_spacing) : null,
            root_depth: formData.value.root_depth ? Number(formData.value.root_depth) : null,
            notes: formData.value.notes,
        };

        // Send the request
        const response = await axios.post('/cultivar/store', payload);

        // Reset form data and hide modal
        resetForm();
        showCreateCultivarModal.value = false;

        // Display success notification
        toast("Cultivar created successfully!", {
            theme: "colored",
            type: "success",
            position: "top-center",
            hideProgressBar: true,
            transition: "zoom",
        });
    } catch (error) {
        // Capture validation errors if available
        if (error.response && error.response.status === 422) {
            errors.value = error.response.data.errors;
        }
        // Show error notification
        toast("Error creating cultivar!", {
            theme: "colored",
            type: "error",
            position: "top-center",
            hideProgressBar: true,
            transition: "zoom",
        });

        console.error("Error in createCultivar:", error);
    }
}

// Function to reset form data
function resetForm() {
    formData.value = {
        code: '',
        name: '',
        growth_season: '',
        maturity_days: null,
        yield_potential: null,
        water_requirements: null,
        soil_type: '',
        plant_spacing: null,
        root_depth: null,
        notes: 'N/A',
    };
    errors.value = null; // Clear previous errors
}

const showEditModal = ref(false);
const showDeleteModal = ref(false);
const selectedCultivar = ref(null);

const editForm = ref({
    name: '',
    growth_season: '',
    maturity_days: null,
    yield_potential: null,
    water_requirements: null,
    soil_type: '',
    plant_spacing: null,
    root_depth: null,
    notes: ''
});

// Open edit modal and populate form data
function openEditModal(cultivar) {
    selectedCultivar.value = cultivar;
    editForm.value = { ...cultivar };
    showEditModal.value = true;
}

// Update cultivar
async function updateCultivar() {
    try {
        await axios.put(`/cultivar/${selectedCultivar.value.id}`, editForm.value);
        showEditModal.value = false;

        // Refresh data after update
        toast("Cultivar updated successfully!", {
            theme: "colored",
            type: "success",
            position: "top-center",
            hideProgressBar: true,
            transition: "zoom",
        });
    } catch (error) {
        console.error("Error updating cultivar:", error);
        toast("Error updating cultivar!", {
            theme: "colored",
            type: "error",
            position: "top-center",
            hideProgressBar: true,
            transition: "zoom",
        });
    }
}

// Open delete modal
function openDeleteModal(cultivar) {
    selectedCultivar.value = cultivar;
    showDeleteModal.value = true;
}

// Delete cultivar
async function deleteCultivar() {
    try {
        await axios.delete(`/cultivar/${selectedCultivar.value.id}`);
        showDeleteModal.value = false;

        // Remove deleted cultivar from local data
        const index = (cultivars.value || []).findIndex(c => c.id === selectedCultivar.value.id);
        if (index !== -1) {
            cultivars.value.splice(index, 1);
        }


        toast("Cultivar deleted successfully!", {
            theme: "colored",
            type: "success",
            position: "top-center",
            hideProgressBar: true,
            transition: "zoom",
        });
    } catch (error) {
        console.error("Error deleting cultivar:", error);
        toast("Error deleting cultivar!", {
            theme: "colored",
            type: "error",
            position: "top-center",
            hideProgressBar: true,
            transition: "zoom",
        });
    }
}
</script>
