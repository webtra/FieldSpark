<template>
    <AppLayout title="Add Item">
        <div class="block md:flex items-center justify-between mb-4">
            <p class="text-sm mt-1 text-black font-medium">
               {{ createForm.name }}
            </p>
            <div class="mt-4 md:mt-0">
                <div class="w-full md:w-fit">
                    <PrimaryButton @click="submitForm">Save Item</PrimaryButton>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Item Details Section -->
            <div class="bg-white rounded-lg h-fit">
                <div class="border-b-2 border-gray-200 rounded-t-lg">
                    <p class="px-6 py-4 text-left text-xs font-medium text-gray-600">Item Details</p>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <InputLabel for="name" value="Name" />
                        <TextInput
                            id="name"
                            type="text"
                            v-model="createForm.name"
                            class="mt-1 block w-full"
                            placeholder="Name"
                            required
                        />
                    </div>

                    <div class="mb-4">
                        <InputLabel value="Storeroom" />
                        <select
                            v-model="createForm.storeroom_id"
                            class="w-full text-xs mt-1 placeholder:text-xs border-gray-300 focus:ring-[#BCDA84] focus:border-[#BCDA84] rounded-lg"
                            required
                        >
                            <option value="" disabled>Select a Storeroom</option>
                            <option v-for="storeroom in storerooms" :key="storeroom.id" :value="storeroom.id">
                                {{ storeroom.name }}
                            </option>
                        </select>
                    </div>

                    <div class="flex items-center space-x-4">
                        <div class="w-full">
                            <InputLabel for="unit" value="Unit" />
                            <select
                                id="unit"
                                v-model="createForm.unit"
                                class="w-full text-xs mt-1 placeholder:text-xs border-gray-300 focus:ring-[#BCDA84] focus:border-[#BCDA84] rounded-lg"
                            >
                                <option value="" disabled>Select Unit</option>
                                <option value="g">g</option>
                                <option value="kg">kg</option>
                                <option value="ml">ml</option>
                                <option value="l">l</option>
                            </select>
                        </div>

                        <div class="w-full">
                            <InputLabel for="size" value="Size" />
                            <TextInput
                                id="size"
                                type="number"
                                v-model="createForm.size"
                                class="mt-1 block w-full"
                                placeholder="Size"
                                required
                            />
                        </div>

                        <div class="w-full">
                            <InputLabel for="quantity" value="Quantity" />
                            <TextInput
                                id="quantity"
                                type="number"
                                v-model="createForm.quantity"
                                class="mt-1 block w-full"
                                placeholder="Quantity"
                                required
                            />
                        </div>
                    </div>

                    <div>
                        <InputLabel for="description" value="Description" />
                        <textarea
                            id="description"
                            v-model="createForm.description"
                            class="w-full text-xs mt-1 placeholder:text-xs border-gray-300 focus:ring-[#BCDA84] focus:border-[#BCDA84] rounded-lg"
                            placeholder="Description"
                            rows="3"
                        ></textarea>
                    </div>

                    <div>
                        <InputLabel for="recommended_dosage" value="Recommended Dosage" />
                        <p class="text-gray-400 text-[11px]">Dosage per 1500 Litre</p>
                        <TextInput
                            id="recommended_dosage"
                            type="number"
                            step="0.01"
                            v-model="createForm.recommended_dosage"
                            class="mt-1 block w-full"
                            placeholder="Recommended Dosage"
                        />
                    </div>

                    <div class="flex space-x-4 items-center">
                        <div class="w-full">
                            <InputLabel value="Category" />
                            <select v-model="createForm.category"
                                    class="w-full text-xs mt-1 placeholder:text-xs border-gray-300 focus:border-[#BCDA84] focus:ring-[#BCDA84] rounded-lg"
                                    required>
                                <option value="" disabled>Select Category</option>
                                <option value="Herbicide">Herbicide</option>
                                <option value="Pesticide">Pesticide</option>
                                <option value="Fungicide">Fungicide</option>
                                <option value="Fertilizer">Fertilizer</option>
                                <option value="Growth Regulator">Growth Regulator</option>
                            </select>
                        </div>

                        <div class="w-full">
                            <InputLabel value="Mixing Category" />
                            <select v-model="createForm.mixing_category"
                                    class="w-full text-xs mt-1 placeholder:text-xs border-gray-300 focus:border-[#BCDA84] focus:ring-[#BCDA84] rounded-lg"
                                    required>
                                <option value="" disabled>Select Mixing Category</option>
                                <option value="Water">1 - Water</option>
                                <option value="Water Quality Regulators">2 - Water Quality Regulators</option>
                                <option value="Water-Soluble Packets">3 - Water Soluble Packets</option>
                                <option value="Dry Formulations">4 - Dry Formulations</option>
                                <option value="Suspension Concentrates">5 - Suspension Concentrates</option>
                                <option value="Emulsifiable Concentrates">6 - Emulsifiable Concentrates</option>
                                <option value="Adhesives">7 - Adhesives</option>
                                <option value="Water-Soluble Liquids">8 - Water-Soluble Liquids</option>
                                <option value="Foliar Feedings">9 - Foliar Feedings</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex space-x-4 mb-4">
                        <div class="w-full">
                            <InputLabel value="Application Method" />
                            <select v-model="createForm.application_method"
                                    class="w-full text-xs mt-1 placeholder:text-xs border-gray-300 focus:border-[#BCDA84] focus:ring-[#BCDA84] rounded-lg"
                                    required>
                                <option value="" disabled>Select Application Method</option>
                                <option value="Spray">Spray</option>
                                <option value="Granular">Granular</option>
                                <option value="Drip">Drip</option>
                                <option value="Foliar">Foliar</option>
                            </select>
                        </div>

                        <div class="w-full">
                            <InputLabel value="Toxicity Level" />
                            <select v-model="createForm.toxicity_level"
                                    class="w-full text-xs mt-1 placeholder:text-xs border-gray-300 focus:border-[#BCDA84] focus:ring-[#BCDA84] rounded-lg"
                                    required>
                                <option value="" disabled>Select Toxicity Level</option>
                                <option value="Low">Low</option>
                                <option value="Medium">Medium</option>
                                <option value="High">High</option>
                            </select>
                        </div>

                        <div class="w-full">
                            <InputLabel value="Restricted Use" />
                            <select v-model="createForm.restricted_use"
                                    class="w-full text-xs mt-1 placeholder:text-xs border-gray-300 focus:border-[#BCDA84] focus:ring-[#BCDA84] rounded-lg"
                                    required>
                                <option :value="true">Yes</option>
                                <option :value="false">No</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <InputLabel value="Recommended Application Frequency" />
                        <p class="text-gray-400 text-[11px]">Weekly, Bi-Weekly or Monthly</p>
                        <TextInput id="name" type="text" v-model="createForm.recommended_application_frequency"
                                   class="mt-1 block w-full" placeholder="Recommended Application Frequency" required />
                    </div>

                    <div class="flex space-x-4 mb-4">
                        <div class="w-full">
                            <InputLabel value="Re-Entry Internal (Hours)" />
                            <p class="text-gray-400 text-[11px]">Enter field only after safe time elapses</p>
                            <TextInput id="name" type="number" v-model="createForm.reentry_interval"
                                       class="mt-1 block w-full" placeholder="Re-Entry Internal" required />
                        </div>

                        <div class="w-full">
                            <InputLabel value="Pre-Harvest Interval (Days)" />
                            <p class="text-gray-400 text-[11px]">Stop agrochemical use before harvest</p>
                            <TextInput id="name" type="number" v-model="createForm.pre_harvest_interval"
                                       class="mt-1 block w-full" placeholder="Pre-Harvest Interval" required />
                        </div>
                    </div>

                    <div class="mb-4">
                        <InputLabel value="Satety Precautions" />
                        <TextInput id="name" type="text" v-model="createForm.safety_precautions" class="mt-1 block w-full"
                                   placeholder="Satety Precautions" required />
                    </div>

                    <div class="mb-4">
                        <InputLabel value="Mixing Compatibility" />
                        <TextInput id="name" type="text" v-model="createForm.mixing_compatibility"
                                   class="mt-1 block w-full" placeholder="Mixing Compatibility" required />
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <!-- Item Pricing Section -->
                <div class="bg-white rounded-lg h-fit">
                    <div class="border-b-2 border-gray-200 rounded-t-lg">
                        <p class="px-6 py-4 text-left text-xs font-medium text-gray-600">Item Pricing</p>
                    </div>

                    <div class="p-6 space-y-4">
                        <div class="flex items-center space-x-4">
                            <div class="w-full">
                                <InputLabel for="price" value="Purchase Price" />
                                <TextInput
                                    id="price"
                                    type="text"
                                    v-model="createForm.price"
                                    class="mt-1 block w-full"
                                    placeholder="Purchase Price"
                                    required
                                />
                            </div>

                            <div class="w-full">
                                <InputLabel for="date" value="Purchase Date" />
                                <TextInput
                                    id="date"
                                    type="date"
                                    v-model="createForm.date"
                                    class="mt-1 block w-full"
                                    placeholder="Purchase Date"
                                    required
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import {onMounted, ref} from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {toast} from "vue3-toastify";
import axios from "axios";

const props = defineProps({
    storeroom: Object, // The current storeroom passed from the backend
});

const storerooms = ref([]); // All storerooms
const isLoading = ref(false);

const createForm = ref({
    storeroom_id: props.storeroom.id || '',
    name: 'Enter Item Name',
    unit: '',
    quantity: '',
    size: '',
    description: '',
    recommended_dosage: '',
    category: '',
    application_method: '',
    toxicity_level: '',
    restricted_use: false,
    recommended_application_frequency: '',
    reentry_interval: null,
    pre_harvest_interval: null,
    safety_precautions: '',
    mixing_category: '',
    mixing_compatibility: '',
    price: '',
    date: '',
});

const submitForm = async () => {
    if (isLoading.value) return;
    isLoading.value = true;

    // Log form data to the console
    console.log("Form Data Submitted:", createForm.value);

    try {
        const response = await axios.post('/items/store', createForm.value);

        toast("Record created successfully!", {
            theme: "colored",
            type: "success",
            position: "top-center",
            hideProgressBar: true,
            transition: "zoom",
        });

        window.location.reload();
    } catch (error) {
        console.error("Error creating type:", error);

        toast("Error creating record!", {
            theme: "colored",
            type: "error",
            position: "top-center",
            hideProgressBar: true,
            transition: "zoom",
        });
    } finally {
        isLoading.value = false;
    }
};

const fetchStorerooms = async () => {
    try {
        const response = await axios.get("/api/storerooms");
        storerooms.value = response.data.storerooms;
    } catch (error) {
        console.error("Error fetching storerooms:", error);
    }
};

onMounted(fetchStorerooms);
</script>
