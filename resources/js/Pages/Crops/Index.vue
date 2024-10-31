<template>
    <AppLayout title="Crop">
        <div class="overflow-x-hidden overflow-y-auto">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-base font-semibold leading-6 text-gray-900">Crop Management</h1>
                    <p class="mt-2 text-gray-500">Total Crops: {{ filteredCrops.length }} (Filtered from {{ cropCount
                        }})</p>
                </div>

                <div class="flex items-center space-x-4">
                    <!-- Search Bar -->
                    <TextInput type="text" v-model="search" placeholder="Search Crop..." class="w-96" />

                    <div>
                        <PrimaryButton>
                            Create Crop
                        </PrimaryButton>
                    </div>
                </div>
            </div>

            <!-- Table of Cultivars -->
            <div class="mt-4" v-if="filteredCrops && filteredCrops.length > 0">
                <div class="border border-gray-300 rounded-md overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="text-black bg-white">
                            <tr>
                                <th class="px-8 py-4 text-left text-xs font-medium uppercase tracking-wider">Cultivar
                                </th>
                                <th class="px-8 py-4 text-left text-xs font-medium uppercase tracking-wider">Block
                                    Number</th>
                                <th class="px-8 py-4 text-left text-xs font-medium uppercase tracking-wider">Planting
                                    Date</th>
                                <th class="px-8 py-4 text-left text-xs font-medium uppercase tracking-wider">Harvest
                                    Date</th>
                                <th class="px-8 py-4 text-left text-xs font-medium uppercase tracking-wider">Location
                                </th>
                                <th class="px-8 py-4 text-left text-xs font-medium uppercase tracking-wider">Status</th>
                                <th class="px-8 py-4 text-left text-xs font-medium uppercase tracking-wider">Size</th>
                                <th class="px-8 py-4 text-left text-xs font-medium uppercase tracking-wider">Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="crop in filteredCrops" :key="crop.id" class="odd:bg-white even:bg-gray-50">
                                <td class="px-8 py-4 whitespace-nowrap text-xs text-gray-500">{{ crop.cultivar_id }}
                                </td>
                                <td class="px-8 py-4 whitespace-nowrap text-xs text-gray-500">{{ crop.block_number }}
                                </td>
                                <td class="px-8 py-4 whitespace-nowrap text-xs text-gray-500">{{ crop.planting_date }}
                                </td>
                                <td class="px-8 py-4 whitespace-nowrap text-xs text-gray-500">{{ crop.harvest_date }}
                                </td>
                                <td class="px-8 py-4 whitespace-nowrap text-xs text-gray-500">{{ crop.location }}</td>
                                <td
                                    class="px-8 py-4 whitespace-nowrap text-[11px] text-gray-500 uppercase tracking-wider">
                                    <span class="px-4 py-2 rounded-full font-semibold text-white" :class="{
                                        'bg-emerald-500': crop.status === 'planted',
                                        'bg-violet-600': crop.status === 'growing',
                                        'bg-sky-600': crop.status === 'harvested',
                                        'bg-red-600': crop.status === 'failed'
                                    }">
                                        {{ crop.status }}
                                    </span>
                                </td>
                                <td class="px-8 py-4 whitespace-nowrap text-xs text-gray-500">{{ crop.size }}</td>
                                <td
                                    class="px-8 py-4 whitespace-nowrap text-xs text-gray-500 space-x-4 flex items-center">
                                    <button class="underline">Delete</button>
                                    <button class="underline">Edit</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- If no crops found -->
            <div v-else>
                <p>No crops found</p>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const { crops, cropCount } = defineProps({
    crops: Array,
    cropCount: Number,
});

const search = ref('');

// Computed property to filter crops based on the search term
const filteredCrops = computed(() => {
    if (!search.value) return crops;

    return crops.filter((crop) => {
        const searchValue = search.value.toLowerCase();
        return (
            crop.block_number.toLowerCase().includes(searchValue) ||
            crop.planting_date.toLowerCase().includes(searchValue) ||
            (crop.harvest_date && crop.harvest_date.toLowerCase().includes(searchValue)) ||
            crop.location.toLowerCase().includes(searchValue) ||
            crop.status.toLowerCase().includes(searchValue) ||
            crop.size.toString().includes(searchValue)  // Convert size to string for numeric match
        );
    });
});
</script>