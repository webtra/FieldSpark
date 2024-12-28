<template>
    <AppLayout title="Types">

        <!-- Header Section -->
        <div class="overflow-x-hidden overflow-y-auto">
            <div class="block md:flex items-center justify-between mb-4">
                <p class="text-sm mt-1 text-black font-medium">
                    <span class="font-bold">Total Types:</span> {{ filteredTypes.length }}
                    (Filtered from {{ typeCount }})
                </p>

                <div class="mt-4 md:mt-0 flex items-center space-x-2 md:space-x-4">
                    <!-- Search Bar -->
                    <TextInput type="text" v-model="search" placeholder="Search" class="w-96" />

                    <div class="w-full md:w-fit">
                        <PrimaryButton @click="showCreateModal = true">
                            Create Type
                        </PrimaryButton>
                    </div>
                </div>
            </div>

            <!-- Create Modal -->
            <div v-if="showCreateModal" class="fixed z-50 inset-0 flex items-center justify-center">
                <div class="fixed inset-0 bg-black opacity-50"></div>
                <div class="relative bg-white rounded-lg p-6 w-full max-w-sm z-50">
                    <h3 class="text-lg font-semibold mb-4">Create New Type</h3>

                    <div class="mb-4">
                        <InputLabel for="name" value="Name" />
                        <TextInput id="name" type="text" v-model="createForm.name"
                                   class="mt-1 block w-full" placeholder="Name" />
                    </div>

                    <div class="mb-4">
                        <InputLabel for="description" value="Description" />
                        <TextInput id="description" type="text" v-model="createForm.description"
                                   class="mt-1 block w-full" placeholder="Description" />
                    </div>

                    <div class="mt-6 text-gray-500 flex justify-end space-x-4">
                        <CancelButton @click="showCreateModal = false">Cancel</CancelButton>
                        <PrimaryButton @click="create">Create</PrimaryButton>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Table Section -->
        <div v-if="filteredTypes.length > 0">
            <div class="rounded-lg overflow-x-auto overflow-y-hidden z-10">
                <table class="min-w-full text-sm text-black">
                    <thead class="bg-white border-b-2 border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-medium w-16">ID</th>
                        <th class="px-6 py-4 text-left text-xs font-medium w-48">Name</th>
                        <th class="px-6 py-4 text-left text-xs font-medium w-96">Description</th>
                        <th class="px-6 py-4 text-right text-xs font-medium w-28">Actions</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="type in filteredTypes" :key="type.id">
                        <td class="px-6 py-2 text-xs text-gray-500 w-16">{{ type.id }}</td>
                        <td class="px-6 py-2 text-xs text-gray-500 w-48">{{ type.name }}</td>
                        <td class="px-6 py-2 text-xs text-gray-500 w-96">{{ type.description }}</td>
                        <td class="px-6 py-2 text-xs text-gray-500 text-right w-28 z-10">
                            <div class="flex items-center space-x-4 justify-end">
                                <!-- Open Delete Confirmation Modal -->
                                <PrimaryButton class="!w-fit cursor-not-allowed bg-gray-200 hover:bg-gray-300 text-gray-700 opacity-50">Delete</PrimaryButton>
<!--                            <PrimaryButton class="!z-10 !w-fit cursor-not-allowed bg-gray-200 hover:bg-gray-300 text-gray-700 opacity-50" @click="openDeleteModal(type)">Delete</PrimaryButton>-->

                                <!-- Open Edit Modal -->
                                <SecondaryButton class="!w-fit" @click="openEditModal(type)">Edit</SecondaryButton>
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
                <p>Are you sure you want to delete this type?</p>

                <div class="mt-6 flex justify-end space-x-4">
                    <CancelButton @click="showDeleteModal = false">Cancel</CancelButton>
                    <DangerButton @click="deleteType()">Delete</DangerButton>
                </div>
            </div>
        </div>

        <!-- Edit Modal -->
        <div v-if="showEditModal" class="fixed z-50 inset-0 flex items-center justify-center">
            <div class="fixed inset-0 bg-black/40"></div>
            <div class="relative bg-white rounded-lg p-6 w-full max-w-sm z-50">
                <h3 class="text-black text-lg font-semibold mb-4">Edit Type</h3>

                <div class="mb-4">
                    <InputLabel for="name" value="Name" />
                    <TextInput id="name" type="text" v-model="editForm.name"
                               class="mt-1 block w-full" placeholder="Name" />
                </div>

                <div class="mb-4">
                    <InputLabel for="description" value="Description" />
                    <TextInput id="description" type="text" v-model="editForm.description"
                               class="mt-1 block w-full" placeholder="Description" />
                </div>

                <div class="mt-6 flex justify-end space-x-4">
                    <CancelButton @click="showEditModal = false">Cancel</CancelButton>
                    <PrimaryButton @click="editType()">Update</PrimaryButton>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { toast } from 'vue3-toastify';
import { ref, computed } from 'vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import CancelButton from '@/Components/CancelButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import DangerButton from "@/Components/DangerButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

const { types, typeCount } = defineProps({
    types: Array,
    typeCount: Number,
});

const search = ref('');
const showCreateModal = ref(false);
const showDeleteModal = ref(false);
const selectedType = ref(null);
const showEditModal = ref(false);
const isLoading = ref(false);

const filteredTypes = computed(() => {
    if (!Array.isArray(types)) return [];
    if (!search.value) return types;

    const searchValue = search.value.toLowerCase();
    return types.filter((type) =>
        type.name.toLowerCase().includes(searchValue) ||
        type.description.toLowerCase().includes(searchValue)
    );
});

const createForm = ref({
    name: '',
    description: '',
});

const create = async () => {
    if (isLoading.value) return;
    isLoading.value = true;

    try {
        const response = await axios.post('/types/store', {
            name: createForm.value.name,
            description: createForm.value.description,
        });

        types.push(response.data);
        showCreateModal.value = false;
        createForm.value.name = '';
        createForm.value.description = '';

        toast("Record created successfully!", {
            theme: "colored",
            type: "success",
            position: "top-center",
            hideProgressBar: true,
            transition: "zoom",
        });

        window.location.reload();
    } catch (error) {
        console.error("Error creating type:", error);

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

const openDeleteModal = (type) => {
    selectedType.value = type;
    showDeleteModal.value = true;
};

const deleteType = async () => {
    if (!selectedType.value || isLoading.value) return;
    isLoading.value = true;

    try {
        await axios.delete(`/types/${selectedType.value.id}`);
        const index = types.findIndex(type => type.id === selectedType.value.id);
        if (index !== -1) types.splice(index, 1);

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
        console.error("Error deleting type:", error);

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
    name: '',
    description: '',
});

const openEditModal = (type) => {
    editForm.value.id = type.id;
    editForm.value.name = type.name;
    editForm.value.description = type.description;
    showEditModal.value = true;
};

const editType = async () => {
    if (isLoading.value) return;
    isLoading.value = true;

    try {
        const response = await axios.patch(`/types/${editForm.value.id}`, {
            name: editForm.value.name,
            description: editForm.value.description,
        });

        const index = types.findIndex(type => type.id === editForm.value.id);
        if (index !== -1) types[index] = response.data;

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
        console.error("Error updating type:", error);

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
</script>
