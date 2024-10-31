<template>
    <AppLayout title="Agrochemical">
        <div class="overflow-x-hidden overflow-y-auto">
            <div class="block md:flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-base font-semibold leading-6 text-gray-900">Agrochemical Management</h1>
                    <p class="mt-1 text-gray-500">Total Agrochemical: x (Filtered from x)</p>
                </div>

                <div class="mt-4 md:mt-0 flex items-center space-x-2 md:space-x-4">
                    <!-- Search Bar -->
                    <TextInput type="text" v-model="search" placeholder="Search Agrochemical..." class="w-96" />

                    <div class="w-full md:w-fit">
                        <PrimaryButton>
                            Create xxx
                        </PrimaryButton>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { toast } from 'vue3-toastify'
import { ref, computed, onMounted } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';;
import PrimaryButton from '@/Components/PrimaryButton.vue';
</script>