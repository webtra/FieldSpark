<template>
    <AppLayout title="Services">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div v-for="service in services" :key="service.id" class="p-4 bg-white rounded border">
                <h2 class="text-base font-medium mb-4">{{ service.name }}</h2>
                <p class="text-xs">{{ service.description }}</p>
                <div class="my-6 flex items-center justify-between">
                    <p class="text-xs">From ZAR {{ formatPrice(service.price) }}</p>
                    <p :class="getStatusClass(service.status)"
                        class="text-xs tracking-wide font-medium py-1 px-3 rounded-full">
                        {{ service.status }}
                    </p>
                </div>
                <div class="flex space-x-4">
                    <button @click="viewService(service.id)"
                        class="w-full bg-gray-200 hover:bg-gray-300 border border-gray-300 text-black text-xs uppercase tracking-wider font-medium py-2.5 px-4 rounded">View</button>
                    <button @click="bookService(service.id)"
                        class="w-full bg-blue-500 hover:bg-blue-600 border border-blue-600 text-white text-xs uppercase tracking-wider font-medium py-2.5 px-4 rounded">Book</button>
                </div>
            </div>
        </div>

    </AppLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import AppLayout from '@/Layouts/AppLayout.vue';

const services = ref([]);

const fetchServices = async () => {
    try {
        const response = await axios.get('/api/services/index');
        services.value = response.data.services;
    } catch (error) {
        console.error('Error fetching services:', error);
    }
};

onMounted(async () => {
    fetchServices();
});

const formatPrice = (price) => {
    return Number(price).toLocaleString('en-ZA', {
        style: 'decimal',
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
};

// Method to return appropriate class for status
const getStatusClass = (status) => {
    switch (status) {
        case 'Active':
            return 'bg-green-500 text-white border border-green-600 uppercase';
        case 'Pending':
            return 'bg-pink-500 text-white border border-pink-600 uppercase';
        case 'Inactive':
            return 'bg-red-500 text-white border border-red-600 uppercase';
        default:
            return 'bg-gray-500 text-white border border-gray-600 uppercase';
    }
};

const viewService = (id) => {
    // Implement navigation or additional logic to view details
    console.log('Viewing service', id);
};

const bookService = (id) => {
    // Implement booking logic
    console.log('Booking service', id);
};
</script>
