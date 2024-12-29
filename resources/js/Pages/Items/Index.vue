<template>
    <AppLayout title="Items">

        <div class="overflow-x-hidden overflow-y-auto">
            <div class="block md:flex items-center justify-between mb-4">
                <p class="text-sm mt-1 text-black font-medium">
                    <span class="font-bold">Total Items:</span> {{ filteredItems.length }}
                    (Filtered from {{ itemCount }})
                </p>
                <div class="mt-4 md:mt-0 flex items-center space-x-2 md:space-x-4">
                    <TextInput type="text" v-model="search" placeholder="Search" class="w-96" />
                    <div class="w-full md:w-fit">
                        <Link :href="route('items.create')">
                            <PrimaryButton>Add Item</PrimaryButton>
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref, computed } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {Link} from "@inertiajs/vue3";

const { items, itemCount } = defineProps({
    items: Array,
    itemCount: Number,
});

const search = ref("");

const filteredItems = computed(() => {
    return items.filter((item) => {
        return item.name.toLowerCase().includes(search.value.toLowerCase());
    });
});
</script>
