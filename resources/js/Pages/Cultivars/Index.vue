<template>
    <AppLayout title="Cultivar">
        <div class="overflow-x-hidden overflow-y-auto">
            <div class="block md:flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-base font-semibold leading-6 text-gray-900">Cultivar Management</h1>
                    <p class="mt-1 text-gray-500">Total Cultivars: {{ filteredCultivars.length }} (Filtered from {{ cultivarCount }})</p>
                </div>

                <div class="mt-4 md:mt-0 flex items-center space-x-2 md:space-x-4">
                    <!-- Search Bar -->
                    <TextInput type="text" v-model="search" placeholder="Search Cultivar..." class="w-full md:w-96" />

                    <div class="w-full md:w-fit">
                        <PrimaryButton @click="download">
                            Export to PDF
                        </PrimaryButton>
                    </div>
                </div>
            </div>

            <!-- Table of Cultivars -->
            <div class="mt-4" v-if="paginatedCultivars && paginatedCultivars.length > 0">
                <div class="border border-gray-300 rounded-md overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="text-black bg-white">
                            <tr>
                                <th class="px-4 py-4 text-left text-xs font-medium uppercase tracking-wider w-32 whitespace-nowrap">Variety Number</th>
                                <th class="px-4 py-4 text-left text-xs font-medium uppercase tracking-wider w-48 whitespace-nowrap">Prime Name</th>
                                <th class="px-4 py-4 text-left text-xs font-medium uppercase tracking-wider w-32 whitespace-nowrap">Country</th>
                                <th class="px-4 py-4 text-left text-xs font-medium uppercase tracking-wider w-48 whitespace-nowrap">Color of Berry Skin</th>
                                <th class="px-4 py-4 text-left text-xs font-medium uppercase tracking-wider w-48 whitespace-nowrap">Country of Origin</th>
                                <th class="px-4 py-4 text-left text-xs font-medium uppercase tracking-wider w-48 whitespace-nowrap">Species</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="cultivar in paginatedCultivars" :key="cultivar.id" class="odd:bg-white even:bg-gray-50">
                                <td class="px-4 py-2 text-xs text-gray-500 w-32">{{ cultivar.variety_number }}</td>
                                <td class="px-4 py-2 text-xs text-gray-500 w-48">{{ cultivar.prime_name }}</td>
                                <td class="px-4 py-2 text-xs text-gray-500 w-32">{{ cultivar.country }}</td>
                                <td class="px-4 py-2 text-xs text-gray-500 w-48">{{ cultivar.color_of_berry_skin }}</td>
                                <td class="px-4 py-2 text-xs text-gray-500 w-48">{{ cultivar.country_of_origin }}</td>
                                <td class="px-4 py-2 text-xs text-gray-500 w-48">{{ cultivar.species }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Load More Button -->
                <div class="flex justify-center mt-4">
                    <button v-if="displayedItems < filteredCultivars.length" @click="loadMore" class="px-4 py-2 rounded bg-[#BCDA84] [#00434b] hover:bg-blue-600">
                       Load More
                    </button>
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

const { cultivars, cultivarCount } = defineProps({
    cultivars: Array,
    cultivarCount: Number,
});

// Reactive properties
const search = ref('');
const displayedItems = ref(10); // Initial number of items to show

// Computed property for filtered cultivars based on search term
const filteredCultivars = computed(() => {
    if (!search.value) return cultivars;

    return cultivars.filter((cultivar) => {
        return (
            cultivar.variety_number.toLowerCase().includes(search.value.toLowerCase()) ||
            cultivar.prime_name.toLowerCase().includes(search.value.toLowerCase()) ||
            cultivar.country.toLowerCase().includes(search.value.toLowerCase()) ||
            cultivar.color_of_berry_skin.toLowerCase().includes(search.value.toLowerCase()) ||
            cultivar.country_of_origin.toLowerCase().includes(search.value.toLowerCase()) ||
            cultivar.species.toLowerCase().includes(search.value.toLowerCase())
        );
    });
});

// Computed property for paginated cultivars, limited by displayedItems
const paginatedCultivars = computed(() => {
    return filteredCultivars.value.slice(0, displayedItems.value);
});

// Load More function
const loadMore = () => {
    displayedItems.value += 10; // Increase the number of items by 10
};

// PDF download function
const download = () => {
    axios.get('/cultivar/download', { responseType: 'blob' })
        .then((response) => {
            const url = window.URL.createObjectURL(new Blob([response.data]));
            const link = document.createElement('a');
            link.href = url;
            link.setAttribute('download', 'cultivars.pdf');
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        })
        .catch((error) => {
            toast("Error downloading file!", {
                "theme": "colored",
                "type": "error",
                "position": "top-center",
                "hideProgressBar": true,
                "transition": "zoom",
            });
        });
};
</script>
