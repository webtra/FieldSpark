<template>
    <AppLayout title="Storeroom Dashboard">
        <div class="overflow-x-hidden overflow-y-auto">
            <div class="block md:flex items-center justify-between mb-4">
                <p class="text-sm mt-1 text-black font-medium">
                    <span class="font-bold">Total Value:</span> {{ formatCurrency(totalValue) }}
                </p>
                <div class="mt-4 md:mt-0 flex items-center space-x-2 md:space-x-4">
                    <TextInput type="text" v-model="search" placeholder="Search" class="w-96" />
                    <div class="w-full md:w-fit">
                        <Link
                            :href="`/storerooms/${storeroom.id}/dashboard/create/item`">
                            <PrimaryButton>Add Item</PrimaryButton>
                        </Link>
                    </div>
                </div>
            </div>
        </div>

        <!-- Items Table -->
        <div class="rounded-lg overflow-x-auto">
            <table class="min-w-full table-fixed border-collapse">
                <thead class="bg-white border-b-2 border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-medium w-20">ID</th>
                    <th class="px-6 py-4 text-left text-xs font-medium w-48">Name</th>
                    <th class="px-6 py-4 text-left text-xs font-medium w-24">Quantity</th>
                    <th class="px-6 py-4 text-left text-xs font-medium w-24">Price</th>
                    <th class="px-6 py-4 text-left text-xs font-medium w-36">Total Value</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="inventory in items" :key="inventory.id">
                    <td class="px-6 py-2 text-xs text-gray-500">{{ inventory.item.id }}</td>
                    <td class="px-6 py-2 text-xs text-gray-500">{{ inventory.item.name }}</td>
                    <td class="px-6 py-2 text-xs text-gray-500">{{ inventory.quantity }}</td>
                    <td class="px-6 py-2 text-xs text-gray-500">
                        {{ inventory.prices.length ? formatCurrency(inventory.prices[inventory.prices.length - 1].price) : 'N/A' }}
                    </td>
                    <td class="px-6 py-2 text-xs text-gray-500">
                        {{
                            inventory.prices.length
                                ? formatCurrency(inventory.quantity * inventory.prices[inventory.prices.length - 1].price)
                                : 'N/A'
                        }}
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </AppLayout>
</template>

<script setup>
import { defineProps, ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {Link} from "@inertiajs/vue3";

const search = ref("");

const props = defineProps({
    storeroom: Object,
    items: Array,
    totalValue: Number,
});

const formatCurrency = (value) => {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'ZAR', // Adjust to your currency
    }).format(value);
};
</script>
