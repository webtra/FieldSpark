<template>
    <AppLayout title="Crop">
        <div class="overflow-x-hidden overflow-y-auto">
            <div class="block md:flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-base font-semibold leading-6 text-gray-900">Crop Management</h1>
                    <p class="mt-1 text-gray-500">Total Crops: {{ filteredCrops.length }} (Filtered from {{ cropCount
                        }})</p>
                </div>

                <div class="mt-4 md:mt-0 flex items-center space-x-4">
                    <!-- Search Bar -->
                    <TextInput type="text" v-model="search" placeholder="Search Crop..." class="w-96" />

                    <div>
                        <PrimaryButton>
                            Create Crop
                        </PrimaryButton>
                    </div>
                </div>
            </div>

            <!-- Table of Crops -->
            <div class="mt-4" v-if="paginatedCrops && paginatedCrops.length > 0">
                <div class="border border-gray-300 rounded-md overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-300 table-fixed">
                        <thead class="text-black bg-white">
                            <tr>
                                <th
                                    class="px-4 py-4 text-left text-xs font-medium uppercase tracking-wider w-48 whitespace-nowrap">
                                    Cultivar</th>
                                <th
                                    class="px-4 py-4 text-left text-xs font-medium uppercase tracking-wider w-36 whitespace-nowrap">
                                    Block Number</th>
                                <th
                                    class="px-4 py-4 text-left text-xs font-medium uppercase tracking-wider w-36 whitespace-nowrap">
                                    Planting Date</th>
                                <th
                                    class="px-4 py-4 text-left text-xs font-medium uppercase tracking-wider w-36 whitespace-nowrap">
                                    Harvest Date</th>
                                <th
                                    class="px-4 py-4 text-left text-xs font-medium uppercase tracking-wider w-36 whitespace-nowrap">
                                    Location</th>
                                <th
                                    class="px-4 py-4 text-left text-xs font-medium uppercase tracking-wider w-28 whitespace-nowrap">
                                    Status</th>
                                <th
                                    class="px-4 py-4 text-left text-xs font-medium uppercase tracking-wider w-32 whitespace-nowrap">
                                    Size</th>
                                <th
                                    class="px-4 py-4 text-left text-xs font-medium uppercase tracking-wider w-28 whitespace-nowrap">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="crop in paginatedCrops" :key="crop.id" class="odd:bg-white even:bg-gray-50">
                                <td class="px-4 py-4 text-xs text-gray-500 w-48">{{ crop.cultivar.prime_name || 'N/A' }}
                                </td>
                                <td class="px-4 py-4 text-xs text-gray-500 w-36">{{ crop.block_number }}</td>
                                <td class="px-4 py-4 text-xs text-gray-500 w-36">{{ crop.planting_date }}</td>
                                <td class="px-4 py-4 text-xs text-gray-500 w-36">{{ crop.harvest_date }}</td>
                                <td class="px-4 py-4 text-xs text-gray-500 w-36">{{ crop.location }}</td>
                                <td class="px-4 py-4 text-xs text-gray-500 w-28 uppercase tracking-wide">
                                    <span class="px-3 py-1.5 rounded-full text-[11px] font-semibold text-white" :class="{
                                        'bg-emerald-100 text-emerald-700': crop.status === 'planted',
                                        'bg-violet-100 text-violet-700': crop.status === 'growing',
                                        'bg-sky-100 text-sky-700': crop.status === 'harvested',
                                        'bg-red-100 text-red-700': crop.status === 'failed'
                                    }">
                                        {{ crop.status }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 text-xs text-gray-500 w-32">{{ crop.size }} hectare</td>
                                <td class="px-4 py-2 text-xs text-gray-500 w-28 space-x-4 flex items-center">
                                    <!-- Delete button and modal -->
                                    <div class="mt-2">
                                        <button class="underline" @click="openDeleteModal(crop)">Delete</button>

                                        <div v-if="showDeleteModal"
                                            class="fixed z-50 inset-0 flex items-center justify-center">
                                            <!-- Black overlay (backdrop) -->
                                            <div class="fixed inset-0 bg-black/10"></div>

                                            <!-- Modal content -->
                                            <div class="relative bg-white rounded p-6 w-full max-w-sm z-50">
                                                <h3 class="text-black text-lg font-semibold mb-4">Confirm Delete</h3>
                                                <p>Are you sure you want to delete this crop?</p>

                                                <div class="mt-6 flex justify-end space-x-4">
                                                    <button class="px-4 py-2 bg-gray-300 rounded"
                                                        @click="showDeleteModal = false">Cancel</button>
                                                    <button class="px-4 py-2 bg-red-600 text-white rounded"
                                                        @click="deleteCrop(selectedCrop)">Delete</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Edit button and modal -->
                                    <div class="mt-2">
                                        <button class="underline" @click="openEditModal(crop)">Edit</button>

                                        <div v-if="showEditModal"
                                            class="fixed z-50 inset-0 flex items-center justify-center">
                                            <!-- Black overlay (backdrop) -->
                                            <div class="fixed inset-0 bg-black/10"></div>

                                            <!-- Modal content -->
                                            <div class="relative bg-white rounded p-6 w-full max-w-sm z-50">
                                                <h3 class="text-black text-lg font-semibold mb-4">Edit Crop</h3>

                                                <!-- Cultivar Dropdown -->
                                                <div class="mb-4">
                                                    <InputLabel for="cultivar" value="Cultivar" />
                                                    <select id="cultivar" v-model="editForm.cultivar_id"
                                                        class="w-full text-xs mt-1 placeholder:text-xs border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded">
                                                        <option v-for="cultivar in cultivars" :key="cultivar.id"
                                                            :value="cultivar.id">
                                                            {{ cultivar.prime_name }}
                                                        </option>
                                                    </select>
                                                </div>

                                                <!-- Input fields for editing crop information -->
                                                <div class="mb-4">
                                                    <InputLabel for="block_number" value="Block Number" />
                                                    <TextInput id="block_number" type="text"
                                                        v-model="editForm.block_number" class="mt-1 block w-full"
                                                        placeholder="Block Number" />
                                                </div>

                                                <div class="flex space-x-4 mb-4">
                                                    <div class="w-full">
                                                        <InputLabel for="planting_date" value="Planting Date" />
                                                        <TextInput id="planting_date" type="date"
                                                            v-model="editForm.planting_date" class="mt-1 block w-full"
                                                            placeholder="Planting Date" />
                                                    </div>

                                                    <div class="w-full">
                                                        <InputLabel for="harvest_date" value="Harvest Date" />
                                                        <TextInput id="harvest_date" type="date"
                                                            v-model="editForm.harvest_date" class="mt-1 block w-full"
                                                            placeholder="Harvest Date" />
                                                    </div>
                                                </div>

                                                <div class="mb-4">
                                                    <InputLabel for="location" value="Location (Farm Name)" />
                                                    <TextInput id="location" type="text" v-model="editForm.location"
                                                        class="mt-1 block w-full" placeholder="Location (Farm Name)" />
                                                </div>

                                                <!-- Status Dropdown -->
                                                <div class="mb-4">
                                                    <InputLabel for="status" value="Status" />
                                                    <select id="status" v-model="editForm.status"
                                                        class="w-full text-xs mt-1 placeholder:text-xs border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded">
                                                        <option value="planted">Planted</option>
                                                        <option value="growing">Growing</option>
                                                        <option value="harvested">Harvested</option>
                                                        <option value="failed">Failed</option>
                                                    </select>
                                                </div>

                                                <div class="mb-4">
                                                    <InputLabel for="size" value="Size" />
                                                    <TextInput id="size" type="number" v-model="editForm.size"
                                                        class="mt-1 block w-full" placeholder="Size" />
                                                </div>

                                                <div class="mt-6 flex justify-end space-x-4">
                                                    <button class="px-4 py-2 bg-gray-300 rounded"
                                                        @click="showEditModal = false">Cancel</button>
                                                    <button class="px-4 py-2 bg-blue-600 text-white rounded"
                                                        @click="editCrop(selectedCrop)">Update</button>
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
                    <button v-if="displayedItems < filteredCrops.length" @click="loadMore"
                        class="px-4 py-2 rounded bg-blue-500 text-white hover:bg-blue-600">
                        Load More
                    </button>
                </div>
            </div>

            <!-- If no crops found -->
            <div v-else>
                <p>No crops found</p>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { toast } from 'vue3-toastify'
import { ref, computed, onMounted } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';;
import PrimaryButton from '@/Components/PrimaryButton.vue';

const { crops, cropCount } = defineProps({
    crops: Array,
    cropCount: Number,
});

const search = ref('');
const displayedItems = ref(10); // Start with 10 items displayed

// Computed property to filter crops based on the search term
const filteredCrops = computed(() => {
    if (!search.value) return crops;

    const searchValue = search.value.toLowerCase();
    return crops.filter((crop) => {
        return (
            (crop.cultivar && crop.cultivar.prime_name.toLowerCase().includes(searchValue)) ||
            crop.block_number.toLowerCase().includes(searchValue) ||
            crop.planting_date.toLowerCase().includes(searchValue) ||
            (crop.harvest_date && crop.harvest_date.toLowerCase().includes(searchValue)) ||
            crop.location.toLowerCase().includes(searchValue) ||
            crop.status.toLowerCase().includes(searchValue) ||
            crop.size.toString().includes(searchValue)
        );
    });
});


// Computed property for paginated crops, limited by displayedItems
const paginatedCrops = computed(() => {
    return filteredCrops.value.slice(0, displayedItems.value);
});

// Load More function to increase displayed items
const loadMore = () => {
    displayedItems.value += 10; // Load 10 more items on each click
};

const showDeleteModal = ref(false);
const showEditModal = ref(false);
const selectedCrop = ref(null);
const cultivars = ref([]); // List of cultivars for dropdown

// The editable fields in a crop record
const editForm = ref({
    cultivar_id: null,
    block_number: '',
    planting_date: '',
    harvest_date: '',
    location: '',
    status: '',
    size: 0,
});

const fetchCultivars = async () => {
    try {
        const response = await axios.get('/api/fetch-cultivars');
        cultivars.value = response.data;
    } catch (error) {
        toast("Error loading cultivars!", {
            "theme": "colored",
            "type": "error",
            "position": "top-center",
            "hideProgressBar": true,
            "transition": "zoom",
        });
        console.error("Error fetching cultivars:", error);
    }
};


// Open the delete modal for the selected crop
function openDeleteModal(crop) {
    selectedCrop.value = crop;
    showDeleteModal.value = true;
}

// Delete the crop
const deleteCrop = async (crop) => {
    try {
        await axios.delete(`/crop/${crop.id}`); // Correct path
        showDeleteModal.value = false;

        // Optionally remove the crop from the local data
        const index = crops.findIndex((c) => c.id === crop.id);
        if (index !== -1) crops.splice(index, 1);

        toast("Crop deleted successfully!", {
            theme: "colored",
            type: "success",
            position: "top-center",
            hideProgressBar: true,
            transition: "zoom",
        });
    } catch (error) {
        toast("Error deleting crop!", {
            theme: "colored",
            type: "error",
            position: "top-center",
            hideProgressBar: true,
            transition: "zoom",
        });
        console.error("Error deleting crop:", error);
    }
};


// Open the edit modal for the selected crop and pre-fill form data
function openEditModal(crop) {
    selectedCrop.value = crop;
    editForm.value = {
        cultivar_id: crop.cultivar_id, // Set the saved cultivar ID here
        block_number: crop.block_number,
        planting_date: crop.planting_date,
        harvest_date: crop.harvest_date,
        location: crop.location,
        status: crop.status,
        size: crop.size,
    };
    showEditModal.value = true;
}


// Save edited crop
const editCrop = async (crop) => {
    try {
        await axios.put(`/crop/${crop.id}`, { 
            cultivar_id: editForm.value.cultivar_id,
            block_number: editForm.value.block_number,
            planting_date: editForm.value.planting_date,
            harvest_date: editForm.value.harvest_date,
            location: editForm.value.location,
            status: editForm.value.status,
            size: editForm.value.size,
        });

        showEditModal.value = false;

        // Optionally update the crop in the local data
        const index = crops.findIndex((c) => c.id === crop.id);
        if (index !== -1) {
            crops[index] = { ...crops[index], ...editForm.value };
        }

        toast("Crop updated successfully!", {
            theme: "colored",
            type: "success",
            position: "top-center",
            hideProgressBar: true,
            transition: "zoom",
        });
    } catch (error) {
        toast("Error updating crop!", {
            theme: "colored",
            type: "error",
            position: "top-center",
            hideProgressBar: true,
            transition: "zoom",
        });
        console.error("Error updating crop:", error);
    }
};

// Fetch cultivars on component mount
onMounted(() => {
    fetchCultivars();
});
</script>