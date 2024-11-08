<template>
    <AppLayout title="Agrochemical">
        <div class="overflow-x-hidden overflow-y-auto">
            <div class="block md:flex items-center justify-between mb-4">
                <p class="text-sm mt-1 text-black font-medium"><span class="font-bold">Total Agrochemicals:</span> {{
                    filteredAgrochemicals.length }} (Filtered from
                    {{ agrochemicalsCount }})</p>

                <div class="mt-4 md:mt-0 flex items-center space-x-2 md:space-x-4">
                    <!-- Search Bar -->
                    <TextInput type="text" v-model="searchTerm" placeholder="Search" class="w-96" />

                    <div class="w-full md:w-fit">
                        <PrimaryButton @click="showCreateAgrochemicalModal = true">
                            Create Agrochemical
                        </PrimaryButton>
                    </div>
                </div>
            </div>

            <!-- Modal for Creating a Cultivar -->
            <div v-if="showCreateAgrochemicalModal" class="fixed z-50 inset-0 flex items-center justify-center">
                <!-- Black overlay (backdrop) -->
                <div class="fixed inset-0 bg-black opacity-50"></div>

                <!-- Modal content -->
                <div class="relative bg-white rounded p-6 w-full max-w-lg z-50">
                    <h3 class="text-lg font-semibold mb-4">Create New Agrochemical</h3>

                    <div class="mb-4">
                        <InputLabel value="Agrochemical Name" />
                        <TextInput id="name" type="text" v-model="formData.name" class="mt-1 block w-full"
                            placeholder="Agrochemical Name" required />
                    </div>

                    <div class="mb-4">
                        <InputLabel value="Recommended Dosage" />
                        <p class="text-gray-400 text-[11px]">Dosage per 1500 Litre</p>
                        <TextInput id="name" type="text" v-model="formData.recommended_dosage" class="mt-1 block w-full"
                            placeholder="Recommended Dosage" required />
                    </div>

                    <div class="flex space-x-4 mb-4">
                        <div class="w-full">
                            <InputLabel value="Manufacturer" />
                            <TextInput id="name" type="text" v-model="formData.manufacturer" class="mt-1 block w-full"
                                placeholder="Manufacturer" required />
                        </div>

                        <div class="w-full">
                            <InputLabel value="Category" />
                            <select v-model="formData.category"
                                class="w-full text-xs mt-1 placeholder:text-xs border-gray-300 focus:border-[#BCDA84] focus:ring-[#BCDA84] rounded"
                                required>
                                <option value="Herbicide">Herbicide</option>
                                <option value="Pesticide">Pesticide</option>
                                <option value="Fungicide">Fungicide</option>
                                <option value="Fertilizer">Fertilizer</option>
                                <option value="Growth Regulator">Growth Regulator</option>
                            </select>
                        </div>
                    </div>

                    <div class="w-full mb-4">
                        <InputLabel value="Mixing Category" />
                        <select v-model="formData.mixing_category"
                            class="w-full text-xs mt-1 placeholder:text-xs border-gray-300 focus:border-[#BCDA84] focus:ring-[#BCDA84] rounded"
                            required>
                            <option value="Water">Water</option>
                            <option value="Water Quality Regulators">Water Quality Regulators</option>
                            <option value="Water-Soluble Packets">Water-Soluble Packets</option>
                            <option value="Dry Formulations">Dry Formulations</option>
                            <option value="Suspension Concentrates">Suspension Concentrates</option>
                            <option value="Emulsifiable Concentrates">Emulsifiable Concentrates</option>
                            <option value="Adhesives">Adhesives</option>
                            <option value="Water-Soluble Liquids">Water-Soluble Liquids</option>
                            <option value="Foliar Feedings">Foliar Feedings</option>
                        </select>
                    </div>

                    <div class="flex space-x-4 mb-4">
                        <div class="w-full">
                            <InputLabel value="Application Method" />
                            <select v-model="formData.application_method"
                                class="w-full text-xs mt-1 placeholder:text-xs border-gray-300 focus:border-[#BCDA84] focus:ring-[#BCDA84] rounded"
                                required>
                                <option value="Spray">Spray</option>
                                <option value="Granular">Granular</option>
                                <option value="Drip">Drip</option>
                                <option value="Foliar">Foliar</option>
                            </select>
                        </div>

                        <div class="w-full">
                            <InputLabel value="Toxicity Level" />
                            <select v-model="formData.toxicity_level"
                                class="w-full text-xs mt-1 placeholder:text-xs border-gray-300 focus:border-[#BCDA84] focus:ring-[#BCDA84] rounded"
                                required>
                                <option value="Low">Low</option>
                                <option value="Medium">Medium</option>
                                <option value="High">High</option>
                            </select>
                        </div>

                        <div class="w-full">
                            <InputLabel value="Restricted Use" />
                            <select v-model="formData.restricted_use"
                                class="w-full text-xs mt-1 placeholder:text-xs border-gray-300 focus:border-[#BCDA84] focus:ring-[#BCDA84] rounded"
                                required>
                                <option :value="true">Yes</option>
                                <option :value="false">No</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <InputLabel value="Recommended Application Frequency" />
                        <p class="text-gray-400 text-[11px]">Weekly, Bi-Weekly or Monthly</p>
                        <TextInput id="name" type="text" v-model="formData.recommended_application_frequency"
                            class="mt-1 block w-full" placeholder="Recommended Application Frequency" required />
                    </div>

                    <div class="flex space-x-4 mb-4">
                        <div class="w-full">
                            <InputLabel value="Re-Entry Internal (Hours)" />
                            <p class="text-gray-400 text-[11px]">Enter field only after safe time elapses</p>
                            <TextInput id="name" type="number" v-model="formData.reentry_interval"
                                class="mt-1 block w-full" placeholder="Re-Entry Internal" required />
                        </div>

                        <div class="w-full">
                            <InputLabel value="Pre Harvest Interval (Days)" />
                            <p class="text-gray-400 text-[11px]">Stop agrochemical use before harvest</p>
                            <TextInput id="name" type="number" v-model="formData.pre_harvest_interval"
                                class="mt-1 block w-full" placeholder="Pre Harvest Interval" required />
                        </div>
                    </div>

                    <div class="mb-4">
                        <InputLabel value="Satety Precautions" />
                        <TextInput id="name" type="text" v-model="formData.safety_precautions" class="mt-1 block w-full"
                            placeholder="Satety Precautions" required />
                    </div>

                    <div class="mb-4">
                        <InputLabel value="Mixing Compatibility" />
                        <TextInput id="name" type="text" v-model="formData.mixing_compatibility"
                            class="mt-1 block w-full" placeholder="Mixing Compatibility" required />
                    </div>

                    <div class="mt-6 text-gray-500 flex justify-end space-x-4">
                        <CancelButton @click="showCreateAgrochemicalModal = false">
                            Cancel
                        </CancelButton>
                        <PrimaryButton @click="createAgrochemical">
                            Create
                        </PrimaryButton>
                    </div>
                </div>
            </div>

            <!-- Table of Agrochemicals -->
            <div class="mt-4" v-if="paginatedAgrochemicals && paginatedAgrochemicals.length > 0">
                <div class="rounded-lg overflow-x-auto">
                    <table class="min-w-full text-sm text-black">
                        <thead class="bg-white border-b-2 border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium w-28 whitespace-nowrap">ID</th>
                                <th class="px-4 py-4 text-left text-xs font-medium w-40 whitespace-nowrap">Name
                                </th>
                                <th class="px-4 py-4 text-left text-xs font-medium w-40 whitespace-nowrap">Dosage
                                </th>
                                <th class="px-4 py-4 text-left text-xs font-medium w-40 whitespace-nowrap">
                                    Category
                                </th>
                                <th class="px-4 py-4 text-left text-xs font-medium w-40 whitespace-nowrap">
                                    Application
                                    Method</th>
                                <th class="px-4 py-4 text-left text-xs font-medium w-40 whitespace-nowrap">
                                    Toxicity
                                    Level</th>
                                <th class="px-4 py-4 text-left text-xs font-medium w-40 whitespace-nowrap">
                                    Re-Entry
                                    Interval</th>
                                <th class="px-4 py-4 text-left text-xs font-medium w-40 whitespace-nowrap">Pre-Harvest
                                    Interval</th>
                                <th class="px-6 py-4 text-right text-xs font-medium w-28 whitespace-nowrap">Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="agrochemical in paginatedAgrochemicals" :key="agrochemical.id"
                                class="cursor-pointer">
                                <td class="px-6 py-2 text-xs text-gray-500 w-28" @click="openDrawer(agrochemical)">{{
                                    agrochemical.id }}</td>
                                <td class="px-4 py-2 text-xs text-gray-500 w-40" @click="openDrawer(agrochemical)">{{
                                    agrochemical.name }}</td>
                                <td class="px-4 py-2 text-xs text-gray-500 w-40" @click="openDrawer(agrochemical)">{{
                                    agrochemical.recommended_dosage }}
                                </td>
                                <td class="px-4 py-2 text-xs text-gray-500 w-40" @click="openDrawer(agrochemical)">{{
                                    agrochemical.category }}</td>
                                <td class="px-4 py-2 text-xs text-gray-500 w-40" @click="openDrawer(agrochemical)">{{
                                    agrochemical.application_method }}
                                </td>
                                <td class="px-4 py-2 text-xs text-gray-500 w-40" @click="openDrawer(agrochemical)">{{
                                    agrochemical.toxicity_level }}</td>
                                <td class="px-4 py-2 text-xs text-gray-500 w-40" @click="openDrawer(agrochemical)">{{
                                    agrochemical.reentry_interval }}</td>
                                <td class="px-4 py-2 text-xs text-gray-500 w-40" @click="openDrawer(agrochemical)">{{
                                    agrochemical.pre_harvest_interval }}
                                </td>
                                <td class="pr-6 py-2 text-xs text-gray-500 space-x-4 flex items-center justify-end">
                                    <!-- Delete button and modal -->
                                    <div>
                                        <PrimaryButton @click="openDeleteModal(agrochemical)" :disabled="true"
                                            class="cursor-not-allowed bg-gray-200 hover:bg-gray-300 text-gray-700 opacity-50">
                                            Delete
                                        </PrimaryButton>

                                        <div v-if="showDeleteModal"
                                            class="fixed z-50 inset-0 flex items-center justify-center">
                                            <!-- Black overlay (backdrop) -->
                                            <div class="fixed inset-0 bg-black/10"></div>

                                            <!-- Modal content -->
                                            <div class="relative bg-white rounded p-6 w-full max-w-sm z-50">
                                                <h3 class="text-black text-lg font-semibold mb-4">Confirm Delete</h3>
                                                <p>Are you sure you want to delete this agrochemical?</p>

                                                <div class="mt-6 flex justify-end space-x-4">
                                                    <CancelButton @click="showDeleteModal = false">Cancel</CancelButton>
                                                    <DangerButton @click="deleteAgrochemical(selectedAgrochemical)">
                                                        Delete
                                                    </DangerButton>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Edit button and modal -->
                                    <div>
                                        <SecondaryButton @click="openEditModal(agrochemical)">Edit</SecondaryButton>

                                        <div v-if="showEditModal"
                                            class="fixed z-50 inset-0 flex items-center justify-center">
                                            <!-- Black overlay (backdrop) -->
                                            <div class="fixed inset-0 bg-black/10"></div>

                                            <!-- Modal content -->
                                            <div class="relative bg-white rounded p-6 w-full max-w-lg z-50">
                                                <h3 class="text-black text-lg font-semibold mb-4">Edit Agrochemical</h3>

                                                <div class="mb-4">
                                                    <InputLabel value="Agrochemical Name" />
                                                    <TextInput id="name" type="text" v-model="editForm.name"
                                                        class="mt-1 block w-full" placeholder="Agrochemical Name"
                                                        required />
                                                </div>

                                                <div class="mb-4">
                                                    <InputLabel value="Recommended Dosage" />
                                                    <p class="text-gray-400 text-[11px]">Dosage per 1500 Litre</p>
                                                    <TextInput id="name" type="text"
                                                        v-model="editForm.recommended_dosage" class="mt-1 block w-full"
                                                        placeholder="Recommended Dosage" required />
                                                </div>

                                                <div class="flex space-x-4 mb-4">
                                                    <div class="w-full">
                                                        <InputLabel value="Manufacturer" />
                                                        <TextInput id="name" type="text" v-model="editForm.manufacturer"
                                                            class="mt-1 block w-full" placeholder="Manufacturer"
                                                            required />
                                                    </div>

                                                    <div class="w-full">
                                                        <InputLabel value="Category" />
                                                        <select v-model="editForm.category"
                                                            class="text-black w-full text-xs mt-1 placeholder:text-xs border-gray-300 focus:border-[#BCDA84] focus:ring-[#BCDA84] rounded"
                                                            required>
                                                            <option value="Herbicide">Herbicide</option>
                                                            <option value="Pesticide">Pesticide</option>
                                                            <option value="Fungicide">Fungicide</option>
                                                            <option value="Fertilizer">Fertilizer</option>
                                                            <option value="Growth Regulator">Growth Regulator</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="flex space-x-4 mb-4">
                                                    <div class="w-full">
                                                        <InputLabel value="Application Method" />
                                                        <select v-model="editForm.application_method"
                                                            class="w-full text-xs mt-1 placeholder:text-xs border-gray-300 focus:border-[#BCDA84] focus:ring-[#BCDA84] rounded"
                                                            required>
                                                            <option value="Spray">Spray</option>
                                                            <option value="Granular">Granular</option>
                                                            <option value="Drip">Drip</option>
                                                            <option value="Foliar">Foliar</option>
                                                        </select>
                                                    </div>

                                                    <div class="w-full">
                                                        <InputLabel value="Toxicity Level" />
                                                        <select v-model="editForm.toxicity_level"
                                                            class="w-full text-xs mt-1 placeholder:text-xs border-gray-300 focus:border-[#BCDA84] focus:ring-[#BCDA84] rounded"
                                                            required>
                                                            <option value="Low">Low</option>
                                                            <option value="Medium">Medium</option>
                                                            <option value="High">High</option>
                                                        </select>
                                                    </div>

                                                    <div class="w-full">
                                                        <InputLabel value="Restricted Use" />
                                                        <select v-model="editForm.restricted_use"
                                                            class="w-full text-xs mt-1 placeholder:text-xs border-gray-300 focus:border-[#BCDA84] focus:ring-[#BCDA84] rounded"
                                                            required>
                                                            <option :value="true">Yes</option>
                                                            <option :value="false">No</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="mb-4">
                                                    <InputLabel value="Recommended Application Frequency" />
                                                    <p class="text-gray-400 text-[11px]">Weekly, Bi-Weekly or Monthly
                                                    </p>
                                                    <TextInput id="name" type="text"
                                                        v-model="editForm.recommended_application_frequency"
                                                        class="mt-1 block w-full"
                                                        placeholder="Recommended Application Frequency" required />
                                                </div>

                                                <div class="flex space-x-4 mb-4">
                                                    <div class="w-full">
                                                        <InputLabel value="Re-Entry Internal" />
                                                        <p class="text-gray-400 text-[11px]">Enter field only after safe
                                                            time elapses</p>
                                                        <TextInput id="name" type="number"
                                                            v-model="editForm.reentry_interval"
                                                            class="mt-1 block w-full" placeholder="Re-Entry Internal"
                                                            required />
                                                    </div>

                                                    <div class="w-full">
                                                        <InputLabel value="Pre Harvest Interval" />
                                                        <p class="text-gray-400 text-[11px]">Stop agrochemical use
                                                            before harvest</p>
                                                        <TextInput id="name" type="number"
                                                            v-model="editForm.pre_harvest_interval"
                                                            class="mt-1 block w-full" placeholder="Pre Harvest Interval"
                                                            required />
                                                    </div>
                                                </div>

                                                <div class="mb-4">
                                                    <InputLabel value="Satety Precautions" />
                                                    <TextInput id="name" type="text"
                                                        v-model="editForm.safety_precautions" class="mt-1 block w-full"
                                                        placeholder="Satety Precautions" required />
                                                </div>

                                                <div class="mb-4">
                                                    <InputLabel value="Mixing Compatibility" />
                                                    <TextInput id="name" type="text"
                                                        v-model="editForm.mixing_compatibility"
                                                        class="mt-1 block w-full" placeholder="Mixing Compatibility"
                                                        required />
                                                </div>

                                                <div class="mt-6 flex justify-end space-x-4">
                                                    <CancelButton @click="showEditModal = false">Cancel</CancelButton>
                                                    <PrimaryButton @click="editAgrochemical(selectedAgrochemical)">
                                                        Update
                                                    </PrimaryButton>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Load More Button -->
                <div class="flex justify-center mt-4">
                    <button v-if="displayedItems < filteredAgrochemicals.length" @click="loadMore"
                        class="px-4 py-2 rounded bg-[#BCDA84] hover:bg-green-600">
                        Load More
                    </button>
                </div>
            </div>

            <!-- If no agrochemicals found -->
            <div v-else>
                <p>No agrochemicals found</p>
            </div>

            <div v-if="showDrawer">
                <!-- Black overlay (backdrop) -->
                <div class="fixed inset-0 bg-black/50 z-40" @click="showDrawer = false"></div>

                <!-- Drawer Content -->
                <div class="fixed inset-y-0 right-0 w-[35%] bg-white shadow-lg z-50 flex flex-col h-full">
                    <!-- Header with Close Button -->
                    <div class="py-4 px-8 border-b border-gray-200 flex items-center justify-between">
                        <h3 class="text-lg font-medium">Agrochemical Details</h3>
                        <button @click="showDrawer = false" class="text-gray-600 hover:text-gray-800">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6">
                                <path stroke-linecap="square" stroke-linejoin="square" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Drawer Body - Scrollable Content -->
                    <div class="py-4 px-8 space-y-4 overflow-y-auto flex-1">
                        <!-- Agrochemical Name -->
                        <div class="mb-4">
                            <InputLabel value="Agrochemical Name" />
                            <TextInput id="name" type="text" :value="selectedAgrochemical.name"
                                class="mt-1 block w-full" placeholder="Agrochemical Name" disabled />
                        </div>

                        <!-- Recommended Dosage -->
                        <div class="mb-4">
                            <InputLabel value="Recommended Dosage" />
                            <p class="text-gray-400 text-[11px]">Dosage per 1500 Litre</p>
                            <TextInput id="recommended_dosage" type="text"
                                :value="selectedAgrochemical.recommended_dosage" class="mt-1 block w-full"
                                placeholder="Recommended Dosage" disabled />
                        </div>

                        <!-- Manufacturer and Category -->
                        <div class="flex space-x-4 mb-4">
                            <div class="w-full">
                                <InputLabel value="Manufacturer" />
                                <TextInput id="manufacturer" type="text" :value="selectedAgrochemical.manufacturer"
                                    class="mt-1 block w-full" placeholder="Manufacturer" disabled />
                            </div>

                            <div class="w-full">
                                <InputLabel value="Category" />
                                <select :value="selectedAgrochemical.category"
                                    class="w-full text-xs mt-1 placeholder:text-xs border-gray-300 focus:border-[#BCDA84] focus:ring-[#BCDA84] rounded"
                                    disabled>
                                    <option value="Herbicide">Herbicide</option>
                                    <option value="Pesticide">Pesticide</option>
                                    <option value="Fungicide">Fungicide</option>
                                    <option value="Fertilizer">Fertilizer</option>
                                    <option value="Growth Regulator">Growth Regulator</option>
                                </select>
                            </div>
                        </div>

                        <!-- Application Method, Toxicity Level, Restricted Use -->
                        <div class="flex space-x-4 mb-4">
                            <div class="w-full">
                                <InputLabel value="Application Method" />
                                <select :value="selectedAgrochemical.application_method"
                                    class="w-full text-xs mt-1 placeholder:text-xs border-gray-300 focus:border-[#BCDA84] focus:ring-[#BCDA84] rounded"
                                    disabled>
                                    <option value="Spray">Spray</option>
                                    <option value="Granular">Granular</option>
                                    <option value="Drip">Drip</option>
                                    <option value="Foliar">Foliar</option>
                                </select>
                            </div>

                            <div class="w-full">
                                <InputLabel value="Toxicity Level" />
                                <select :value="selectedAgrochemical.toxicity_level"
                                    class="w-full text-xs mt-1 placeholder:text-xs border-gray-300 focus:border-[#BCDA84] focus:ring-[#BCDA84] rounded"
                                    disabled>
                                    <option value="Low">Low</option>
                                    <option value="Medium">Medium</option>
                                    <option value="High">High</option>
                                </select>
                            </div>

                            <div class="w-full">
                                <InputLabel value="Restricted Use" />
                                <select :value="selectedAgrochemical.restricted_use"
                                    class="w-full text-xs mt-1 placeholder:text-xs border-gray-300 focus:border-[#BCDA84] focus:ring-[#BCDA84] rounded"
                                    disabled>
                                    <option :value="true">Yes</option>
                                    <option :value="false">No</option>
                                </select>
                            </div>
                        </div>

                        <!-- Recommended Application Frequency -->
                        <div class="mb-4">
                            <InputLabel value="Recommended Application Frequency" />
                            <p class="text-gray-400 text-[11px]">Weekly, Bi-Weekly or Monthly</p>
                            <TextInput id="recommended_application_frequency" type="text"
                                :value="selectedAgrochemical.recommended_application_frequency"
                                class="mt-1 block w-full" placeholder="Recommended Application Frequency" disabled />
                        </div>

                        <!-- Re-Entry Interval and Pre-Harvest Interval -->
                        <div class="flex space-x-4 mb-4">
                            <div class="w-full">
                                <InputLabel value="Re-Entry Interval" />
                                <p class="text-gray-400 text-[11px]">Enter field only after safe time elapses</p>
                                <TextInput id="reentry_interval" type="number"
                                    :value="selectedAgrochemical.reentry_interval" class="mt-1 block w-full"
                                    placeholder="Re-Entry Interval" disabled />
                            </div>

                            <div class="w-full">
                                <InputLabel value="Pre-Harvest Interval" />
                                <p class="text-gray-400 text-[11px]">Stop agrochemical use before harvest</p>
                                <TextInput id="pre_harvest_interval" type="number"
                                    :value="selectedAgrochemical.pre_harvest_interval" class="mt-1 block w-full"
                                    placeholder="Pre-Harvest Interval" disabled />
                            </div>
                        </div>

                        <!-- Safety Precautions -->
                        <div class="mb-4">
                            <InputLabel value="Safety Precautions" />
                            <TextInput id="safety_precautions" type="text"
                                :value="selectedAgrochemical.safety_precautions" class="mt-1 block w-full"
                                placeholder="Safety Precautions" disabled />
                        </div>

                        <!-- Mixing Compatibility -->
                        <div class="mb-4">
                            <InputLabel value="Mixing Compatibility" />
                            <TextInput id="mixing_compatibility" type="text"
                                :value="selectedAgrochemical.mixing_compatibility" class="mt-1 block w-full"
                                placeholder="Mixing Compatibility" disabled />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import axios from 'axios';
import AppLayout from '@/Layouts/AppLayout.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import CancelButton from '@/Components/CancelButton.vue';
import { toast } from 'vue3-toastify';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const { agrochemicals, agrochemicalsCount } = defineProps({
    agrochemicals: Array,
    agrochemicalsCount: Number,
});

const searchTerm = ref('');
const displayedItems = ref(10);
const showCreateAgrochemicalModal = ref(false);
const showDrawer = ref(false);
const selectedAgrochemical = ref(null);

const formData = ref({
    name: '',
    recommended_dosage: '',
    category: '',
    mixing_category: '',
    manufacturer: '',
    application_method: '',
    toxicity_level: '',
    restricted_use: '',
    recommended_application_frequency: '',
    reentry_interval: '',
    pre_harvest_interval: '',
    safety_precautions: '',
    mixing_compatibility: '',
});

const filteredAgrochemicals = computed(() => {
    if (!searchTerm.value) return agrochemicals;
    const term = searchTerm.value.toLowerCase();
    return agrochemicals.filter(agrochemical =>
        agrochemical.name.toLowerCase().includes(term) ||
        agrochemical.category.toLowerCase().includes(term) ||
        agrochemical.manufacturer.toLowerCase().includes(term)
    );
});

const paginatedAgrochemicals = computed(() => filteredAgrochemicals.value.slice(0, displayedItems.value));

const loadMore = () => { displayedItems.value += 10; };

const createAgrochemical = async () => {
    try {
        const response = await axios.post('/agrochemical/store', formData.value);
        showCreateAgrochemicalModal.value = false;

        toast("Record created successfully!", {
            theme: "colored",
            type: "success",
            position: "top-center",
            hideProgressBar: true,
            transition: "zoom"
        });

        window.location.reload();
    } catch (error) {
        toast("Error creating agrochemical!", { theme: "colored", type: "error", position: "top-center", hideProgressBar: true, transition: "zoom" });
        console.error("Error:", error);
    }
};

const openDrawer = (agrochemical) => {
    selectedAgrochemical.value = agrochemical;
    showDrawer.value = true;
};

const showDeleteModal = ref(false);
const showEditModal = ref(false);

// The editable fields in a crop record
const editForm = ref({
    name: '',
    recommended_dosage: '',
    category: '',
    mixing_category: '',
    manufacturer: '',
    application_method: '',
    toxicity_level: '',
    restricted_use: '',
    recommended_application_frequency: '',
    reentry_interval: '',
    pre_harvest_interval: '',
    safety_precautions: '',
    mixing_compatibility: '',
});

// Open the delete modal for the selected crop
function openDeleteModal(agrochemical) {
    selectedAgrochemical.value = agrochemical;
    showDeleteModal.value = true;
}

// Delete the crop
const deleteAgrochemical = async (agrochemical) => {
    try {
        await axios.delete(`/agrochemical/${agrochemical.id}`); // Correct path
        showDeleteModal.value = false;

        toast("Deleted successfully!", {
            theme: "colored",
            type: "success",
            position: "top-center",
            hideProgressBar: true,
            transition: "zoom",
        });

        window.location.reload();
    } catch (error) {
        toast("Error deleting record!", {
            theme: "colored",
            type: "error",
            position: "top-center",
            hideProgressBar: true,
            transition: "zoom",
        });
        console.error("Error deleting agrochemical:", error);
    }
};

// Open the edit modal for the selected crop and pre-fill form data
function openEditModal(agrochemical) {
    selectedAgrochemical.value = agrochemical;
    editForm.value = {
        name: agrochemical.name,
        recommended_dosage: agrochemical.recommended_dosage,
        category: agrochemical.category,
        mixing_category: agrochemical.mixing_category,
        manufacturer: agrochemical.manufacturer,
        application_method: agrochemical.application_method,
        toxicity_level: agrochemical.toxicity_level,
        restricted_use: agrochemical.restricted_use,
        recommended_application_frequency: agrochemical.recommended_application_frequency,
        reentry_interval: agrochemical.reentry_interval,
        pre_harvest_interval: agrochemical.pre_harvest_interval,
        safety_precautions: agrochemical.safety_precautions,
        mixing_compatibility: agrochemical.mixing_compatibility,
    };
    showEditModal.value = true;
}

const editAgrochemical = async (agrochemical) => {
    try {
        const response = await axios.put(`/agrochemical/${agrochemical.id}`, {
            name: editForm.value.name,
            recommended_dosage: editForm.value.recommended_dosage,
            category: editForm.value.category,
            mixing_category: editForm.value.mixing_category,
            manufacturer: editForm.value.manufacturer,
            application_method: editForm.value.application_method,
            toxicity_level: editForm.value.toxicity_level,
            restricted_use: editForm.value.restricted_use,
            recommended_application_frequency: editForm.value.recommended_application_frequency,
            reentry_interval: editForm.value.reentry_interval,
            pre_harvest_interval: editForm.value.pre_harvest_interval,
            safety_precautions: editForm.value.safety_precautions,
            mixing_compatibility: editForm.value.mixing_compatibility,
        });

        showEditModal.value = false;

        toast("Record edited successfully!", {
            "theme": "colored",
            "type": "success",
            "position": "top-center",
            "hideProgressBar": true,
            "transition": "zoom",
        })

        window.location.reload();
        // alert('User updated successfully');
    } catch (error) {
        toast("Error editing record!", {
            "theme": "colored",
            "type": "error",
            "position": "top-center",
            "hideProgressBar": true,
            "transition": "zoom",
        })

        // alert('Error updating user');
    }
};
</script>