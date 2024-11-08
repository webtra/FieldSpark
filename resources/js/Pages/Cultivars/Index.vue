<template>
    <AppLayout title="Cultivar Management">
        <div class="overflow-x-hidden overflow-y-auto">
            <div class="block md:flex items-center justify-between mb-4">
                <p class="text-sm mt-1 text-black font-medium"><span class="font-bold">Total Cultivars:</span> {{ filteredCultivars.length }} (Filtered
                    from {{
                        cultivarCount }})</p>

                <div class="mt-4 md:mt-0 flex items-center space-x-2 md:space-x-4">
                    <!-- Search Bar -->
                    <TextInput type="text" v-model="search" placeholder="Search" class="w-full md:w-96" />

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
                <div class="relative bg-white rounded-lg p-6 w-full max-w-sm z-50">
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
                            class="w-full text-xs mt-1 placeholder:text-xs border-gray-300 focus:border-[#BCDA84] focus:ring-[#BCDA84] rounded-lg"
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
                <div class="rounded-lg overflow-x-auto">
                    <table class="min-w-full text-sm text-black">
                        <thead class="bg-white border-b-2 border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium w-32 whitespace-nowrap">
                                    ID</th>
                                <th class="px-4 py-4 text-left text-xs font-medium w-40 whitespace-nowrap">
                                    Variety Name</th>
                                <th class="px-4 py-4 text-left text-xs font-medium w-40 whitespace-nowrap">
                                    Season</th>
                                <th class="px-4 py-4 text-left text-xs font-medium w-40 whitespace-nowrap">
                                    Yield Potential</th>
                                <th class="px-4 py-4 text-left text-xs font-medium w-40 whitespace-nowrap">
                                    Water Requirements</th>
                                <th class="px-4 py-4 text-left text-xs font-medium w-40 whitespace-nowrap">
                                    Soil Type</th>
                                <th class="px-4 py-4 text-left text-xs font-medium w-40 whitespace-nowrap">
                                    Plant Spacing</th>
                                <th class="px-4 py-4 text-left text-xs font-medium w-40 whitespace-nowrap">
                                    Root Depth</th>
                                <th class="px-6 py-4 text-xs font-medium w-32 whitespace-nowrap text-right">
                                    Actions</th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="cultivar in paginatedCultivars" :key="cultivar.id">
                                <td class="px-6 py-2 text-xs text-gray-600 w-32">{{ cultivar.id }}</td>
                                <td class="px-4 py-2 text-xs text-gray-600 w-40">{{ cultivar.name }}</td>
                                <td class="px-4 py-2 text-xs text-gray-600 w-40 capitalize">{{ cultivar.growth_season }}
                                </td>
                                <td class="px-4 py-2 text-xs text-gray-600 w-40">{{ cultivar.yield_potential || 'N/A' }}
                                </td>
                                <td class="px-4 py-2 text-xs text-gray-600 w-40">{{ cultivar.water_requirements || 'N/A'
                                    }}</td>
                                <td class="px-4 py-2 text-xs text-gray-600 w-40">{{ cultivar.soil_type || 'N/A' }}</td>
                                <td class="px-4 py-2 text-xs text-gray-600 w-40">{{ cultivar.plant_spacing || 'N/A' }}
                                </td>
                                <td class="px-4 py-2 text-xs text-gray-600 w-40">{{ cultivar.root_depth || 'N/A' }}</td>
                                <td class="py-2 text-xs text-gray-600 w-32 space-x-4 flex justify-end">
                                    <!-- Delete button and modal -->
                                    <div>
                                        <PrimaryButton @click="openDeleteModal(cultivar)" :disabled="true"
                                            class="cursor-not-allowed bg-gray-200 hover:bg-gray-300 text-gray-700 opacity-50">
                                            Delete
                                        </PrimaryButton>


                                        <div v-if="showDeleteModal"
                                            class="fixed z-50 inset-0 flex items-center justify-center">
                                            <div class="fixed inset-0 bg-black/50"></div>

                                            <div class="relative bg-white rounded-lg p-6 w-full max-w-sm z-50">
                                                <h3 class="text-black text-lg font-semibold mb-4">Confirm Delete</h3>
                                                <p>Are you sure you want to delete this cultivar?</p>

                                                <div class="mt-6 flex justify-end space-x-4">
                                                    <CancelButton @click="showDeleteModal = false">Cancel</CancelButton>
                                                    <DangerButton @click="deleteCultivar">Delete</DangerButton>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Edit button and modal -->
                                    <div>
                                        <SecondaryButton @click="openEditModal(cultivar)">Edit</SecondaryButton>

                                        <div v-if="showEditModal"
                                            class="fixed z-50 inset-0 flex items-center justify-center">
                                            <!-- Black overlay (backdrop) -->
                                            <div class="fixed inset-0 bg-black/50"></div>

                                            <!-- Modal content -->
                                            <div class="relative bg-white rounded-lg p-6 w-full max-w-sm z-50">
                                                <h3 class="text-lg font-semibold mb-4 text-black">Edit Cultivar</h3>

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
                                                        class="w-full text-xs mt-1 placeholder:text-xs border-gray-300 focus:border-[#BCDA84] focus:ring-[#BCDA84] rounded-lg"
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
import SecondaryButton from '@/Components/SecondaryButton.vue';

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
            cultivar.name.toLowerCase().includes(search.value.toLowerCase()) ||
            (cultivar.growth_season && cultivar.growth_season.toLowerCase().includes(search.value.toLowerCase())) ||
            (cultivar.yield_potential && cultivar.yield_potential.toString().includes(search.value.toLowerCase())) ||
            (cultivar.water_requirements && cultivar.water_requirements.toString().includes(search.value.toLowerCase())) ||
            (cultivar.soil_type && cultivar.soil_type.toLowerCase().includes(search.value.toLowerCase())) ||
            (cultivar.plant_spacing && cultivar.plant_spacing.toString().includes(search.value.toLowerCase())) ||
            (cultivar.root_depth && cultivar.root_depth.toString().includes(search.value.toLowerCase()))
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

const createCultivar = async () => {
    try {
        const response = await axios.post('/cultivar/store', formData.value);

        // Reset form data and hide modal
        resetForm();
        showCreateCultivarModal.value = false;

        // Display success notification
        toast("Record created successfully!", {
            theme: "colored",
            type: "success",
            position: "top-center",
            hideProgressBar: true,
            transition: "zoom",
        });

        window.location.reload();
    } catch (error) {
        toast("Error creating record!", {
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
        toast("Record updated successfully!", {
            theme: "colored",
            type: "success",
            position: "top-center",
            hideProgressBar: true,
            transition: "zoom",
        });

        window.location.reload();
    } catch (error) {
        console.error("Error updating cultivar:", error);
        toast("Error updating record!", {
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

        toast("Record deleted successfully!", {
            theme: "colored",
            type: "success",
            position: "top-center",
            hideProgressBar: true,
            transition: "zoom",
        });

        window.location.reload();
    } catch (error) {
        console.error("Error deleting cultivar:", error);
        toast("Error deleting record!", {
            theme: "colored",
            type: "error",
            position: "top-center",
            hideProgressBar: true,
            transition: "zoom",
        });
    }
}
</script>
