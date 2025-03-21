<template>
    <AppLayout title="Storerooms">
        <!-- Header Section -->
        <div class="overflow-x-hidden overflow-y-auto">
            <div class="block md:flex items-center justify-between mb-4">
                <p class="text-sm mt-1 text-black font-medium">
                    <span class="font-bold">Total Storerooms:</span> {{ filteredStorerooms.length }}
                    (Filtered from {{ storeroomCount }})
                </p>
                <div class="mt-4 md:mt-0 flex items-center space-x-2 md:space-x-4">
                    <TextInput type="text" v-model="search" placeholder="Search" class="w-96" />
                    <div class="w-full md:w-fit">
                        <PrimaryButton @click="showCreateModal = true">Create</PrimaryButton>
                    </div>
                </div>
            </div>

            <!-- Create Modal -->
            <div v-if="showCreateModal" class="fixed z-50 inset-0 flex items-center justify-center">
                <div class="fixed inset-0 bg-black opacity-50"></div>
                <div class="relative bg-white rounded-lg p-6 w-full max-w-sm z-50">
                    <h3 class="text-lg font-semibold mb-4">Create New Storeroom</h3>

                    <div class="mb-4">
                        <InputLabel value="Name" />
                        <TextInput
                            id="edit-name"
                            type="text"
                            v-model="createForm.name"
                            class="mt-1 block w-full"
                            placeholder="Name"
                            required
                        />
                    </div>

                    <div class="mb-4">
                        <InputLabel value="Country" />
                        <TextInput
                            id="edit-country"
                            type="text"
                            v-model="createForm.country"
                            class="mt-1 block w-full"
                            placeholder="Country"
                        />
                    </div>

                    <div class="flex items-center space-x-4 mb-4">
                        <div class="w-full">
                            <InputLabel value="City" />
                            <TextInput
                                id="edit-city"
                                type="text"
                                v-model="createForm.city"
                                class="mt-1 block w-full"
                                placeholder="City"
                            />
                        </div>

                        <div class="w-full">
                            <InputLabel value="State" />
                            <TextInput
                                id="edit-state"
                                type="text"
                                v-model="createForm.state"
                                class="mt-1 block w-full"
                                placeholder="State"
                            />
                        </div>
                    </div>

                    <div class="mb-4">
                        <InputLabel value="Zip Code" />
                        <TextInput
                            id="edit-zip_code"
                            type="text"
                            v-model="createForm.zip_code"
                            class="mt-1 block w-full"
                            placeholder="Zip Code"
                        />
                    </div>

                    <div class="mb-4">
                        <InputLabel value="Status" />
                        <select
                            id="edit-status"
                            v-model="createForm.status"
                            class="w-full text-xs mt-1 placeholder:text-xs border-gray-300 focus:ring-[#BCDA84] focus:border-[#BCDA84] rounded-lg"
                        >
                            <option value="active">Active</option>
                            <option value="suspended">Suspended</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <InputLabel for="is-default" value="Default Storeroom" />
                        <select
                            id="is-default"
                            v-model="createForm.is_default"
                            class="w-full text-xs mt-1 placeholder:text-xs border-gray-300 focus:ring-[#BCDA84] focus:border-[#BCDA84] rounded-lg"
                        >
                            <option :value="true">Yes (Default Storeroom)</option>
                            <option :value="false">No (Additional Storeroom)</option>
                        </select>
                    </div>

                    <div class="mt-6 text-gray-500 flex justify-end space-x-4">
                        <CancelButton @click="showCreateModal = false">Cancel</CancelButton>
                        <PrimaryButton @click="createStoreroom()">Create</PrimaryButton>
                    </div>
                </div>
            </div>

            <!-- Data Table Section -->
            <div v-if="filteredStorerooms.length > 0">
                <div class="rounded-lg overflow-x-auto">
                    <table class="min-w-full text-sm text-black table-fixed">
                        <thead class="bg-white border-b-2 border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium w-20">ID</th>
                            <th class="px-6 py-4 text-left text-xs font-medium w-44">Name</th>
                            <th class="px-6 py-4 text-left text-xs font-medium w-72">Location</th>
                            <th class="px-6 py-4 text-left text-xs font-medium w-36">Default</th>
                            <th class="px-6 py-4 text-left text-xs font-medium w-20">Status</th>
                            <th class="px-6 py-4 text-right text-xs font-medium w-28">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="storeroom in filteredStorerooms" :key="storeroom.id">
                            <td class="px-6 py-2 text-xs text-gray-500 w-20">{{ storeroom.id }}</td>
                            <td class="px-6 py-2 text-xs text-gray-500 w-44 whitespace-nowrap">
                                <a
                                    :href="`/storerooms/${storeroom.id}/dashboard`"
                                    class="text-blue-500 hover:underline"
                                >
                                    {{ storeroom.name }}
                                </a>
                            </td>
                            <td class="px-6 py-2 text-xs text-gray-500 w-72 whitespace-nowrap">
                                {{ storeroom.country || storeroom.state || storeroom.city || storeroom.zip_code
                                ? `${storeroom.country || ''}, ${storeroom.state || ''}, ${storeroom.city || ''}, ${storeroom.zip_code || ''}`.replace(/(,\s)+$/, '')
                                : 'N/A' }}
                            </td>
                            <td class="px-6 py-2 text-xs text-gray-500 w-36">
                                {{ getStoreroomType(storeroom.is_default) }}
                            </td>
                            <td class="px-6 py-2 text-xs capitalize w-20">
                        <span class="px-3 py-1 uppercase tracking-wide rounded-full text-xs font-medium"
                              :class="statusBadgeClass(storeroom.status)">
                            {{ storeroom.status }}
                        </span>
                            </td>
                            <td class="px-6 py-2 text-xs text-gray-500 text-right w-28">
                                <div class="flex items-center space-x-4 justify-end">
                                    <PrimaryButton class="!w-fit cursor-not-allowed bg-gray-200 hover:bg-gray-300 text-gray-700 opacity-50">Delete</PrimaryButton>
                                    <SecondaryButton class="!w-fit" @click.stop="openEditModal(storeroom)">Edit</SecondaryButton>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- No Types Found -->
            <div v-else class="flex flex-col items-center justify-center py-10">
                <div class="text-gray-500 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-28">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                    </svg>
                </div>

                <p class="text-gray-500 text-lg font-semibold">No Records Found</p>
                <p class="text-gray-400 text-sm">Try adjusting your search or adding new records.</p>
            </div>

            <!-- Edit Modal -->
            <div v-if="showEditModal" class="fixed z-50 inset-0 flex items-center justify-center">
                <div class="fixed inset-0 bg-black opacity-50"></div>
                <div class="relative bg-white rounded-lg p-6 w-full max-w-sm z-50">
                    <h3 class="text-lg font-semibold mb-4">Edit Storeroom</h3>

                    <div class="mb-4">
                        <InputLabel value="Name" />
                        <TextInput
                            id="edit-name"
                            type="text"
                            v-model="editForm.name"
                            class="mt-1 block w-full"
                            placeholder="Name"
                            required
                        />
                    </div>

                    <div class="mb-4">
                        <InputLabel value="Country" />
                        <TextInput
                            id="edit-country"
                            type="text"
                            v-model="editForm.country"
                            class="mt-1 block w-full"
                            placeholder="Country"
                        />
                    </div>

                    <div class="flex items-center space-x-4 mb-4">
                        <div class="w-full">
                            <InputLabel value="City" />
                            <TextInput
                                id="edit-city"
                                type="text"
                                v-model="editForm.city"
                                class="mt-1 block w-full"
                                placeholder="City"
                            />
                        </div>

                        <div class="w-full">
                            <InputLabel value="State" />
                            <TextInput
                                id="edit-state"
                                type="text"
                                v-model="editForm.state"
                                class="mt-1 block w-full"
                                placeholder="State"
                            />
                        </div>
                    </div>

                    <div class="mb-4">
                        <InputLabel value="Zip Code" />
                        <TextInput
                            id="edit-zip_code"
                            type="text"
                            v-model="editForm.zip_code"
                            class="mt-1 block w-full"
                            placeholder="Zip Code"
                        />
                    </div>

                    <div class="mb-4">
                        <InputLabel value="Status" />
                        <select
                            id="edit-status"
                            v-model="editForm.status"
                            class="w-full text-xs mt-1 placeholder:text-xs border-gray-300 focus:ring-[#BCDA84] focus:border-[#BCDA84] rounded-lg"
                        >
                            <option value="active">Active</option>
                            <option value="suspended">Suspended</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <InputLabel for="is-default" value="Default Storeroom" />
                        <select
                            id="is-default"
                            v-model="editForm.is_default"
                            class="w-full text-xs mt-1 placeholder:text-xs border-gray-300 focus:ring-[#BCDA84] focus:border-[#BCDA84] rounded-lg"
                        >
                            <option :value="true">Yes (Default Storeroom)</option>
                            <option :value="false">No (Additional Storeroom)</option>
                        </select>
                    </div>

                    <div class="mt-6 text-gray-500 flex justify-end space-x-4">
                        <CancelButton @click="showEditModal = false">Cancel</CancelButton>
                        <PrimaryButton @click="editStoreroom()">Update</PrimaryButton>
                    </div>
                </div>
            </div>

            <!-- Delete Modal -->
            <div v-if="showDeleteModal" class="fixed z-50 inset-0 flex items-center justify-center">
                <div class="fixed inset-0 bg-black/40"></div>
                <div class="relative bg-white rounded-lg p-6 w-full max-w-sm z-50">
                    <h3 class="text-lg font-semibold mb-4">Confirm Delete</h3>
                    <p>Are you sure you want to delete this storeroom?</p>
                    <div class="mt-6 flex justify-end space-x-4">
                        <CancelButton @click="showDeleteModal = false">Cancel</CancelButton>
                        <DangerButton @click="deleteStoreroom()">Delete</DangerButton>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import CancelButton from "@/Components/CancelButton.vue";
import { ref, computed } from "vue";
import axios from "axios";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import {toast} from "vue3-toastify";
import DangerButton from "@/Components/DangerButton.vue";

const { storerooms, storeroomCount } = defineProps({
    storerooms: Array,
    storeroomCount: Number,
});

const search = ref("");
const showCreateModal = ref(false);
const showEditModal = ref(false);
const showDeleteModal = ref(false);
const isLoading = ref(false);

const filteredStorerooms = computed(() => {
    if (!Array.isArray(storerooms)) return [];
    if (!search.value) return storerooms;

    const searchValue = search.value.toLowerCase();
    return storerooms.filter((storeroom) =>
        storeroom.name.toLowerCase().includes(searchValue) ||
        storeroom.status.toLowerCase().includes(searchValue)
    );
});

const statusBadgeClass = (status) => {
    switch (status) {
        case "active":
            return "bg-green-100 text-green-600";
        case "inactive":
            return "bg-red-100 text-red-600";
        case "suspended":
            return "bg-blue-100 text-blue-600";
        default:
            return "bg-gray-100 text-gray-600";
    }
};

const getStoreroomType = (isDefault) => {
    return isDefault ? 'Yes' : 'No';
};

const createForm = ref({
    name: "",
    country: "",
    city: "",
    state: "",
    zip_code: "",
    status: "",
    is_default: false,
});

const createStoreroom = async () => {
    if (isLoading.value) return;
    isLoading.value = true;

    try {
        const response = await axios.post('/storerooms/store', createForm.value);

        toast("Record created successfully!", {
            theme: "colored",
            type: "success",
            position: "top-center",
            hideProgressBar: true,
            transition: "zoom",
        });

        showCreateModal.value = false;

        window.location.reload();
    } catch (error) {
        console.error(`Error creating storeroom:`, error);

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

const editForm = ref({
    id: null,
    name: "",
    country: "",
    city: "",
    state: "",
    zip_code: "",
    status: "",
    is_default: false,
});

const openEditModal = (storeroom) => {
    console.log("Opening Edit Modal with storeroom:", storeroom); // Log the storeroom data

    editForm.value = {
        ...storeroom,
        is_default: Boolean(storeroom.is_default), // Ensure the is_default value is a boolean
    };

    console.log("Populated editForm:", editForm.value); // Log the editForm after populating it
    showEditModal.value = true; // Show the modal
};

const editStoreroom = async () => {
    if (isLoading.value) return;
    isLoading.value = true;

    try {
        const response = await axios.patch(`/storerooms/${editForm.value.id}`, editForm.value);

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
        console.error(`Error updating storeroom:`, error);

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

const deleteStoreroom = async () => {
    if (isLoading.value) return;
    isLoading.value = true;

    try {
        const response = await axios.delete(`/storerooms/${editForm.value.id}`);

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
        console.error(`Error deleting storeroom:`, error);

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
</script>
