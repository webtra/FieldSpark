<template>
    <AppLayout title="Application Sheet">
        <div>
            <div class="block md:flex items-center justify-between mb-4">
                <p class="text-sm text-black font-medium"><span class="font-bold"></span>Program Application Form</p>

                <div class="md:mt-0 flex items-center space-x-2 md:space-x-4">
                    <div class="w-full md:w-fit">
                        <PrimaryButton @click="saveApplications">
                            Save Application
                        </PrimaryButton>
                    </div>
                </div>
            </div>


            <!-- Group programs by block number -->
            <div v-for="(applications, blockNumber) in groupedApplications" :key="blockNumber" class="mb-8">
                <div class="rounded-lg overflow-x-auto">
                    <table class="min-w-full text-sm text-black">
                        <thead class="bg-white border-b-2 border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-center text-xs font-medium w-28">Application Date</th>
                                <th class="px-4 py-4 text-center text-xs font-medium w-28">Block</th>
                                <th class="px-4 py-4 text-center text-xs font-medium w-28">Time</th>
                                <th class="px-4 py-4 text-center text-xs font-medium w-28">Tractor Start Hours</th>
                                <th class="px-4 py-4 text-center text-xs font-medium w-28">Tractor End Hours</th>
                                <th class="px-4 py-4 text-center text-xs font-medium w-28">Tank Number</th>
                                <th class="px-6 py-4 text-center text-xs font-medium w-28">Liters Applied</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="entry in applications" :key="entry.id" class="bg-white divide-y divide-gray-200">
                                <td class="px-6 py-2 text-xs text-gray-600 border-b">
                                    <TextInput type="date" v-model="formData.application_date[entry.id]"
                                        class="border p-2 w-full" />
                                </td>
                                <td class="px-4 py-2 text-center text-xs text-gray-600">{{ blockNumber }}</td>
                                <td class="px-4 py-2 text-center text-xs text-gray-600">
                                    <TextInput type="time" v-model="formData.time[entry.id]"
                                        class="border p-2 w-full" />
                                </td>
                                <td class="px-4 py-2 text-center text-xs text-gray-600">
                                    <TextInput type="number" v-model="formData.tractor_start_hours[entry.id]"
                                        class="border p-2 w-full" />
                                </td>
                                <td class="px-4 py-2 text-center text-xs text-gray-600">
                                    <TextInput type="number" v-model="formData.tractor_end_hours[entry.id]"
                                        class="border p-2 w-full" />
                                </td>
                                <td class="px-4 py-2 text-center text-xs text-gray-600">
                                    <TextInput type="number" v-model="formData.tank_number[entry.id]"
                                        class="border p-2 w-full" />
                                </td>
                                <td class="px-4 py-2 text-center text-xs text-gray-600">
                                    <TextInput type="number" v-model="formData.liters_applied[entry.id]"
                                        class="border p-2 w-full" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { computed, ref } from 'vue';
import axios from 'axios';
import { toast } from 'vue3-toastify';
import AppLayout from '@/Layouts/AppLayout.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

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
        formData.value.application_date[entryId] = entry.application_date || '';
        formData.value.time[entryId] = entry.time || '';
        formData.value.tractor_start_hours[entryId] = entry.tractor_start_hours || '';
        formData.value.tractor_end_hours[entryId] = entry.tractor_end_hours || '';
        formData.value.tank_number[entryId] = entry.tank_number || '';
        formData.value.liters_applied[entryId] = entry.liters_applied || '';
    });
});

// Function to save data
const saveApplications = async () => {
    try {
        const payload = Object.keys(formData.value.application_date).map(entryId => ({
            id: entryId,
            application_date: formData.value.application_date[entryId],
            time: formData.value.time[entryId],
            tractor_start_hours: formData.value.tractor_start_hours[entryId],
            tractor_end_hours: formData.value.tractor_end_hours[entryId],
            tank_number: formData.value.tank_number[entryId],
            liters_applied: formData.value.liters_applied[entryId],
        }));

        //console.log('Sending payload:', payload);

        const response = await axios.post('/agrochemical-program/application/save', { applications: payload });
        console.log('Save response:', response.data);
        toast("Record updated successfully!", {
            theme: "colored",
            type: "success",
            position: "top-center",
            hideProgressBar: true,
        });
    } catch (error) {
        console.error('Error saving data:', error.response ? error.response.data : error);
        toast("Error updating record!", {
            theme: "colored",
            type: "error",
            position: "top-center",
            hideProgressBar: true,
        });
    }
};

</script>
