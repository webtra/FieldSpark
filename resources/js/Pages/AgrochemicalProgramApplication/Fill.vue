<template>
    <AppLayout title="Application Sheet">
        <div class="mx-auto p-4">
            <!-- Group programs by block number -->
            <div v-for="(applications, blockNumber) in groupedApplications" :key="blockNumber" class="mb-8">
                <table class="min-w-full border-collapse border border-gray-300 mb-4">
                    <thead>
                        <tr>
                            <th colspan="7" class="border border-gray-300 p-2 bg-gray-100 text-center font-semibold">
                                Application Sheet for Crop: {{ blockNumber }}
                            </th>
                        </tr>
                    </thead>
                </table>
                <table class="min-w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border border-gray-300 p-2">Application Date</th>
                            <th class="border border-gray-300 p-2">Block</th>
                            <th class="border border-gray-300 p-2">Time</th>
                            <th class="border border-gray-300 p-2">Tractor Start Hours</th>
                            <th class="border border-gray-300 p-2">Tractor End Hours</th>
                            <th class="border border-gray-300 p-2">Tank Number</th>
                            <th class="border border-gray-300 p-2">Liters Applied</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="entry in applications" :key="entry.id" class="border-t">
                            <td class="border border-gray-300 p-2">
                                <TextInput type="date" v-model="formData.application_date[entry.id]"
                                    class="border p-2 w-full" />
                            </td>
                            <td class="border border-gray-300 p-2">{{ blockNumber }}</td>
                            <td class="border border-gray-300 p-2">
                                <TextInput type="time" v-model="formData.time[entry.id]" class="border p-2 w-full" />
                            </td>
                            <td class="border border-gray-300 p-2">
                                <TextInput type="number" v-model="formData.tractor_start_hours[entry.id]"
                                    class="border p-2 w-full" />
                            </td>
                            <td class="border border-gray-300 p-2">
                                <TextInput type="number" v-model="formData.tractor_end_hours[entry.id]"
                                    class="border p-2 w-full" />
                            </td>
                            <td class="border border-gray-300 p-2">
                                <TextInput type="number" v-model="formData.tank_number[entry.id]"
                                    class="border p-2 w-full" />
                            </td>
                            <td class="border border-gray-300 p-2">
                                <TextInput type="number" v-model="formData.liters_applied[entry.id]"
                                    class="border p-2 w-full" />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { computed, ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import TextInput from '@/Components/TextInput.vue';

// Props for programs
const props = defineProps({
    programs: {
        type: Array,
        required: true,
    },
});

// Group applications by block number
const groupedApplications = computed(() => {
    const grouped = {};
    props.programs.forEach(program => {
        const blockNumber = program.crop?.block_number || 'N/A';
        if (!grouped[blockNumber]) {
            grouped[blockNumber] = [];
        }
        grouped[blockNumber].push(...program.agrochemical_program_applications);
    });
    return grouped;
});

// Initialize formData to store form inputs and prevent undefined errors
const formData = ref({
    application_date: {},
    time: {},
    tractor_start_hours: {},
    tractor_end_hours: {},
    tank_number: {},
    liters_applied: {},
});

// Populate formData with initial values
props.programs.forEach(program => {
    program.agrochemical_program_applications.forEach(entry => {
        const entryId = entry.id;
        if (!(entryId in formData.value.application_date)) {
            formData.value.application_date[entryId] = entry.application_date || '';
        }
        if (!(entryId in formData.value.time)) {
            formData.value.time[entryId] = entry.time || '';
        }
        if (!(entryId in formData.value.tractor_start_hours)) {
            formData.value.tractor_start_hours[entryId] = entry.tractor_start_hours || '';
        }
        if (!(entryId in formData.value.tractor_end_hours)) {
            formData.value.tractor_end_hours[entryId] = entry.tractor_end_hours || '';
        }
        if (!(entryId in formData.value.tank_number)) {
            formData.value.tank_number[entryId] = entry.tank_number || '';
        }
        if (!(entryId in formData.value.liters_applied)) {
            formData.value.liters_applied[entryId] = entry.liters_applied || '';
        }
    });
});

// Extract unique agrochemicals for recommendations, sorted by mixing order
const uniqueAgrochemicals = computed(() => {
    const seenIds = new Set();
    return props.programs
        .map(program => program.agrochemical)
        .filter(agrochemical => {
            if (agrochemical && !seenIds.has(agrochemical.id)) {
                seenIds.add(agrochemical.id);
                return true;
            }
            return false;
        })
        .sort((a, b) => (a.mixing_order || Infinity) - (b.mixing_order || Infinity));
});
</script>

<style scoped>
/* Styling to match the original design */
table {
    width: 100%;
    margin-bottom: 15px;
    border-collapse: collapse;
}

th,
td {
    border: 1px solid #ccc;
    padding: 8px 12px;
    text-align: center;
}

thead th {
    background-color: #f0f0f0;
    font-weight: 500;
}
</style>
