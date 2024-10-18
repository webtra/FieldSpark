<template>

    <Head :title="title" />

    <div class="min-h-screen flex flex-col">
        <!-- Navigation and sidebar code -->
        <nav class="lg:hidden py-4 px-4 bg-gray-900">
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
            <div @click="toggleMobileNav" class="fixed lg:hidden inset-0 bg-gray-900 opacity-0"></div>
            <nav
                class="fixed top-16 lg:top-0 left-0 bottom-0 flex flex-col w-full lg:w-80 sm:max-w-xs py-4 bg-gray-900 overflow-y-auto z-50">
                <div class="px-4">
                    <!-- Desktop Logo -->
                    <a class="hidden lg:flex lg:justify-center text-lg text-white font-medium" href="#">
                        <p>Logo Here</p>
                    </a>
                </div>
                <div class="px-4 py-8">
                    <ul class="space-y-2">
                        <li>
                            <Link :href="route('dashboard')"
                                class="flex items-center px-4 py-2.5 rounded space-x-3 text-white hover:bg-gray-800/75"
                                :class="{ 'bg-gray-800/75 text-white': $page.url === '/dashboard' }">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="w-5 h-5">
                                <path
                                    d="M11.47 3.841a.75.75 0 0 1 1.06 0l8.69 8.69a.75.75 0 1 0 1.06-1.061l-8.689-8.69a2.25 2.25 0 0 0-3.182 0l-8.69 8.69a.75.75 0 1 0 1.061 1.06l8.69-8.689Z" />
                                <path
                                    d="m12 5.432 8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 0 1-.75-.75v-4.5a.75.75 0 0 0-.75-.75h-3a.75.75 0 0 0-.75.75V21a.75.75 0 0 1-.75.75H5.625a1.875 1.875 0 0 1-1.875-1.875v-6.198a2.29 2.29 0 0 0 .091-.086L12 5.432Z" />
                            </svg>
                            <span class="tracking-wider text-xs">
                                Dashboard
                            </span>
                            </Link>
                        </li>

                        <li>
                            <Link :href="route('cultivar.index')"
                                class="flex items-center px-4 py-2.5 rounded space-x-3 text-white hover:bg-gray-800/75"
                                :class="{ 'bg-gray-800/75 text-white': $page.url === '/cultivar' }">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-5">
                                <path fill-rule="evenodd"
                                    d="M12 3.75a6.715 6.715 0 0 0-3.722 1.118.75.75 0 1 1-.828-1.25 8.25 8.25 0 0 1 12.8 6.883c0 3.014-.574 5.897-1.62 8.543a.75.75 0 0 1-1.395-.551A21.69 21.69 0 0 0 18.75 10.5 6.75 6.75 0 0 0 12 3.75ZM6.157 5.739a.75.75 0 0 1 .21 1.04A6.715 6.715 0 0 0 5.25 10.5c0 1.613-.463 3.12-1.265 4.393a.75.75 0 0 1-1.27-.8A6.715 6.715 0 0 0 3.75 10.5c0-1.68.503-3.246 1.367-4.55a.75.75 0 0 1 1.04-.211ZM12 7.5a3 3 0 0 0-3 3c0 3.1-1.176 5.927-3.105 8.056a.75.75 0 1 1-1.112-1.008A10.459 10.459 0 0 0 7.5 10.5a4.5 4.5 0 1 1 9 0c0 .547-.022 1.09-.067 1.626a.75.75 0 0 1-1.495-.123c.041-.495.062-.996.062-1.503a3 3 0 0 0-3-3Zm0 2.25a.75.75 0 0 1 .75.75c0 3.908-1.424 7.485-3.781 10.238a.75.75 0 0 1-1.14-.975A14.19 14.19 0 0 0 11.25 10.5a.75.75 0 0 1 .75-.75Zm3.239 5.183a.75.75 0 0 1 .515.927 19.417 19.417 0 0 1-2.585 5.544.75.75 0 0 1-1.243-.84 17.915 17.915 0 0 0 2.386-5.116.75.75 0 0 1 .927-.515Z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="tracking-wider text-xs">
                                Cultivar
                            </span>
                            </Link>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>

        <!-- Slot for page-specific content -->
        <main class="flex-grow lg:ml-80  bg-gray-100 text-xs z-10">
            <div class="bg-white px-4 py-2 md:sticky top-0 shadow-sm">
                <div class="flex items-center justify-between">
                    <p class="font-medium text-lg text-black">{{ $page.props.page_name }}</p>
                    <div class="flex items-center -mr-1 md:-mr-0">
                        <!-- Settings Dropdown -->
                        <div class="relative">
                            <Dropdown align="right" width="48">
                                <template #trigger>
                                    <button v-if="$page.props.jetstream.managesProfilePhotos"
                                        class="flex text-xs border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                        <img class="h-10 w-10 rounded-full object-cover"
                                            :src="$page.props.auth.user.profile_photo_url"
                                            :alt="$page.props.auth.user.first_name">
                                    </button>

                                    <span v-else class="inline-flex rounded-md">
                                        <button type="button"
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-xs leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                            {{ $page.props.auth.user.first_name }}

                                            <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                            </svg>
                                        </button>
                                    </span>
                                </template>

                                <template #content>
                                    <!-- Account Management -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        Manage Account
                                    </div>

                                    <DropdownLink :href="route('profile.show')">
                                        Profile
                                    </DropdownLink>

                                    <DropdownLink v-if="$page.props.jetstream.hasApiFeatures"
                                        :href="route('api-tokens.index')">
                                        API Tokens
                                    </DropdownLink>

                                    <div class="border-t border-gray-200" />

                                    <!-- Authentication -->
                                    <form @submit.prevent="logout">
                                        <DropdownLink as="button">
                                            Log Out
                                        </DropdownLink>
                                    </form>
                                </template>
                            </Dropdown>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-4">
                <slot></slot>
            </div>
        </main>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';

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
