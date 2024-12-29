<template>
    <AppLayout title="Fields">
        <!-- Header Section -->
        <div class="overflow-x-hidden overflow-y-auto">
            <div class="block md:flex items-center justify-between mb-4">
                <p class="text-sm mt-1 text-black font-medium">
                    <span class="font-bold">Total Fields:</span> {{ filteredFields.length }}
                    (Filtered from {{ fieldCount }})
                </p>
                <div class="mt-4 md:mt-0 flex items-center space-x-2 md:space-x-4">
                    <TextInput type="text" v-model="search" placeholder="Search" class="w-96" />
                    <div class="w-full md:w-fit">
                        <PrimaryButton @click="showCreateModal = true">Add Field</PrimaryButton>
                    </div>
                </div>
            </div>

            <!-- Create Modal -->
            <div v-if="showCreateModal" class="fixed z-50 inset-0 flex items-center justify-center">
                <div class="fixed inset-0 bg-black opacity-50"></div>
                <div class="relative bg-white rounded-lg p-6 w-full max-w-sm z-50">
                    <h3 class="text-lg font-semibold mb-4">Create New Field</h3>
                    <div class="mb-4">
                        <InputLabel value="Name" />
                        <TextInput
                            id="name"
                            type="text"
                            v-model="createForm.name"
                            class="mt-1 block w-full"
                            placeholder="Name"
                            required
                        />
                    </div>

                    <div class="mb-4">
                        <InputLabel value="Field Size" />
                        <p class="text-gray-400 text-[11px]">Field Size in Hectare</p>
                        <TextInput
                            id="size"
                            type="text"
                            v-model="createForm.size"
                            class="mt-1 block w-full"
                            placeholder="Feld Size"
                            required
                        />
                    </div>

                    <div class="mb-4">
                        <InputLabel value="Variety" />
                        <select
                            v-model="createForm.variety_id"
                            class="w-full text-xs mt-1 placeholder:text-xs border-gray-300 focus:ring-[#BCDA84] focus:border-[#BCDA84] rounded-lg"
                            required
                        >
                            <option value="" disabled>Select a Variety</option>
                            <option v-for="variety in varieties" :key="variety.id" :value="variety.id">
                                {{ variety.name }}
                            </option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <InputLabel value="Status" />
                        <select
                            v-model="createForm.status"
                            class="w-full text-xs mt-1 placeholder:text-xs border-gray-300 focus:ring-[#BCDA84] focus:border-[#BCDA84] rounded-lg"
                            required
                        >
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <InputLabel value="Planted At" />
                        <TextInput type="date" v-model="createForm.planted_at" class="mt-1 block w-full" required />
                    </div>

                    <div class="mt-6 text-gray-500 flex justify-end space-x-4">
                        <CancelButton @click="showCreateModal = false">Cancel</CancelButton>
                        <PrimaryButton @click="createField">Create</PrimaryButton>
                    </div>
                </div>
            </div>

            <!-- Data Table Section -->
            <div v-if="filteredFields.length > 0">
                <div class="rounded-lg overflow-x-auto">
                    <table class="min-w-full text-sm text-black">
                        <thead class="bg-white border-b-2 border-gray-200">
                            <tr>
                           <th class="px-6 py-4 text-left text-xs font-medium w-20">ID</th>
                           <th class="px-6 py-4 text-left text-xs font-medium w-36">Name</th>
                           <th class="px-6 py-4 text-left text-xs font-medium w-36">Variety</th>
                                <th class="px-6 py-4 text-left text-xs font-medium w-36">Type</th>
                           <th class="px-6 py-4 text-left text-xs font-medium w-36">Size (hectare)</th>
                           <th class="px-6 py-4 text-left text-xs font-medium w-36">Planted At</th>
                                <th class="px-6 py-4 text-left text-xs font-medium w-36">Status</th>
                           <th class="px-6 py-4 text-right text-xs font-medium w-28">Actions</th>
                       </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="field in filteredFields" :key="field.id">
                               <td class="px-6 py-2 text-xs text-gray-500 w-20">{{ field.id }}</td>
                               <td class="px-6 py-2 text-xs text-gray-500 w-36">{{ field.name }}</td>
                               <td class="px-6 py-2 text-xs text-gray-500 w-36">{{ field.variety.name || 'N/A' }}</td>
                                <td class="px-6 py-2 text-xs text-gray-500 w-36">{{ field.variety?.type?.name || 'N/A' }}</td> <!-- Type Name -->
                               <td class="px-6 py-2 text-xs text-gray-500 w-36">{{ field.size }}</td>

                                <td class="px-6 py-2 text-xs text-gray-500 w-36">{{ field.planted_at }}</td>
                                <td class="px-6 py-2 text-xs capitalize w-36">
                                    <span class="px-3 py-1 uppercase tracking-wide rounded-full text-xs font-medium" :class="statusBadgeClass(field.status)">
                                        {{ field.status }}
                                    </span>
                                </td>
                               <td class="px-6 py-2 text-xs text-gray-500 text-right w-28">
                                   <div class="flex items-center space-x-4 justify-end">
                                       <!-- Open Delete Confirmation Modal -->
                                       <PrimaryButton class="!w-fit cursor-not-allowed bg-gray-200 hover:bg-gray-300 text-gray-700 opacity-50">Delete</PrimaryButton>
                                       <!-- <PrimaryButton class="!z-10 !w-fit cursor-not-allowed bg-gray-200 hover:bg-gray-300 text-gray-700 opacity-50" @click="openDeleteModal(field)">Delete</PrimaryButton>-->

                                       <!-- Open Edit Modal -->
                                       <SecondaryButton class="!w-fit" @click.stop="openEditModal(field)">Edit</SecondaryButton>
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
                    <h3 class="text-lg font-semibold mb-4">Edit Field</h3>
                    <div class="mb-4">
                        <InputLabel value="Name" />
                        <TextInput
                            id="name"
                            type="text"
                            v-model="editForm.name"
                            class="mt-1 block w-full"
                            placeholder="Field Name"
                            required
                        />
                    </div>
                    <div class="mb-4">
                        <InputLabel value="Field Size" />
                        <p class="text-gray-400 text-[11px]">Field Size in Hectare</p>
                        <TextInput
                            id="size"
                            type="text"
                            v-model="editForm.size"
                            class="mt-1 block w-full"
                            placeholder="Feld Size"
                            required
                        />
                    </div>
                    <div class="mb-4">
                        <InputLabel value="Variety" />
                        <select
                            v-model="editForm.variety_id"
                            class="w-full text-xs mt-1 placeholder:text-xs border-gray-300 focus:ring-[#BCDA84] focus:border-[#BCDA84] rounded-lg"
                            required
                        >
                            <option value="" disabled>Select a Variety</option>
                            <option v-for="variety in varieties" :key="variety.id" :value="variety.id">
                                {{ variety.name }}
                            </option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <InputLabel value="Status" />
                        <select
                            v-model="editForm.status"
                            class="w-full text-xs mt-1 placeholder:text-xs border-gray-300 focus:ring-[#BCDA84] focus:border-[#BCDA84] rounded-lg"
                            required
                        >
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <InputLabel value="Planted At" />
                        <TextInput type="date" v-model="editForm.planted_at" class="mt-1 block w-full" required />
                    </div>
                    <div class="mt-6 text-gray-500 flex justify-end space-x-4">
                        <CancelButton @click="showEditModal = false">Cancel</CancelButton>
                        <PrimaryButton @click="editField()">Update</PrimaryButton>
                    </div>
                </div>
            </div>

            <!-- Delete Modal -->
            <div v-if="showDeleteModal" class="fixed z-50 inset-0 flex items-center justify-center">
                <div class="fixed inset-0 bg-black/40"></div>
                <div class="relative bg-white rounded-lg p-6 w-full max-w-sm z-50">
                    <h3 class="text-lg font-semibold mb-4">Confirm Delete</h3>
                    <p>Are you sure you want to delete this field?</p>
                    <div class="mt-6 flex justify-end space-x-4">
                        <CancelButton @click="showDeleteModal = false">Cancel</CancelButton>
                        <DangerButton @click="deleteField">Delete</DangerButton>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import CancelButton from "@/Components/CancelButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import {toast} from "vue3-toastify";

const { fields, fieldCount } = defineProps({
    fields: Array,
    fieldCount: Number,
});

const varieties = ref([]);
const search = ref("");
const showCreateModal = ref(false);
const showEditModal = ref(false);
const showDeleteModal = ref(false);
const selectedField = ref(null);
const createForm = ref({ name: "", size: "", variety_id: "", status: "active", planted_at: "" });
const editForm = ref({ id: null, name: "", size: "", variety_id: "", status: "", planted_at: "" });
const isLoading = ref(false);

const filteredFields = computed(() => {
    if (!Array.isArray(fields)) return [];
    if (!search.value) return fields;

    const searchValue = search.value.toLowerCase();
    return fields.filter((field) =>
        field.name.toLowerCase().includes(searchValue) ||
        field.size.toLowerCase().includes(searchValue) ||
        field.status.toLowerCase().includes(searchValue)
    );
});

const createField = async () => {
    if (isLoading.value) return;
    isLoading.value = true;

    try {
        const response = await axios.post('/fields/store', createForm.value);

        toast("Record created successfully!", {
            theme: "colored",
            type: "success",
            position: "top-center",
            hideProgressBar: true,
            transition: "zoom",
        });

        window.location.reload();
    } catch (error) {
        console.error("Error creating field:", error);

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

const openEditModal = (field) => {
    Object.assign(editForm.value, field);
    showEditModal.value = true;
};

const editField = async () => {
    if (isLoading.value) return;
    isLoading.value = true;

    try {
        const response = await axios.patch(`/fields/${editForm.value.id}`, editForm.value);

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
        console.error("Error updating field:", error);

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

const openDeleteModal = (field) => {
    selectedField.value = field;
    showDeleteModal.value = true;
};

const deleteField = async () => {
    if (!selectedField.value || isLoading.value) return;
    isLoading.value = true;

    try {
        await axios.delete(`/varieties/${selectedField.value.id}`);

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
        console.error("Error deleting field:", error);

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

const fetchVarieties = async () => {
    try {
        const response = await axios.get("/api/varieties");
        varieties.value = response.data.varieties;
    } catch (error) {
        console.error("Error fetching varieties:", error);
    }
};

const statusBadgeClass = (status) => {
    switch (status) {
        case "active":
            return "bg-green-100 text-green-600";
        case "inactive":
            return "bg-red-100 text-red-600";
        default:
            return "bg-gray-100 text-gray-600";
    }
};

onMounted(fetchVarieties);
</script>
