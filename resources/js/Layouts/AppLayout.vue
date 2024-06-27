<template>
    <Head :title="title" />

    <div class="min-h-screen flex flex-col">
        <!-- Navigation and sidebar code -->
        <nav class="lg:hidden py-4 px-4 bg-gray-800">
            <div class="flex items-center justify-between">
                <!-- Mobile Logo -->
                <a class="text-lg text-white font-medium" href="#">
                    <p>Logo Here</p>
                </a>
                <button @click="toggleMobileNav" class="flex items-center rounded focus:outline-none">
                    <svg class="text-white h-5 w-5" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor">
                        <title>Mobile menu</title>
                        <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"></path>
                    </svg>
                </button>
            </div>
        </nav>
        <div :class="{ 'block': mobileNavOpen, 'hidden': !mobileNavOpen, 'lg:block': true }" class="relative z-50">
            <div @click="toggleMobileNav" class="fixed lg:hidden inset-0 bg-gray-800 opacity-10"></div>
            <nav
                class="fixed top-10 lg:top-0 left-0 bottom-0 flex flex-col w-full lg:w-80 sm:max-w-xs pt-6 pb-8 bg-gray-800 overflow-y-auto">
                <div class="px-4">
                    <!-- Desktop Logo -->
                    <a class="hidden lg:flex text-lg text-white font-medium" href="#">
                        <p>Logo Here</p>
                    </a>
                </div>
                <!-- Place your sidebar items here -->
            </nav>
        </div>

        <!-- Slot for page-specific content -->
        <main class="flex-grow lg:ml-80 pl-4 pt-4 bg-gray-100">
            <slot></slot>
        </main>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Banner from '@/Components/Banner.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';

defineProps({
    title: String,
});

const showingNavigationDropdown = ref(false);

const switchToTeam = (team) => {
    router.put(route('current-team.update'), {
        team_id: team.id,
    }, {
        preserveState: false,
    });
};

const logout = () => {
    router.post(route('logout'));
};

const mobileNavOpen = ref(false);

function toggleMobileNav() {
    mobileNavOpen.value = !mobileNavOpen.value;
}
</script>
