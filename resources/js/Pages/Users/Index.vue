<template>
    <AppLayout title="User">
        <div class="overflow-x-hidden overflow-y-auto">
            <div class="block md:flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-base font-semibold leading-6 text-gray-900">User Management</h1>
                    <p class="mt-1 text-gray-500">Total Users: {{ filteredUsers.length }} (Filtered from {{
                        usersCount }})
                    </p>
                </div>

                <div class="text-gray-500 mt-4 md:mt-0 flex items-center space-x-2 md:space-x-4">
                    <!-- Search Bar -->
                    <TextInput type="text" v-model="searchTerm" placeholder="Search User..." class="w-96" />

                    <div class="w-full md:w-fit">
                        <PrimaryButton @click="showCreateUserModal = true">
                            Create User
                        </PrimaryButton>
                    </div>
                </div>
            </div>

            <!-- Modal for Creating a New User -->
            <div v-if="showCreateUserModal" class="fixed z-50 inset-0 flex items-center justify-center">
                <!-- Black overlay (backdrop) -->
                <div class="fixed inset-0 bg-black opacity-50"></div>

                <!-- Modal content -->
                <div class="relative bg-white rounded p-6 w-full max-w-sm z-50">
                    <h3 class="text-lg font-semibold mb-4">Create New User</h3>

                    <div class="flex space-x-2">
                        <div class="mb-4">
                            <InputLabel for="first_name" value="First Name" />
                            <TextInput id="first_name" type="text" v-model="newUser.first_name"
                                class="mt-1 block w-full" placeholder="First Name" />
                            <InputError :message="errors.first_name" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <InputLabel for="last_name" value="Last Name" />
                            <TextInput id="last_name" type="text" v-model="newUser.last_name" class="mt-1 block w-full"
                                placeholder="Last Name" />
                            <InputError :message="errors.last_name" class="mt-2" />
                        </div>
                    </div>

                    <div class="mb-4">
                        <InputLabel for="email" value="Email Address" />
                        <TextInput id="email" type="email" v-model="newUser.email" class="mt-1 block w-full"
                            placeholder="Email Address" />
                        <InputError :message="errors.email" class="mt-2" />
                    </div>

                    <div class="mt-6 flex justify-end space-x-4">
                        <CancelButton @click="showCreateUserModal = false">Cancel</CancelButton>
                        <PrimaryButton @click="createUser">Create</PrimaryButton>
                    </div>
                </div>
            </div>

            <!-- Table of Users -->
            <div class="mt-4" v-if="paginatedUsers && paginatedUsers.length > 0">
                <div class="border border-gray-300 rounded-md overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="text-black bg-white">
                            <tr>
                                <th class="px-4 py-4 text-left text-xs font-medium uppercase tracking-wider w-24">ID
                                </th>
                                <th class="px-4 py-4 text-left text-xs font-medium uppercase tracking-wider w-48">First
                                    Name</th>
                                <th class="px-4 py-4 text-left text-xs font-medium uppercase tracking-wider w-48">Last
                                    Name</th>
                                <th class="px-4 py-4 text-left text-xs font-medium uppercase tracking-wider w-64">Email
                                    Address</th>
                                <th class="px-4 py-4 text-left text-xs font-medium uppercase tracking-wider w-36">Email
                                    Verified</th>
                                <th class="px-4 py-4 text-left text-xs font-medium uppercase tracking-wider w-36">
                                    Created At</th>
                                <th class="px-4 py-4 text-left text-xs font-medium uppercase tracking-wider w-36">Role
                                </th>
                                <th class="px-4 py-4 text-left text-xs font-medium uppercase tracking-wider w-28">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="user in filteredUsers" :key="user.id" class="odd:bg-white even:bg-gray-50">
                                <td class="px-4 py-2 whitespace-nowrap text-xs text-gray-500">{{ user.id
                                    }}</td>
                                <td class="px-4 py-2 whitespace-nowrap text-xs text-gray-500">{{ user.first_name
                                    }}</td>
                                <td class="px-4 py-2 whitespace-nowrap text-xs text-gray-500">{{ user.last_name }}
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap text-xs text-gray-500">{{ user.email }}
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap text-xs text-gray-500">
                                    <span v-if="user.email_verified_at">
                                        {{ new Date(user.email_verified_at).toLocaleDateString('en-GB', {
                                            day:
                                                '2-digit', month: 'long', year: 'numeric'
                                        }) }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap text-xs text-gray-500">
                                    <span v-if="user.created_at">
                                        {{ new Date(user.created_at).toLocaleDateString('en-GB', {
                                            day:
                                                '2-digit', month: 'long', year: 'numeric'
                                        }) }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap text-xs text-gray-500">
                                    <select v-model="user.role_id" @change="updateUserRole(user)"
                                        class="px-4 py-2 border border-gray-300 rounded text-xs w-full">
                                        <option value="1">Super Admin</option>
                                        <option value="2">Admin</option>
                                        <option value="3">Manager</option>
                                        <option value="4">Staff</option>
                                    </select>
                                </td>
                                <td
                                    class="px-4 py-2 whitespace-nowrap text-xs text-gray-500 space-x-4 flex items-center">
                                    <!-- delete button -->
                                    <div class="mt-2">
                                        <!-- Delete Button -->
                                        <button class="underline" @click="showDeleteModal = true">Delete</button>

                                        <!-- Confirmation Modal -->
                                        <div v-if="showDeleteModal"
                                            class="fixed z-50 inset-0 flex items-center justify-center">
                                            <!-- Black overlay (backdrop) -->
                                            <div class="fixed inset-0 bg-black/10"></div>

                                            <!-- Modal content -->
                                            <div class="relative bg-white rounded p-6 w-full max-w-sm z-50">
                                                <h3 class="text-black text-lg font-semibold mb-4">Confirm Delete</h3>
                                                <p>Are you sure you want to delete <span class="font-semibold">{{
                                                    user.first_name
                                                        }} {{ user.last_name
                                                        }}</span>?</p>

                                                <div class="mt-6 flex justify-end space-x-4">
                                                    <CancelButton @click="showDeleteModal = false">Cancel</CancelButton>
                                                    <DangerButton @click="deleteUser(user)">Continue</DangerButton>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- edit button -->
                                    <div class="mt-2">
                                        <!-- Delete Button -->
                                        <button class="underline" @click="openEditModal(user)">Edit</button>

                                        <!-- Confirmation Modal -->
                                        <div v-if="showEditModal"
                                            class="fixed z-50 inset-0 flex items-center justify-center">
                                            <!-- Black overlay (backdrop) -->
                                            <div class="fixed inset-0 bg-black/10"></div>

                                            <!-- Modal content -->
                                            <div class="relative bg-white rounded p-6 w-full max-w-sm z-50">
                                                <h3 class="text-black text-lg font-semibold mb-4">Edit User</h3>

                                                <div class="flex space-x-2">
                                                    <!-- Input for First Name -->
                                                    <div class="mb-4">
                                                        <InputLabel for="first_name" value="First Name" />
                                                        <TextInput id="first_name" type="text"
                                                            v-model="editForm.first_name" class="mt-1 block w-full"
                                                            placeholder="First Name" />
                                                        <InputError :message="errors.first_name" class="mt-2" />
                                                    </div>

                                                    <!-- Input for Last Name -->
                                                    <div class="mb-4">
                                                        <InputLabel for="last_name" value="Last Name" />
                                                        <TextInput id="last_name" type="text"
                                                            v-model="editForm.last_name" class="mt-1 block w-full"
                                                            placeholder="Last Name" />
                                                        <InputError :message="errors.last_name" class="mt-2" />
                                                    </div>
                                                </div>

                                                <!-- Input for Email -->
                                                <div class="mb-4">
                                                    <InputLabel for="email" value="Email Address" />
                                                    <TextInput id="email" type="email" v-model="editForm.email"
                                                        class="mt-1 block w-full" placeholder="Email Address" />
                                                    <InputError :message="errors.email" class="mt-2" />
                                                </div>

                                                <div class="mt-6 flex justify-end space-x-4">
                                                    <CancelButton @click="showEditModal = false">Cancel</CancelButton>
                                                    <PrimaryButton @click="editUser(user)">Update</PrimaryButton>
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
                    <button v-if="displayedItems < filteredUsers.length" @click="loadMore"
                        class="px-4 py-2 rounded bg-[#BCDA84] [#00434b] hover:bg-blue-600">
                        Load More
                    </button>
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
import { toast } from 'vue3-toastify'
import { ref, computed } from 'vue';
import axios from 'axios';
import AppLayout from '@/Layouts/AppLayout.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue'; import CancelButton from '@/Components/CancelButton.vue';
import DangerButton from '@/Components/DangerButton.vue';

const { users, usersCount } = defineProps({
    users: Array,
    usersCount: Number,
});

const searchTerm = ref('');
const displayedItems = ref(10);

const filteredUsers = computed(() => {
    if (!searchTerm.value) return users;
    const term = searchTerm.value.toLowerCase();
    return users.filter(user =>
        user.first_name.toLowerCase().includes(term) ||
        user.last_name.toLowerCase().includes(term) ||
        user.email.toLowerCase().includes(term)
    );
});

const paginatedUsers = computed(() => filteredUsers.value.slice(0, displayedItems.value));

const loadMore = () => { displayedItems.value += 10; };

const updateUserRole = (user) => {
    axios.put(`/user/edit/${user.id}`, {
        role_id: user.role_id
    })
        .then(response => {
            toast("Role updated successfully!", {
                "theme": "colored",
                "type": "success",
                "position": "top-center",
                "hideProgressBar": true,
                "transition": "zoom",
            })

            // alert(response.data.message);
        })

        .catch(error => {
            toast("Error updating role!", {
                "theme": "colored",
                "type": "error",
                "position": "top-center",
                "hideProgressBar": true,
                "transition": "zoom",
            })

            // alert('Failed to update role. Please try again.');
        });
};

const showDeleteModal = ref(false);

const deleteUser = async (user) => {
    try {
        const response = await axios.delete(`/user/delete/${user.id}`);

        if (response.status === 200) {
            showDeleteModal.value = false;
            toast("User deleted successfully!", {
                "theme": "colored",
                "type": "success",
                "position": "top-center",
                "hideProgressBar": true,
                "transition": "zoom",
            })

            window.location.reload();
            // alert('Deleted Successfully');
        } else {
            toast("Error deleting user!", {
                "theme": "colored",
                "type": "error",
                "position": "top-center",
                "hideProgressBar": true,
                "transition": "zoom",
            })

            // alert('Error deleting user');
        }
    } catch (error) {
        alert('Error deleting user');
        console.error('Error deleting user:', error);
    }
};

const showEditModal = ref(false);

const editForm = ref({
    first_name: '',
    last_name: '',
    email: ''
});

const errors = ref({});

const openEditModal = (user) => {
    showEditModal.value = true;

    editForm.value = {
        first_name: user.first_name || '',
        last_name: user.last_name || '',
        email: user.email || ''
    };
};

const editUser = async (user) => {
    try {
        const response = await axios.put(`/user/edit/${user.id}`, {
            first_name: editForm.value.first_name,
            last_name: editForm.value.last_name,
            email: editForm.value.email
        });
        errors.value = {};
        showEditModal.value = false;

        toast("User edited successfully!", {
            "theme": "colored",
            "type": "success",
            "position": "top-center",
            "hideProgressBar": true,
            "transition": "zoom",
        })

        window.location.reload();
        // alert('User updated successfully');
    } catch (error) {
        toast("Error editing user!", {
            "theme": "colored",
            "type": "error",
            "position": "top-center",
            "hideProgressBar": true,
            "transition": "zoom",
        })

        // alert('Error updating user');
    }
};

const showCreateUserModal = ref(false);

const newUser = ref({
    first_name: '',
    last_name: '',
    email: ''
});

const createUser = async () => {
    try {
        const response = await axios.post('/user/store', {
            first_name: newUser.value.first_name,
            last_name: newUser.value.last_name,
            email: newUser.value.email
        });

        showCreateUserModal.value = false;

        toast("User created successfully!", {
            "theme": "colored",
            "type": "success",
            "position": "top-center",
            "hideProgressBar": true,
            "transition": "zoom",
        })
        // alert('User created successfully and email sent!');

        // Emit an event to refresh the user list after creation
        emit('userCreated', response.data);

        // Clear the form
        newUser.value = { first_name: '', last_name: '', email: '' };

        window.location.reload();
    } catch (error) {
        if (error.response && error.response.data.errors) {
            errors.value = error.response.data.errors;
        }
        toast("Error creating user!", {
            "theme": "colored",
            "type": "error",
            "position": "top-center",
            "hideProgressBar": true,
            "transition": "zoom",
        })

        // alert('Error creating user');
    }
};
</script>
