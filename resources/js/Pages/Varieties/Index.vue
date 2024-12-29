<template>
    <AppLayout title="Varieties">

        <!-- Header Section -->
        <div class="overflow-x-hidden overflow-y-auto">
            <div class="block md:flex items-center justify-between mb-4">
                <p class="text-sm mt-1 text-black font-medium">
                    <span class="font-bold">Total Varieties:</span> {{ filteredVarieties.length }}
                    (Filtered from {{ varietyCount }})
                </p>

                <div class="mt-4 md:mt-0 flex items-center space-x-2 md:space-x-4">
                    <!-- Search Bar -->
                    <TextInput type="text" v-model="search" placeholder="Search" class="w-96" />

                    <div class="w-full md:w-fit">
                        <PrimaryButton @click="showCreateModal = true">
                            Add Variety
                        </PrimaryButton>
                    </div>
                </div>
            </div>

            <!-- Create Modal -->
            <div v-if="showCreateModal" class="fixed z-50 inset-0 flex items-center justify-center">
                <div class="fixed inset-0 bg-black opacity-50"></div>
                <div class="relative bg-white rounded-lg p-6 w-full max-w-sm z-50">
                    <h3 class="text-lg font-semibold mb-4">Create New Variety</h3>

                    <div class="mb-4">
                        <InputLabel value="Name" />
                        <TextInput id="name" type="text" v-model="createForm.name" class="mt-1 block w-full"
                                   placeholder="Name" required />
                    </div>

                    <div class="flex items-center space-x-4">
                        <div class="w-full mb-4">
                            <InputLabel value="Type" />
                            <select v-model="createForm.type_id"
                                    class="w-full text-xs mt-1 placeholder:text-xs border-gray-300 focus:border-[#BCDA84] focus:ring-[#BCDA84] rounded-lg"
                                    required>
                                <option value="" disabled>Select a Type</option>
                                <option v-for="type in types" :key="type.id" :value="type.id">
                                    {{ type.name }}
                                </option>
                            </select>
                        </div>

                        <div class="w-full mb-4">
                            <InputLabel value="Growth Season" />
                            <select v-model="createForm.growth_season"
                                    class="w-full text-xs mt-1 placeholder:text-xs border-gray-300 focus:border-[#BCDA84] focus:ring-[#BCDA84] rounded-lg"
                                    required>
                                <option value="" disabled>Select a Season</option>
                                <option value="spring">Spring</option>
                                <option value="summer">Summer</option>
                                <option value="autumn">Autumn</option>
                                <option value="winter">Winter</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        <div class="mb-4">
                            <InputLabel value="Yield Potential" />
                            <p class="text-gray-400 text-[11px]">Kilograms per Hectare</p>
                            <TextInput type="number" v-model="createForm.yield_potential" placeholder="Yield Potential"
                                       class="mt-1 block w-full" />
                        </div>

                        <div class="mb-4">
                            <InputLabel value="Water Requirements" />
                            <p class="text-gray-400 text-[11px]">Litre per Week</p>
                            <TextInput type="text" v-model="createForm.water_requirements" placeholder="Water Requirements"
                                       class="mt-1 block w-full" />
                        </div>
                    </div>

                    <div class="mb-4">
                        <InputLabel value="Soil Type" />
                        <TextInput type="text" v-model="createForm.soil_type" placeholder="Soil Type"
                                   class="mt-1 block w-full" />
                    </div>

                    <div class="flex space-x-4">
                        <div class="mb-4">
                            <InputLabel value="Plant Spacing" />
                            <TextInput type="text" v-model="createForm.plant_spacing" placeholder="Plant Spacing"
                                       class="mt-1 block w-full" />
                        </div>

                        <div class="mb-4">
                            <InputLabel value="Row Spacing" />
                            <TextInput type="text" v-model="createForm.row_spacing" placeholder="Row Spacing"
                                       class="mt-1 block w-full" />
                        </div>
                    </div>

                    <div class="mb-4">
                        <InputLabel value="Root Depth" />
                        <TextInput type="text" v-model="createForm.root_depth" placeholder="Root Depth"
                                   class="mt-1 block w-full" />
                    </div>

                    <div class="mt-6 text-gray-500 flex justify-end space-x-4">
                        <CancelButton @click="showCreateModal = false">Cancel</CancelButton>
                        <PrimaryButton @click="create">Create</PrimaryButton>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Table Section -->
        <div v-if="filteredVarieties.length > 0">
            <div class="rounded-lg overflow-x-auto">
                <table class="min-w-full text-sm text-black">
                    <thead class="bg-white border-b-2 border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-medium w-16">ID</th>
                        <th class="px-6 py-4 text-left text-xs font-medium w-48">Name</th>
                        <th class="px-6 py-4 text-left text-xs font-medium w-48">Type</th>
                        <th class="px-6 py-4 text-left text-xs font-medium w-48">Yield Potential</th>
                        <th class="px-6 py-4 text-left text-xs font-medium w-48">Water Requirements</th>
                        <th class="px-6 py-4 text-left text-xs font-medium w-48">Soil Type</th>
                        <th class="px-6 py-4 text-left text-xs font-medium w-48">Growth Season</th>
                        <th class="px-6 py-4 text-right text-xs font-medium w-28">Actions</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="variety in filteredVarieties" :key="variety.id" @click.stop="openDetailDrawer(variety)" class="cursor-pointer">
                        <td class="px-6 py-2 text-xs text-gray-500 w-16">{{ variety.id }}</td>
                        <td class="px-6 py-2 text-xs text-gray-500 w-48">{{ variety.name }}</td>
                        <td class="px-6 py-2 text-xs text-gray-500 w-48">{{ variety.type.name }}</td>
                        <td class="px-6 py-2 text-xs text-gray-500 w-32">{{ variety.yield_potential }}</td>
                        <td class="px-6 py-2 text-xs text-gray-500 w-32">{{ variety.water_requirements }}</td>
                        <td class="px-6 py-2 text-xs text-gray-500 w-32">{{ variety.soil_type }}</td>
                        <td class="px-6 py-2 text-xs text-gray-500 w-32 capitalize">{{ variety.growth_season }}</td>
                        <td class="px-6 py-2 text-xs text-gray-500 text-right w-28 z-30">
                            <div class="flex items-center space-x-4 justify-end">
                                <!-- Open Delete Confirmation Modal -->
                                <PrimaryButton class="!w-fit cursor-not-allowed bg-gray-200 hover:bg-gray-300 text-gray-700 opacity-50">Delete</PrimaryButton>
                                <!-- <PrimaryButton class="!z-10 !w-fit cursor-not-allowed bg-gray-200 hover:bg-gray-300 text-gray-700 opacity-50" @click="openDeleteModal(variety)">Delete</PrimaryButton>-->

                                <!-- Open Edit Modal -->
                                <SecondaryButton class="!w-fit" @click.stop="openEditModal(variety)">Edit</SecondaryButton>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

        </div>

        <!-- No Types Found -->
        <div v-else>
            <p>No types found</p>
        </div>

        <!-- Delete Confirmation Modal -->
        <div v-if="showDeleteModal" class="fixed z-50 inset-0 flex items-center justify-center">
            <div class="fixed inset-0 bg-black/40"></div>
            <div class="relative bg-white rounded-lg p-6 w-full max-w-sm z-50">
                <h3 class="text-black text-lg font-semibold mb-4">Confirm Delete</h3>
                <p>Are you sure you want to delete this variety?</p>

                <div class="mt-6 flex justify-end space-x-4">
                    <CancelButton @click="showDeleteModal = false">Cancel</CancelButton>
                    <DangerButton @click="deleteVariety()">Delete</DangerButton>
                </div>
            </div>
        </div>

        <!-- Edit Modal -->
        <div v-if="showEditModal" class="fixed z-50 inset-0 flex items-center justify-center">
            <div class="fixed inset-0 bg-black/40"></div>
            <div class="relative bg-white rounded-lg p-6 w-full max-w-sm z-50">
                <h3 class="text-black text-lg font-semibold mb-4">Edit Variety</h3>

                <div class="mb-4">
                    <InputLabel value="Name" />
                    <TextInput id="name" type="text" v-model="editForm.name" class="mt-1 block w-full"
                               placeholder="Name" required />
                </div>

                <div class="flex items-center space-x-4">
                    <div class="w-full mb-4">
                        <InputLabel value="Type" />
                        <select
                            v-model="editForm.type_id"
                            class="w-full text-xs mt-1 placeholder:text-xs border-gray-300 focus:border-[#BCDA84] focus:ring-[#BCDA84] rounded-lg"
                            required
                        >
                            <option value="" disabled>Select a Type</option>
                            <option v-for="type in types" :key="type.id" :value="type.id">
                                {{ type.name }}
                            </option>
                        </select>
                    </div>

                    <div class="w-full mb-4">
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
                </div>

                <div class="flex items-center space-x-4">
                    <div class="mb-4">
                        <InputLabel value="Yield Potential" />
                        <p class="text-gray-400 text-[11px]">Kilograms per Hectare</p>
                        <TextInput type="number" v-model="editForm.yield_potential" placeholder="Yield Potential"
                                   class="mt-1 block w-full" />
                    </div>

                    <div class="mb-4">
                        <InputLabel value="Water Requirements" />
                        <p class="text-gray-400 text-[11px]">Litre per Week</p>
                        <TextInput type="text" v-model="editForm.water_requirements" placeholder="Water Requirements"
                                   class="mt-1 block w-full" />
                    </div>
                </div>

                <div class="mb-4">
                    <InputLabel value="Soil Type" />
                    <TextInput type="text" v-model="editForm.soil_type" placeholder="Soil Type"
                               class="mt-1 block w-full" />
                </div>

                <div class="flex space-x-4">
                    <div class="mb-4">
                        <InputLabel value="Plant Spacing" />
                        <TextInput type="text" v-model="editForm.plant_spacing" placeholder="Plant Spacing"
                                   class="mt-1 block w-full" />
                    </div>

                    <div class="mb-4">
                        <InputLabel value="Row Spacing" />
                        <TextInput type="text" v-model="editForm.row_spacing" placeholder="Row Spacing"
                                   class="mt-1 block w-full" />
                    </div>
                </div>

                <div class="mb-4">
                    <InputLabel value="Root Depth" />
                    <TextInput type="text" v-model="editForm.root_depth" placeholder="Root Depth"
                               class="mt-1 block w-full" />
                </div>

                <div class="mt-6 flex justify-end space-x-4">
                    <CancelButton @click="showEditModal = false">Cancel</CancelButton>
                    <PrimaryButton @click="editVariety()">Update</PrimaryButton>
                </div>
            </div>
        </div>

        <!-- Detailed View Side Drawer -->
        <div>
            <div v-if="showDetailDrawer" class="fixed top-0 right-0 w-full md:w-[475px] h-full bg-white shadow-lg z-50">
                <div class="fixed inset-0 bg-black/40"></div>

                <div class="relative bg-white h-full z-50">
                    <div class="flex justify-between items-center px-4 py-4">
                        <h3 class="text-lg font-semibold">Variety Details</h3>
                        <button @click="closeDetailDrawer" class="text-gray-500 hover:text-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>

                    <div class="px-4 pt-4">
                        <div class="mb-4">
                            <InputLabel value="Name" />
                            <TextInput id="name" type="text" v-model="selectedVariety.name" class="mt-1 block w-full"
                                       placeholder="Name" readonly />
                        </div>

                        <div class="w-full flex items-center space-x-4">
                            <div class="w-full mb-4">
                                <InputLabel value="Type" />
                                <select v-model="selectedVariety.type_id"
                                        class="w-full text-xs mt-1 placeholder:text-xs border-gray-300 focus:border-[#BCDA84] focus:ring-[#BCDA84] rounded-lg !bg-white" disabled>
                                    <option value="" disabled>Select a Type</option>
                                    <option v-for="type in types" :key="type.id" :value="type.id">
                                        {{ type.name }}
                                    </option>
                                </select>
                            </div>

                            <div class="w-full mb-4">
                                <InputLabel value="Growth Season" />
                                <select v-model="selectedVariety.growth_season"
                                        class="w-full text-xs mt-1 placeholder:text-xs border-gray-300 focus:border-[#BCDA84] focus:ring-[#BCDA84] rounded-lg !bg-white"
                                        disabled>
                                    <option value="" disabled>Select a Season</option>
                                    <option value="spring">Spring</option>
                                    <option value="summer">Summer</option>
                                    <option value="autumn">Autumn</option>
                                    <option value="winter">Winter</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex items-center space-x-4">
                            <div class="w-full mb-4">
                                <InputLabel value="Yield Potential" />
                                <p class="text-gray-400 text-[11px]">Kilograms per Hectare</p>
                                <TextInput type="number" v-model="selectedVariety.yield_potential" placeholder="Yield Potential"
                                           class="mt-1 block w-full" readonly />
                            </div>

                            <div class="w-full mb-4">
                                <InputLabel value="Water Requirements" />
                                <p class="text-gray-400 text-[11px]">Litre per Week</p>
                                <TextInput type="text" v-model="selectedVariety.water_requirements" placeholder="Water Requirements"
                                           class="mt-1 block w-full" readonly />
                            </div>
                        </div>

                        <div class="mb-4">
                            <InputLabel value="Soil Type" />
                            <TextInput type="text" v-model="selectedVariety.soil_type" placeholder="Soil Type"
                                       class="mt-1 block w-full" readonly />
                        </div>

                        <div class="flex items-center space-x-4">
                            <div class="w-full mb-4">
                                <InputLabel value="Plant Spacing" />
                                <TextInput type="text" v-model="selectedVariety.plant_spacing" placeholder="Plant Spacing"
                                           class="mt-1 block w-full" readonly />
                            </div>

                            <div class="w-full mb-4">
                                <InputLabel value="Row Spacing" />
                                <TextInput type="text" v-model="selectedVariety.row_spacing" placeholder="Row Spacing"
                                           class="mt-1 block w-full" readonly />
                            </div>
                        </div>

                        <div class="mb-4">
                            <InputLabel value="Root Depth" />
                            <TextInput type="text" v-model="selectedVariety.root_depth" placeholder="Root Depth"
                                       class="mt-1 block w-full" readonly />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { toast } from 'vue3-toastify';
import { ref, computed, onMounted } from 'vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import CancelButton from '@/Components/CancelButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import DangerButton from "@/Components/DangerButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

const { varieties, varietyCount } = defineProps({
    varieties: Array,
    varietyCount: Number,
});

const types = ref([]);

const search = ref('');
const showCreateModal = ref(false);
const showDeleteModal = ref(false);
const selectedVariety = ref(null);
const showEditModal = ref(false);
const isLoading = ref(false); // Add isLoading state
const showDetailDrawer = ref(false);

const filteredVarieties = computed(() => {
    if (!Array.isArray(varieties)) return [];
    if (!search.value) return varieties;

    const searchValue = search.value.toLowerCase();
    return varieties.filter((variety) =>
        variety.name.toLowerCase().includes(searchValue) ||
        variety.growth_season.toLowerCase().includes(searchValue) ||
        variety.yield_potential?.toLowerCase().includes(searchValue) ||
        variety.water_requirements?.toString().toLowerCase().includes(searchValue) ||
        variety.soil_type?.toLowerCase().includes(searchValue) ||
        variety.plant_spacing?.toString().toLowerCase().includes(searchValue) ||
        variety.row_spacing?.toString().toLowerCase().includes(searchValue) ||
        variety.root_depth?.toLowerCase().includes(searchValue)
    );
});

const openDetailDrawer = (variety) => {
    selectedVariety.value = variety;
    showDetailDrawer.value = true;
};

const closeDetailDrawer = () => {
    showDetailDrawer.value = false;
    selectedVariety.value = null;
};

const createForm = ref({
    type_id: '',
    name: '',
    yield_potential: '',
    water_requirements: '',
    soil_type: '',
    plant_spacing: '',
    row_spacing: '',
    root_depth: '',
    growth_season: '',
});

const create = async () => {
    if (isLoading.value) return; // Prevent duplicate clicks
    isLoading.value = true;

    try {
        const response = await axios.post('/varieties/store', createForm.value);

        varieties.push(response.data);
        showCreateModal.value = false;
        createForm.value.type_id = '';
        createForm.value.name = '';
        createForm.value.yield_potential = '';
        createForm.value.water_requirements = '';
        createForm.value.soil_type = '';
        createForm.value.plant_spacing = '';
        createForm.value.row_spacing = '';
        createForm.value.root_depth = '';
        createForm.value.growth_season = '';

        toast("Record created successfully!", {
            theme: "colored",
            type: "success",
            position: "top-center",
            hideProgressBar: true,
            transition: "zoom",
        });

        window.location.reload();
    } catch (error) {
        console.error("Error creating variety:", error);

        toast("Error creating record!", {
            theme: "colored",
            type: "error",
            position: "top-center",
            hideProgressBar: true,
            transition: "zoom",
        });
    } finally {
        isLoading.value = false;
    }
};

const openDeleteModal = (variety) => {
    selectedVariety.value = variety;
    showDeleteModal.value = true;
};

const deleteVariety = async () => {
    if (!selectedVariety.value || isLoading.value) return;
    isLoading.value = true;

    try {
        await axios.delete(`/varieties/${selectedVariety.value.id}`);
        const index = varieties.findIndex(variety => variety.id === selectedVariety.value.id);
        if (index !== -1) varieties.splice(index, 1);

        toast("Record deleted successfully!", {
            theme: "colored",
            type: "success",
            position: "top-center",
            hideProgressBar: true,
            transition: "zoom",
        });

        showDeleteModal.value = false;

        window.location.reload();
    } catch (error) {
        console.error("Error deleting variety:", error);

        toast("Error deleting record!", {
            theme: "colored",
            type: "error",
            position: "top-center",
            hideProgressBar: true,
            transition: "zoom",
        });
    } finally {
        isLoading.value = false;
    }
};

const editForm = ref({
    id: null,
    type_id: '',
    name: '',
    yield_potential: '',
    water_requirements: '',
    soil_type: '',
    plant_spacing: '',
    row_spacing: '',
    root_depth: '',
    growth_season: '',
});

const openEditModal = (variety) => {
    editForm.value.id = variety.id;
    editForm.value.type_id = variety.type.id;
    editForm.value.name = variety.name;
    editForm.value.yield_potential = variety.yield_potential;
    editForm.value.water_requirements = variety.water_requirements;
    editForm.value.soil_type = variety.soil_type;
    editForm.value.plant_spacing = variety.plant_spacing;
    editForm.value.row_spacing = variety.row_spacing;
    editForm.value.root_depth = variety.root_depth;
    editForm.value.growth_season = variety.growth_season;
    showEditModal.value = true;
};

const editVariety = async () => {
    if (isLoading.value) return;
    isLoading.value = true;

    try {
        const response = await axios.patch(`/varieties/${editForm.value.id}`, editForm.value);

        const index = varieties.findIndex(variety => variety.id === editForm.value.id);
        if (index !== -1) varieties[index] = response.data;

        toast("Record updated successfully!", {
            theme: "colored",
            type: "success",
            position: "top-center",
            hideProgressBar: true,
            transition: "zoom",
        });

        showEditModal.value = false;

        window.location.reload();
    } catch (error) {
        console.error("Error updating variety:", error);

        toast("Error updating record!", {
            theme: "colored",
            type: "error",
            position: "top-center",
            hideProgressBar: true,
            transition: "zoom",
        });
    } finally {
        isLoading.value = false;
    }
};

// Function to fetch types from the API
const fetchTypes = async () => {
    try {
        const response = await axios.get('/api/types');
        types.value = response.data.types;
    } catch (error) {
        console.error('Error fetching types:', error);
    }
};

// Call fetchTypes when the component is mounted
onMounted(fetchTypes);
</script>
