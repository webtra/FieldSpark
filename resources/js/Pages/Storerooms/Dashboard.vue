<template>
    <AppLayout title="Storeroom Dashboard">
        <div class="overflow-x-hidden overflow-y-auto">
            <!-- Storeroom Name and Controls -->
            <div class="block md:flex items-center justify-between mb-6">
                <p class="text-sm font-medium text-black">
                    {{ storeroom.name }}
                </p>

                <div class="mt-4 md:mt-0 flex items-center space-x-2 md:space-x-4">
                    <TextInput type="text" v-model="search" placeholder="Search" class="w-96" />
                    <div class="w-full md:w-fit">
                        <Link :href="`/storerooms/${storeroom.id}/dashboard/create/item`">
                            <PrimaryButton>Add Item</PrimaryButton>
                        </Link>
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white p-4 rounded-lg">
                    <p class="text-xs text-gray-500 uppercase font-medium">Total Value</p>
                    <p class="text-lg font-semibold text-[#00434b]">{{ formatCurrency(totalValue) }}</p>
                </div>
                <div class="bg-white p-4 rounded-lg">
                    <p class="text-xs text-gray-500 uppercase font-medium">Total Items</p>
                    <p class="text-lg font-semibold text-[#00434b]">{{ items.length }}</p>
                </div>
                <div class="bg-white p-4 rounded-lg">
                    <p class="text-xs text-gray-500 uppercase font-medium">Most Expensive Item</p>
                    <p class="text-lg font-semibold text-[#00434b]">{{ mostExpensiveItem?.name || 'N/A' }}</p>
                </div>
                <div class="bg-white p-4 rounded-lg">
                    <p class="text-xs text-gray-500 uppercase font-medium">Cheapest Item</p>
                    <p class="text-lg font-semibold text-[#00434b]">{{ cheapestItem?.name || 'N/A' }}</p>
                </div>
            </div>

            <!-- Items Table -->
            <div class="rounded-lg overflow-x-auto">
                <table class="min-w-full table-fixed border-collapse">
                    <thead class="bg-white border-b-2 border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-medium w-20">ID</th>
                        <th class="px-6 py-4 text-left text-xs font-medium w-48">Name</th>
                        <th class="px-6 py-4 text-left text-xs font-medium w-24">Unit</th>
                        <th class="px-6 py-4 text-left text-xs font-medium w-24">Size</th>
                        <th class="px-6 py-4 text-left text-xs font-medium w-24">Dosage</th>
                        <th class="px-6 py-4 text-left text-xs font-medium w-24">Quantity</th>
                        <th class="px-6 py-4 text-left text-xs font-medium w-24">Price</th>
                        <th class="px-6 py-4 text-left text-xs font-medium w-36">Total Value</th>
                        <th class="px-6 py-4 text-right text-xs font-medium w-36">Actions</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="inventory in items" :key="inventory.id">
                        <td class="px-6 py-2 text-xs text-gray-500">{{ inventory.item.id }}</td>
                        <td class="px-6 py-2 text-xs text-gray-500">{{ inventory.item.name }}</td>
                        <td class="px-6 py-2 text-xs text-gray-500">{{ inventory.item.unit }}</td>
                        <td class="px-6 py-2 text-xs text-gray-500">{{ inventory.item.size }}</td>
                        <td class="px-6 py-2 text-xs text-gray-500">{{ inventory.item.recommended_dosage }}</td>
                        <td class="px-6 py-2 text-xs text-gray-500">{{ inventory.quantity }}</td>
                        <td class="px-6 py-2 text-xs text-gray-500">
                            {{ inventory.prices.length ? formatCurrency(inventory.prices[inventory.prices.length - 1].price) : 'N/A' }}
                        </td>
                        <td class="px-6 py-2 text-xs text-gray-500">
                            {{ inventory.prices.length ? formatCurrency(inventory.quantity * inventory.prices[inventory.prices.length - 1].price) : 'N/A' }}
                        </td>
                        <td class="px-6 py-2 text-xs text-gray-500">
                            <div class="flex items-center space-x-4 justify-end">
                                <!-- Open Delete Confirmation Modal -->
                                <PrimaryButton class="!w-fit cursor-not-allowed bg-gray-200 hover:bg-gray-300 text-gray-700 opacity-50">Delete</PrimaryButton>
                                <!-- <PrimaryButton class="!z-10 !w-fit cursor-not-allowed bg-gray-200 hover:bg-gray-300 text-gray-700 opacity-50" @click="openDeleteModal(inventory)">Delete</PrimaryButton>-->

                                <!-- Open Edit Modal -->
                                <SecondaryButton class="!w-fit" @click.stop="openEditModal(inventory)">Edit</SecondaryButton>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { defineProps, ref, computed } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Link } from "@inertiajs/vue3";
import SecondaryButton from "@/Components/SecondaryButton.vue";

const search = ref("");

const props = defineProps({
    storeroom: Object,
    items: Array,
    totalValue: Number,
});

// Utility to format currency
const formatCurrency = (value) => {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'ZAR', // Adjust to your currency
    }).format(value);
};

// Compute most expensive item
const mostExpensiveItem = computed(() => {
    return props.items.reduce((max, inventory) => {
        const latestPrice = inventory.prices.length ? inventory.prices[inventory.prices.length - 1].price : 0;
        return latestPrice > (max?.latestPrice || 0) ? { ...inventory.item, latestPrice } : max;
    }, null);
});

// Compute cheapest item
const cheapestItem = computed(() => {
    return props.items.reduce((min, inventory) => {
        const latestPrice = inventory.prices.length ? inventory.prices[inventory.prices.length - 1].price : Infinity;
        return latestPrice < (min?.latestPrice || Infinity) ? { ...inventory.item, latestPrice } : min;
    }, null);
});
</script>
