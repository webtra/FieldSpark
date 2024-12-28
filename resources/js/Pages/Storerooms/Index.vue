<template>
    <AppLayout title="Storerooms">
        <!-- Header Section -->
        <div class="overflow-x-hidden overflow-y-auto">
            <div class="block md:flex items-center justify-between mb-4">
                <p class="text-sm mt-1 text-black font-medium">
                    <span class="font-bold">Total Fields:</span> {{ filteredStorerooms.length }}
                    (Filtered from {{ storeroomCount }})
                </p>
                <div class="mt-4 md:mt-0 flex items-center space-x-2 md:space-x-4">
                    <TextInput type="text" v-model="search" placeholder="Search" class="w-96" />
                    <div class="w-full md:w-fit">
                        <PrimaryButton @click="showCreateModal = true">Create Storeroom</PrimaryButton>
                    </div>
                </div>
            </div>

            <!-- Create Modal -->
            <div v-if="showCreateModal" class="fixed z-50 inset-0 flex items-center justify-center">
                <div class="fixed inset-0 bg-black opacity-50"></div>
                <div class="relative bg-white rounded-lg p-6 w-full max-w-md z-50">
                    <h3 class="text-lg font-semibold mb-4">Create New Storeroom</h3>

                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-md">
                        <p>
                            <strong>Note:</strong> You will not be able to create additional storerooms at this time.
                            This feature is currently disabled.
                        </p>
                    </div>

                    <div class="mt-6 text-gray-500 flex justify-end space-x-4">
                        <CancelButton @click="showCreateModal = false">Cancel</CancelButton>
                        <PrimaryButton @click="createStoreroom" class="cursor-not-allowed bg-gray-200 hover:bg-gray-300 text-gray-700 opacity-50">Create</PrimaryButton>
                    </div>
                </div>
            </div>

            <!-- Data Table Section -->
            <div v-if="filteredStorerooms.length > 0">
                <div class="rounded-lg overflow-x-auto">
                    <table class="min-w-full text-sm text-black">
                        <thead class="bg-white border-b-2 border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium w-20">ID</th>
                            <th class="px-6 py-4 text-left text-xs font-medium w-36">Name</th>
                            <th class="px-6 py-4 text-left text-xs font-medium w-72">Location</th>
                            <th class="px-6 py-4 text-left text-xs font-medium w-36">Default</th>
                            <th class="px-6 py-4 text-left text-xs font-medium w-20">Status</th>
                            <th class="px-6 py-4 text-right text-xs font-medium w-28">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="storeroom in filteredStorerooms" :key="storeroom.id">
                            <td class="px-6 py-2 text-xs text-gray-500 w-20">{{ storeroom.id }}</td>
                            <td class="px-6 py-2 text-xs text-gray-500 w-36">{{ storeroom.name }}</td>
                            <td class="px-6 py-2 text-xs text-gray-500 w-72">
                                {{ storeroom.country || storeroom.state || storeroom.city || storeroom.zip_code ?
                                `${storeroom.country || ''}, ${storeroom.state || ''}, ${storeroom.city || ''}, ${storeroom.zip_code || ''}`.replace(/(,\s)+$/, '') : 'N/A' }}
                            </td>
                            <td class="px-6 py-2 text-xs text-gray-500 w-36">
                                {{ getStoreroomType(storeroom.is_default) }}
                            </td>
                            <td class="px-6 py-2 text-xs capitalize w-20">
                                    <span class="px-3 py-1 uppercase tracking-wide rounded-full text-xs font-medium" :class="statusBadgeClass(storeroom.status)">
                                        {{ storeroom.status }}
                                    </span>
                            </td>
                            <td class="px-6 py-2 text-xs text-gray-500 text-right w-28">
                                <div class="flex items-center space-x-4 justify-end">
                                    <!-- Open Delete Confirmation Modal -->
                                    <PrimaryButton class="!w-fit cursor-not-allowed bg-gray-200 hover:bg-gray-300 text-gray-700 opacity-50">Delete</PrimaryButton>
                                    <!-- <PrimaryButton class="!z-10 !w-fit cursor-not-allowed bg-gray-200 hover:bg-gray-300 text-gray-700 opacity-50" @click="openDeleteModal(storeroom)">Delete</PrimaryButton>-->

                                    <!-- Open Edit Modal -->
                                    <SecondaryButton class="!w-fit" @click.stop="openEditModal(storeroom)">Edit</SecondaryButton>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- No Types Found -->
            <div v-else>
                <p>No fields found</p>
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

                    <div class="mt-6 text-gray-500 flex justify-end space-x-4">
                        <CancelButton @click="showEditModal = false">Cancel</CancelButton>
                        <PrimaryButton @click="editStoreroom()">Update</PrimaryButton>
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

const { storerooms, storeroomCount } = defineProps({
    storerooms: Array,
    storeroomCount: Number,
});

const search = ref("");
const showCreateModal = ref(false);
const showEditModal = ref(false);
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
    return isDefault ? 'Default Storeroom' : 'Additional Storeroom';
};

const editForm = ref({
    id: null,
    name: "",
    country: "",
    city: "",
    state: "",
    zip_code: "",
    status: "active",
});

const openEditModal = (storeroom) => {
    editForm.value = { ...storeroom };
    showEditModal.value = true;
};

const editStoreroom = async () => {
    if (isLoading.value) return;
    isLoading.value = true;

    try {
        const response = await axios.patch(`/storerooms/${editForm.value.id}`, editForm.value);

        toast("Storeroom updated successfully!", {
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

        toast("Error updating storeroom!", {
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
