<template>
    <AppLayout title="Agrochemical Program Application Management">
        <div class="mx-auto p-4">
            <form @submit.prevent="saveApplication">
                <!-- Loop through each program -->
                <div v-for="program in programs" :key="program.id" class="mb-8">
                    <h2 class="text-2xl font-bold mb-4">Planned Application Date: {{ program.planned_application_date }}</h2>
                    <h3 class="text-lg mb-2">Crop: {{ program.crop?.block_number || 'N/A' }}</h3>
                    <h4 class="text-md mb-4">Agrochemical: {{ program.agrochemical?.name || 'N/A' }}</h4>

                    <table class="min-w-full border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border border-gray-300 p-2">Application Date</th>
                                <th class="border border-gray-300 p-2">Time</th>
                                <th class="border border-gray-300 p-2">Tractor Start Hours</th>
                                <th class="border border-gray-300 p-2">Tractor End Hours</th>
                                <th class="border border-gray-300 p-2">Tank Number</th>
                                <th class="border border-gray-300 p-2">Liters Applied</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Sort the entries by block_number and mixing_order -->
                            <tr v-for="entry in sortedEntries(program.agrochemical_program_applications)" :key="entry.id" class="border-t">
                                <td class="border border-gray-300 p-2">
                                    <TextInput type="date" v-model="formData.application_date[entry.id]" class="border p-2 w-full" />
                                </td>
                                <td class="border border-gray-300 p-2">
                                    <TextInput type="time" v-model="formData.time[entry.id]" class="border p-2 w-full" />
                                </td>
                                <td class="border border-gray-300 p-2">
                                    <TextInput type="number" v-model="formData.tractor_start_hours[entry.id]" class="border p-2 w-full" />
                                </td>
                                <td class="border border-gray-300 p-2">
                                    <TextInput type="number" v-model="formData.tractor_end_hours[entry.id]" class="border p-2 w-full" />
                                </td>
                                <td class="border border-gray-300 p-2">
                                    <TextInput type="number" v-model="formData.tank_number[entry.id]" class="border p-2 w-full" />
                                </td>
                                <td class="border border-gray-300 p-2">
                                    <TextInput type="number" v-model="formData.liters_applied[entry.id]" class="border p-2 w-full" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded mt-4">Save Application</button>
            </form>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { reactive, onMounted } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import TextInput from '@/Components/TextInput.vue';

// Define the props for programs
const props = defineProps({
    programs: {
        type: Array,
        required: true,
    },
});

// Log for debugging purposes
console.log('Props Data:', props.programs);

// Initialize reactive form data
const formData = reactive({
    application_date: {},
    time: {},
    tractor_start_hours: {},
    tractor_end_hours: {},
    tank_number: {},
    liters_applied: {},
});

// Function to sort entries by block_number and mixing_order
const sortedEntries = (entries) => {
    return [...entries].sort((a, b) => {
        // Sort by block_number first
        if (a.crop?.block_number !== b.crop?.block_number) {
            return (a.crop?.block_number || 0) - (b.crop?.block_number || 0);
        }
        // If block_number is the same, sort by mixing_order of the agrochemical
        return (a.agrochemical?.mixing_order || 0) - (b.agrochemical?.mixing_order || 0);
    });
};

// Populate formData on component mount
onMounted(() => {
    props.programs.forEach(program => {
        program.agrochemical_program_applications.forEach(application => {
            formData.application_date[application.id] = application.application_date || '';
            formData.time[application.id] = application.time || '';
            formData.tractor_start_hours[application.id] = application.tractor_start_hours || '';
            formData.tractor_end_hours[application.id] = application.tractor_end_hours || '';
            formData.tank_number[application.id] = application.tank_number || '';
            formData.liters_applied[application.id] = application.liters_applied || '';
        });
    });
});

// Method to handle form submission
const saveApplication = () => {
    Inertia.post('/application/save', {
        programs: props.programs.map(program => ({
            program_id: program.id,
            application_data: formData,
        })),
    }).then(() => {
        alert('Application data saved successfully.');
    }).catch(error => {
        console.error('Error saving application data:', error);
    });
};
</script>
