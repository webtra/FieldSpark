<template>
    <AppLayout title="Cultivar">
        <div class="overflow-x-hidden overflow-y-auto">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-base font-semibold leading-6 text-gray-900">Cultivar Management</h1>
                    <p class="mt-2 text-gray-500">Total Cultivars: {{ filteredCultivars.length }} (Filtered from {{
                        cultivarCount }})
                    </p>
                </div>

                <div class="flex items-center space-x-4">
                    <!-- Search Bar -->
                    <TextInput type="text" v-model="searchTerm" placeholder="Search Cultivar..." class="w-96" />

                    <div>
                        <PrimaryButton @click="downloadPDF">
                            Export to PDF
                        </PrimaryButton>
                    </div>
                </div>
            </div>

            <!-- Table of Cultivars -->
            <div class="mt-4" v-if="filteredCultivars && filteredCultivars.length > 0">
                <div class="border border-gray-300 rounded-md overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="text-black bg-white">
                            <tr>
                                <th class="px-8 py-4 text-left text-xs font-medium uppercase tracking-wider">
                                    Variety Number
                                </th>
                                <th class="px-8 py-4 text-left text-xs font-medium uppercase tracking-wider">
                                    Prime Name
                                </th>
                                <th class="px-8 py-4 text-left text-xs font-medium uppercase tracking-wider">
                                    Country
                                </th>
                                <th class="px-8 py-4 text-left text-xs font-medium uppercase tracking-wider">
                                    Color of Berry Skin
                                </th>
                                <th class="px-8 py-4 text-left text-xs font-medium uppercase tracking-wider">
                                    Country of Origin
                                </th>
                                <th class="px-8 py-4 text-left text-xs font-medium uppercase tracking-wider">
                                    Species
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="cultivar in filteredCultivars" :key="cultivar.id"
                                class="odd:bg-white even:bg-gray-50">
                                <td class="px-8 py-4 whitespace-nowrap text-xs text-gray-500">{{ cultivar.variety_number
                                    }}</td>
                                <td class="px-8 py-4 whitespace-nowrap text-xs text-gray-500">{{ cultivar.prime_name }}
                                </td>
                                <td class="px-8 py-4 whitespace-nowrap text-xs text-gray-500">{{ cultivar.country }}
                                </td>
                                <td class="px-8 py-4 whitespace-nowrap text-xs text-gray-500">{{
                                    cultivar.color_of_berry_skin }}</td>
                                <td class="px-8 py-4 whitespace-nowrap text-xs text-gray-500">{{
                                    cultivar.country_of_origin }}</td>
                                <td class="px-8 py-4 whitespace-nowrap text-xs text-gray-500">{{ cultivar.species }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- If no cultivars found -->
            <div v-else>
                <p>No cultivars found</p>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

// Props received from the controller
const { cultivars, cultivarCount } = defineProps({
    cultivars: Array,
    cultivarCount: Number,
});

// Reactive search term
const searchTerm = ref('');

// Computed property to filter cultivars based on the search term
const filteredCultivars = computed(() => {
    if (!searchTerm.value) return cultivars;

    // Return cultivars that match the search term in any field
    return cultivars.filter((cultivar) => {
        return (
            cultivar.variety_number.toLowerCase().includes(searchTerm.value.toLowerCase()) ||
            cultivar.prime_name.toLowerCase().includes(searchTerm.value.toLowerCase()) ||
            cultivar.country.toLowerCase().includes(searchTerm.value.toLowerCase()) ||
            cultivar.color_of_berry_skin.toLowerCase().includes(searchTerm.value.toLowerCase()) ||
            cultivar.country_of_origin.toLowerCase().includes(searchTerm.value.toLowerCase()) ||
            cultivar.species.toLowerCase().includes(searchTerm.value.toLowerCase())
        );
    });
});

const downloadPDF = () => {
    // Use axios to send a GET request to download the PDF
    axios.get('/cultivars/pdf', { responseType: 'blob' })
        .then((response) => {
            // Create a URL for the blob object
            const url = window.URL.createObjectURL(new Blob([response.data]));
            const link = document.createElement('a');
            link.href = url;
            link.setAttribute('download', 'cultivars.pdf'); // Download the file
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link); // Clean up the link element
        })
        .catch((error) => {
            console.error("Error downloading PDF:", error);
            alert('Failed to download PDF. Please try again later.');
        });
};

// For debugging
console.log(cultivars);
console.log('Total Cultivars: ', cultivarCount);
</script>