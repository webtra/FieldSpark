<template>
    <AppLayout title="Cultivar">
        <div class="overflow-x-hidden overflow-y-auto !z-0" :style="{ zIndex: '-1' }">
            <div class="flex items-center">
                <div class="flex-auto">
                    <h1 class="text-base font-semibold leading-6 text-gray-900">Wine Grape Cultivars</h1>
                    <p class="mt-2 text-xs text-gray-700">
                        A list of all the grape cultivars including their variety number, prime name, country, color of
                        berry skin, country of origin, and species.
                    </p>
                </div>
                <div>
                    <InputText type="text" class="text-xs placeholder:text-xs" v-model="searchQuery"
                        placeholder="Search cultivars..." />
                </div>
            </div>

            <div class="mt-8 bg-white border rounded">
                <DataTable :value="cultivars" :paginator="true" :rows="20" responsiveLayout="scroll"
                    :style="{ borderRadius: '12px' }">
                    <!-- Setting fixed widths for each column -->
                    <Column field="variety_number" header="Variety Number" :style="{ width: '150px' }" />
                    <Column field="prime_name" header="Prime Name" :style="{ width: '150px' }" />
                    <Column field="country" header="Country" :style="{ width: '150px' }" />
                    <Column field="color_of_berry_skin" header="Color of Berry Skin" :style="{ width: '150px' }" />
                    <Column field="country_of_origin" header="Country of Origin" :style="{ width: '200px' }" />
                    <!-- <Column field="species" header="Species" :style="{ width: '150px' }" /> -->

                    <Column header="Actions" :style="{ width: '150px' }">
                        <template #body="slotProps">
                            <div class="flex justify-end space-x-4">
                                <button class="w-full text-xs bg-blue-500 text-white py-2 px-4 rounded"
                                    @click="editCultivar(slotProps.data)">
                                    Edit
                                </button>
                                <button class="w-full text-xs bg-red-500 text-white py-2 px-4 rounded"
                                    @click="deleteCultivar(slotProps.data)">
                                    Delete
                                </button>
                            </div>
                        </template>
                    </Column>
                </DataTable>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { defineProps, ref, computed } from 'vue';

import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import InputText from 'primevue/inputtext';

const props = defineProps({
    cultivars: Array,
});

const searchQuery = ref('');

// Computed property to filter cultivars based on search query
const filteredCultivars = computed(() => {
    return props.cultivars.filter(cultivar => {
        // Match against any field
        return cultivar.prime_name.toLowerCase().includes(searchQuery.value.toLowerCase());
    });
});
</script>
