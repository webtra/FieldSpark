<template>
    <AppLayout title="User">
        <div class="overflow-x-hidden overflow-y-auto">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-base font-semibold leading-6 text-gray-900">User Management</h1>
                    <p class="mt-2 text-gray-500">Total Users: {{ filteredUsers.length }} (Filtered from {{
                        usersCount }})
                    </p>
                </div>

                <div class="flex items-center space-x-4">
                    <!-- Search Bar -->
                    <TextInput type="text" v-model="searchTerm" placeholder="Search User..." class="w-96" />

                    <div>
                        <PrimaryButton>
                            Create User
                        </PrimaryButton>
                    </div>
                </div>
            </div>

            <!-- Table of Users -->
            <div class="mt-4" v-if="filteredUsers && filteredUsers.length > 0">
                <div class="border border-gray-300 rounded-md overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="text-black bg-white">
                            <tr>
                                <th class="px-8 py-4 text-left text-xs font-medium uppercase tracking-wider">
                                    ID
                                </th>
                                <th class="px-8 py-4 text-left text-xs font-medium uppercase tracking-wider">
                                    First Name
                                </th>
                                <th class="px-8 py-4 text-left text-xs font-medium uppercase tracking-wider">
                                    Last Name
                                </th>
                                <th class="px-8 py-4 text-left text-xs font-medium uppercase tracking-wider">
                                    Email Address
                                </th>
                                <th class="px-8 py-4 text-left text-xs font-medium uppercase tracking-wider">
                                    Email Verified
                                </th>
                                <th class="px-8 py-4 text-left text-xs font-medium uppercase tracking-wider">
                                    Created At
                                </th>
                                <th class="px-8 py-4 text-left text-xs font-medium uppercase tracking-wider">
                                    Role
                                </th>
                                <th class="px-8 py-4 text-left text-xs font-medium uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="user in filteredUsers" :key="user.id" class="odd:bg-white even:bg-gray-50">
                                <td class="px-8 py-2 whitespace-nowrap text-xs text-gray-500">{{ user.id
                                    }}</td>
                                <td class="px-8 py-2 whitespace-nowrap text-xs text-gray-500">{{ user.first_name
                                    }}</td>
                                <td class="px-8 py-2 whitespace-nowrap text-xs text-gray-500">{{ user.last_name }}
                                </td>
                                <td class="px-8 py-2 whitespace-nowrap text-xs text-gray-500">{{ user.email }}
                                </td>
                                <td class="px-8 py-2 whitespace-nowrap text-xs text-gray-500">
                                    <span v-if="user.email_verified_at">
                                        {{ new Date(user.email_verified_at).toLocaleDateString('en-GB', {
                                            day:
                                                '2-digit', month: 'long', year: 'numeric'
                                        }) }}
                                    </span>
                                </td>
                                <td class="px-8 py-2 whitespace-nowrap text-xs text-gray-500">
                                    <span v-if="user.created_at">
                                        {{ new Date(user.created_at).toLocaleDateString('en-GB', {
                                            day:
                                                '2-digit', month: 'long', year: 'numeric'
                                        }) }}
                                    </span>
                                </td>
                                <td class="px-8 py-2 whitespace-nowrap text-xs text-gray-500">
                                    <select v-model="user.role_id" @change="updateUserRole(user)"
                                        class="px-4 py-2 border border-gray-300 rounded text-xs w-full">
                                        <option value="1">Admin</option>
                                        <option value="2">Staff</option>
                                        <option value="3">Viewer</option>
                                    </select>
                                </td>
                                <td
                                    class="px-8 py-2 whitespace-nowrap text-xs text-gray-500 space-x-4 flex items-center">
                                    <!-- delete button -->
                                    <div class="mt-2">
                                        <!-- Delete Button -->
                                        <button class="underline" @click="showDeleteModal = true">Delete</button>

                                        <!-- Confirmation Modal -->
                                        <div v-if="showDeleteModal"
                                            class="fixed z-50 inset-0 flex items-center justify-center">
                                            <!-- Black overlay (backdrop) -->
                                            <div class="fixed inset-0 bg-black opacity-50"></div>

                                            <!-- Modal content -->
                                            <div class="relative bg-white rounded p-6 w-full max-w-sm z-50">
                                                <h3 class="text-lg font-semibold mb-4">Confirm Delete</h3>
                                                <p>Are you sure you want to delete <span class="font-semibold">{{
                                                    user.first_name
                                                        }} {{ user.last_name
                                                        }}</span>?</p>

                                                <div class="mt-6 flex justify-end space-x-4">
                                                    <button class="px-4 py-2 bg-gray-300 rounded"
                                                        @click="showDeleteModal = false">Cancel</button>
                                                    <button class="px-4 py-2 bg-red-600 text-white rounded"
                                                        @click="deleteUser">Continue</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <button class="underline">Edit</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- If no users found -->
            <div v-else>
                <p>No users found</p>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import axios from 'axios';
import AppLayout from '@/Layouts/AppLayout.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

// Props received from the controller
const { users, usersCount } = defineProps({
    users: Array,
    usersCount: Number,
});

// Reactive search term
const searchTerm = ref('');

// Computed property to filter users based on the search term
const filteredUsers = computed(() => {
    if (!searchTerm.value) return users;

    return users.filter((user) => {
        return (
            user.first_name.toLowerCase().includes(searchTerm.value.toLowerCase()) ||
            user.last_name.toLowerCase().includes(searchTerm.value.toLowerCase()) ||
            user.email.toLowerCase().includes(searchTerm.value.toLowerCase())
        );
    });
});

const updateUserRole = async (user) => {
    try {
        const response = await axios.put(`/users/${user.id}/role`, { role_id: user.role_id });

        console.log('Role updated successfully', response.data);
    } catch (error) {

        console.error('Error updating role:', error);
    }
};

// State for modal visibility
const showDeleteModal = ref(false);

// Method to delete the user
const deleteUser = async (user) => {
  try {
    const response = await axios.put(`/users/${user.id}`);

    showDeleteModal.value = false;

    console.log('Deleted Successfully', response.data)
    window.location.reload();
  } catch (error) {
    console.error('Error deleting user:', error); 
  }
};
</script>
