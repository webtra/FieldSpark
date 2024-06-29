<template>
    <AppLayout title="Create Service">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            <div>
                <h2 class="text-lg font-medium mb-4 text-gray-900">Add New Service</h2>
                <div class="p-4 bg-white border rounded">
                    <form @submit.prevent="submitForm" class="space-y-6">
                        <div>
                            <label for="serviceName" class="block text-xs font-medium text-gray-700">Service
                                Name</label>
                            <input type="text" id="serviceName" v-model="service.name"
                                class="mt-1 block w-full py-2 border border-gray-300 rounded text-xs"
                                placeholder="Enter service name" required>
                        </div>
                        <div>
                            <label for="serviceDescription" class="block text-xs font-medium text-gray-700">
                                Service Description
                            </label>
                            <textarea id="serviceDescription" v-model="service.description" rows="10"
                                class="mt-1 block w-full py-2 border border-gray-300 rounded text-xs"
                                placeholder="Describe what this service entails" required></textarea>
                        </div>
                        <div>
                            <label for="servicePrice" class="block text-xs font-medium text-gray-700">
                                Service Price (ZAR)
                            </label>
                            <input type="number" id="servicePrice" v-model="service.price"
                                class="mt-1 block w-full py-2 border border-gray-300 rounded text-xs" placeholder="0.00"
                                required>
                        </div>
                        <div>
                            <label for="serviceStatus" class="block text-xs font-medium text-gray-700">Service
                                Status</label>
                            <select id="serviceStatus" v-model="service.status"
                                class="mt-1 block w-full py-2 border border-gray-300 rounded text-xs">
                                <option value="Active">Active</option>
                                <option value="Pending">Pending</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                        <button type="submit"
                            class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 uppercase tracking-wider">
                            Create
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>


<script setup>
import { ref } from 'vue';
import axios from 'axios';
import AppLayout from '@/Layouts/AppLayout.vue';
import { useToast } from 'vue-toastification';

const toast = useToast();

const service = ref({
    name: '',
    description: '',
    price: 0,
    status: 'Active',
});

const submitForm = async () => {
    try {
        const response = await axios.post('/api/services/create', service.value);
        // Reset the form after successful post
        service.value = { name: '', description: '', price: 0, status: 'Active' };
        toast.success('Service created successfully');
    } catch (error) {
        console.error('Failed to add service:', error);
        toast.error('Failed to create service');
    }
};
</script>
