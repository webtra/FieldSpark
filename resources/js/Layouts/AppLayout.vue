<template>

    <Head :title="title" />

    <div class="min-h-screen flex flex-col">
        <!-- MOBILE -->
        <div>
            <nav class="lg:hidden py-4 px-4 bg-[#00434b]">
                <div class="flex items-center justify-between">
                    <!-- Mobile Logo -->
                    <a href="#">
                        <p class="font-['Epilogue'] items-center text-[25px] text-white font-semibold tracking-wide">
                            <span class="text-[#BCDA84]">field</span>spark
                        </p>
                        <p class="text-white -mt-2 font-medium tracking-widest text-[9px]">by WEBTRA</p>
                    </a>
                    <!-- Toggle Button -->
                    <button @click="toggleMobileNav" class="text-white focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>
                </div>
            </nav>

            <!-- MOBILE DROPDOWN MENU -->
            <div v-show="mobileNavOpen" class="lg:hidden fixed inset-0 z-20">
                <nav class="absolute inset-y-0 w-full bg-[#00434b] text-white overflow-y-auto">
                    <!-- Mobile Logo -->
                    <div class="p-4">
                        <a href="#">
                            <p
                                class="font-['Epilogue'] items-center text-[25px] text-white font-semibold tracking-wide">
                                <span class="text-[#BCDA84]">field</span>spark
                            </p>
                            <p class="text-white -mt-2 font-medium tracking-widest text-[9px]">by WEBTRA</p>
                        </a>
                    </div>

                    <div class="py-4">
                        <ul>
                            <li class="my-1">
                                <span class="ml-4 font-medium tracking-wider text-white/50 text-[10px]">GENERAL</span>
                            </li>

                            <li>
                                <Link :href="route('dashboard.index')"
                                      class="flex items-center pl-6 py-2.5 space-x-3 text-white border-l-4 border-[#00434b] hover:border-[#BCDA84] hover:bg-[#003C43]"
                                      :class="{ 'border-l-4 border-[#BCDA84] bg-[#003C43] text-white': $page.url === '/dashboard' }">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="h-5 w-5" viewBox="0 0 16 16">
                                        <path d="M8 2a.5.5 0 0 1 .5.5V4a.5.5 0 0 1-1 0V2.5A.5.5 0 0 1 8 2M3.732 3.732a.5.5 0 0 1 .707 0l.915.914a.5.5 0 1 1-.708.708l-.914-.915a.5.5 0 0 1 0-.707M2 8a.5.5 0 0 1 .5-.5h1.586a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 8m9.5 0a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 0 1H12a.5.5 0 0 1-.5-.5m.754-4.246a.39.39 0 0 0-.527-.02L7.547 7.31A.91.91 0 1 0 8.85 8.569l3.434-4.297a.39.39 0 0 0-.029-.518z"/>
                                        <path fill-rule="evenodd" d="M6.664 15.889A8 8 0 1 1 9.336.11a8 8 0 0 1-2.672 15.78zm-4.665-4.283A11.95 11.95 0 0 1 8 10c2.186 0 4.236.585 6.001 1.606a7 7 0 1 0-12.002 0"/>
                                    </svg>
                                    <span class="tracking-wider text-xs">
                                Dashboard
                            </span>
                                </Link>
                            </li>

                            <li class="my-1">
                                <span class="ml-4 font-medium tracking-wider text-white/50 text-[10px]">PLANTINGS</span>
                            </li>

                            <li>
                                <Link :href="route('types.index')"
                                      class="flex items-center pl-6 py-2.5 space-x-3 text-white border-l-4 border-[#00434b] hover:border-[#BCDA84] hover:bg-[#003C43]"
                                      :class="{ 'border-l-4 border-[#BCDA84] bg-[#003C43] text-white': $page.url === '/types' }">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                         class="w-5 h-5">
                                        <path
                                            d="M11.47 3.841a.75.75 0 0 1 1.06 0l8.69 8.69a.75.75 0 1 0 1.06-1.061l-8.689-8.69a2.25 2.25 0 0 0-3.182 0l-8.69 8.69a.75.75 0 1 0 1.061 1.06l8.69-8.689Z" />
                                        <path
                                            d="m12 5.432 8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 0 1-.75-.75v-4.5a.75.75 0 0 0-.75-.75h-3a.75.75 0 0 0-.75.75V21a.75.75 0 0 1-.75.75H5.625a1.875 1.875 0 0 1-1.875-1.875v-6.198a2.29 2.29 0 0 0 .091-.086L12 5.432Z" />
                                    </svg>
                                    <span class="tracking-wider text-xs">
                                Types
                            </span>
                                </Link>
                            </li>

                            <li>
                                <Link :href="route('varieties.index')"
                                      class="flex items-center pl-6 py-2.5 space-x-3 text-white border-l-4 border-[#00434b] hover:border-[#BCDA84] hover:bg-[#003C43]"
                                      :class="{ 'border-l-4 border-[#BCDA84] bg-[#003C43] text-white': $page.url === '/varieties' }">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                         class="w-5 h-5">
                                        <path
                                            d="M11.47 3.841a.75.75 0 0 1 1.06 0l8.69 8.69a.75.75 0 1 0 1.06-1.061l-8.689-8.69a2.25 2.25 0 0 0-3.182 0l-8.69 8.69a.75.75 0 1 0 1.061 1.06l8.69-8.689Z" />
                                        <path
                                            d="m12 5.432 8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 0 1-.75-.75v-4.5a.75.75 0 0 0-.75-.75h-3a.75.75 0 0 0-.75.75V21a.75.75 0 0 1-.75.75H5.625a1.875 1.875 0 0 1-1.875-1.875v-6.198a2.29 2.29 0 0 0 .091-.086L12 5.432Z" />
                                    </svg>
                                    <span class="tracking-wider text-xs">
                                Varieties
                            </span>
                                </Link>
                            </li>

                            <li>
                                <Link :href="route('fields.index')"
                                      class="flex items-center pl-6 py-2.5 space-x-3 text-white border-l-4 border-[#00434b] hover:border-[#BCDA84] hover:bg-[#003C43]"
                                      :class="{ 'border-l-4 border-[#BCDA84] bg-[#003C43] text-white': $page.url === '/fields' }">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                         class="w-5 h-5">
                                        <path
                                            d="M11.47 3.841a.75.75 0 0 1 1.06 0l8.69 8.69a.75.75 0 1 0 1.06-1.061l-8.689-8.69a2.25 2.25 0 0 0-3.182 0l-8.69 8.69a.75.75 0 1 0 1.061 1.06l8.69-8.689Z" />
                                        <path
                                            d="m12 5.432 8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 0 1-.75-.75v-4.5a.75.75 0 0 0-.75-.75h-3a.75.75 0 0 0-.75.75V21a.75.75 0 0 1-.75.75H5.625a1.875 1.875 0 0 1-1.875-1.875v-6.198a2.29 2.29 0 0 0 .091-.086L12 5.432Z" />
                                    </svg>
                                    <span class="tracking-wider text-xs">
                                Fields
                            </span>
                                </Link>
                            </li>

                            <li class="my-1">
                                <span class="ml-4 font-medium tracking-wider text-white/50 text-[10px]">INVENTORY</span>
                            </li>

                            <li>
                                <Link :href="route('storerooms.index')"
                                      class="flex items-center pl-6 py-2.5 space-x-3 text-white border-l-4 border-[#00434b] hover:border-[#BCDA84] hover:bg-[#003C43]"
                                      :class="{ 'border-l-4 border-[#BCDA84] bg-[#003C43] text-white': $page.url === '/storerooms' }">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                         class="w-5 h-5">
                                        <path
                                            d="M11.47 3.841a.75.75 0 0 1 1.06 0l8.69 8.69a.75.75 0 1 0 1.06-1.061l-8.689-8.69a2.25 2.25 0 0 0-3.182 0l-8.69 8.69a.75.75 0 1 0 1.061 1.06l8.69-8.689Z" />
                                        <path
                                            d="m12 5.432 8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 0 1-.75-.75v-4.5a.75.75 0 0 0-.75-.75h-3a.75.75 0 0 0-.75.75V21a.75.75 0 0 1-.75.75H5.625a1.875 1.875 0 0 1-1.875-1.875v-6.198a2.29 2.29 0 0 0 .091-.086L12 5.432Z" />
                                    </svg>
                                    <span class="tracking-wider text-xs">
                                Storerooms
                            </span>
                                </Link>
                            </li>
                        </ul>
                    </div>

                    <button @click="toggleMobileNav" class="absolute top-6 z-30 right-4 text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="h-6 w-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </nav>
            </div>
        </div>

        <!-- DESKTOP -->
        <div class="hidden lg:block fixed top-0 left-0 w-64 h-full bg-[#00434b] text-white overflow-y-auto">
            <nav>
                <div class="px-4 pb-3 pt-3">
                    <!-- Desktop Logo -->
                    <a href="#">
                        <p class="font-['Epilogue'] items-center text-[25px] text-white font-semibold tracking-wide">
                            <span class="text-[#BCDA84]">field</span>spark
                        </p>
                        <p class="text-white -mt-2 font-medium tracking-widest text-[9px]">by WEBTRA</p>
                    </a>
                </div>
                <div>
                    <ul>
                        <li class="my-1">
                            <span class="ml-4 font-medium tracking-wider text-white/50 text-[10px]">GENERAL</span>
                        </li>

                        <li>
                            <Link :href="route('dashboard.index')"
                                  class="flex items-center pl-6 py-2.5 space-x-3 text-white border-l-4 border-[#00434b] hover:border-[#BCDA84] hover:bg-[#003C43]"
                                  :class="{ 'border-l-4 border-[#BCDA84] bg-[#003C43] text-white': $page.url === '/dashboard' }">
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

                        <li class="my-1">
                            <span class="ml-4 font-medium tracking-wider text-white/50 text-[10px]">PLANTINGS</span>
                        </li>

                        <li>
                            <Link :href="route('types.index')"
                                  class="flex items-center pl-6 py-2.5 space-x-3 text-white border-l-4 border-[#00434b] hover:border-[#BCDA84] hover:bg-[#003C43]"
                                  :class="{ 'border-l-4 border-[#BCDA84] bg-[#003C43] text-white': $page.url === '/types' }">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                     class="w-5 h-5">
                                    <path
                                        d="M11.47 3.841a.75.75 0 0 1 1.06 0l8.69 8.69a.75.75 0 1 0 1.06-1.061l-8.689-8.69a2.25 2.25 0 0 0-3.182 0l-8.69 8.69a.75.75 0 1 0 1.061 1.06l8.69-8.689Z" />
                                    <path
                                        d="m12 5.432 8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 0 1-.75-.75v-4.5a.75.75 0 0 0-.75-.75h-3a.75.75 0 0 0-.75.75V21a.75.75 0 0 1-.75.75H5.625a1.875 1.875 0 0 1-1.875-1.875v-6.198a2.29 2.29 0 0 0 .091-.086L12 5.432Z" />
                                </svg>
                                <span class="tracking-wider text-xs">
                                Types
                            </span>
                            </Link>
                        </li>

                        <li>
                            <Link :href="route('varieties.index')"
                                  class="flex items-center pl-6 py-2.5 space-x-3 text-white border-l-4 border-[#00434b] hover:border-[#BCDA84] hover:bg-[#003C43]"
                                  :class="{ 'border-l-4 border-[#BCDA84] bg-[#003C43] text-white': $page.url === '/varieties' }">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                     class="w-5 h-5">
                                    <path
                                        d="M11.47 3.841a.75.75 0 0 1 1.06 0l8.69 8.69a.75.75 0 1 0 1.06-1.061l-8.689-8.69a2.25 2.25 0 0 0-3.182 0l-8.69 8.69a.75.75 0 1 0 1.061 1.06l8.69-8.689Z" />
                                    <path
                                        d="m12 5.432 8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 0 1-.75-.75v-4.5a.75.75 0 0 0-.75-.75h-3a.75.75 0 0 0-.75.75V21a.75.75 0 0 1-.75.75H5.625a1.875 1.875 0 0 1-1.875-1.875v-6.198a2.29 2.29 0 0 0 .091-.086L12 5.432Z" />
                                </svg>
                                <span class="tracking-wider text-xs">
                                Varieties
                            </span>
                            </Link>
                        </li>

                        <li>
                            <Link :href="route('fields.index')"
                                  class="flex items-center pl-6 py-2.5 space-x-3 text-white border-l-4 border-[#00434b] hover:border-[#BCDA84] hover:bg-[#003C43]"
                                  :class="{ 'border-l-4 border-[#BCDA84] bg-[#003C43] text-white': $page.url === '/fields' }">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                     class="w-5 h-5">
                                    <path
                                        d="M11.47 3.841a.75.75 0 0 1 1.06 0l8.69 8.69a.75.75 0 1 0 1.06-1.061l-8.689-8.69a2.25 2.25 0 0 0-3.182 0l-8.69 8.69a.75.75 0 1 0 1.061 1.06l8.69-8.689Z" />
                                    <path
                                        d="m12 5.432 8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 0 1-.75-.75v-4.5a.75.75 0 0 0-.75-.75h-3a.75.75 0 0 0-.75.75V21a.75.75 0 0 1-.75.75H5.625a1.875 1.875 0 0 1-1.875-1.875v-6.198a2.29 2.29 0 0 0 .091-.086L12 5.432Z" />
                                </svg>
                                <span class="tracking-wider text-xs">
                                Fields
                            </span>
                            </Link>
                        </li>

                        <li class="my-1">
                            <span class="ml-4 font-medium tracking-wider text-white/50 text-[10px]">INVENTORY</span>
                        </li>

                        <li>
                            <Link :href="route('storerooms.index')"
                                  class="flex items-center pl-6 py-2.5 space-x-3 text-white border-l-4 border-[#00434b] hover:border-[#BCDA84] hover:bg-[#003C43]"
                                  :class="{ 'border-l-4 border-[#BCDA84] bg-[#003C43] text-white': $page.url === '/storerooms' }">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                     class="w-5 h-5">
                                    <path
                                        d="M11.47 3.841a.75.75 0 0 1 1.06 0l8.69 8.69a.75.75 0 1 0 1.06-1.061l-8.689-8.69a2.25 2.25 0 0 0-3.182 0l-8.69 8.69a.75.75 0 1 0 1.061 1.06l8.69-8.689Z" />
                                    <path
                                        d="m12 5.432 8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 0 1-.75-.75v-4.5a.75.75 0 0 0-.75-.75h-3a.75.75 0 0 0-.75.75V21a.75.75 0 0 1-.75.75H5.625a1.875 1.875 0 0 1-1.875-1.875v-6.198a2.29 2.29 0 0 0 .091-.086L12 5.432Z" />
                                </svg>
                                <span class="tracking-wider text-xs">
                                Storerooms
                            </span>
                            </Link>
                        </li>

                        <li>
                            <Link :href="route('items.index')"
                                  class="flex items-center pl-6 py-2.5 space-x-3 text-white border-l-4 border-[#00434b] hover:border-[#BCDA84] hover:bg-[#003C43]"
                                  :class="{ 'border-l-4 border-[#BCDA84] bg-[#003C43] text-white': $page.url === '/items' }">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                     class="w-5 h-5">
                                    <path
                                        d="M11.47 3.841a.75.75 0 0 1 1.06 0l8.69 8.69a.75.75 0 1 0 1.06-1.061l-8.689-8.69a2.25 2.25 0 0 0-3.182 0l-8.69 8.69a.75.75 0 1 0 1.061 1.06l8.69-8.689Z" />
                                    <path
                                        d="m12 5.432 8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 0 1-.75-.75v-4.5a.75.75 0 0 0-.75-.75h-3a.75.75 0 0 0-.75.75V21a.75.75 0 0 1-.75.75H5.625a1.875 1.875 0 0 1-1.875-1.875v-6.198a2.29 2.29 0 0 0 .091-.086L12 5.432Z" />
                                </svg>
                                <span class="tracking-wider text-xs">
                                Items
                            </span>
                            </Link>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>

        <!-- Slot for page-specific content -->
        <main class="flex-grow lg:ml-64  bg-gray-100 text-xs md:z-40">
            <div class="bg-white px-4 py-2 md:sticky top-0 shadow-sm md:z-30">
                <div class="flex items-center justify-between">
                    <div class="font-medium text-base text-black">
                        <p>{{ $page.props.pageTitle }}</p>
                    </div>

                    <div class="flex items-center">
                        <div class="ms-3 relative">
                            <!-- Teams Dropdown -->
                            <Dropdown v-if="$page.props.jetstream.hasTeamFeatures" align="right" width="60">
                                <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-xs leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                                {{ $page.props.auth.user.current_team.name }}

<!--                                                <svg class="ms-2 -me-0.5 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">-->
<!--                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />-->
<!--                                                </svg>-->
                                            </button>
                                        </span>
                                </template>

                                <template #content>
                                    <div class="text-xs w-60">
                                        <!-- Team Management -->
                                        <div class="block px-4 py-2 text-gray-400">
                                            Manage Organization
                                        </div>

                                        <!-- Team Settings -->
                                        <DropdownLink :href="route('teams.show', $page.props.auth.user.current_team)">
                                            Organization Settings
                                        </DropdownLink>

                                        <DropdownLink v-if="$page.props.jetstream.canCreateTeams" :href="route('teams.create')">
                                            Create New Organization
                                        </DropdownLink>

                                        <!-- Team Switcher -->
                                        <template v-if="$page.props.auth.user.all_teams.length > 1">
                                            <div class="border-t border-gray-200" />

                                            <div class="block px-4 py-2 text-xs text-gray-400">
                                                Switch Organizations
                                            </div>

                                            <template v-for="team in $page.props.auth.user.all_teams" :key="team.id">
                                                <form @submit.prevent="switchToTeam(team)">
                                                    <DropdownLink as="button">
                                                        <div class="flex items-center">
                                                            <svg v-if="team.id == $page.props.auth.user.current_team_id" class="me-2 size-5 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>

                                                            <div>{{ team.name }}</div>
                                                        </div>
                                                    </DropdownLink>
                                                </form>
                                            </template>
                                        </template>
                                    </div>
                                </template>
                            </Dropdown>
                        </div>

                        <!-- Settings Dropdown -->
                        <div class="ms-3 relative">
                            <Dropdown align="right" width="48">
                                <template #trigger>
                                    <button v-if="$page.props.jetstream.managesProfilePhotos"
                                            class="flex text-xs border-2 border-transparent rounded-full focus:outline-none focus:border-[#BCDA84] transition">
                                        <!-- <img class="h-10 w-10 rounded-full object-cover"
                                            :src="$page.props.auth.user.profile_photo_url"
                                            :alt="$page.props.auth.user.first_name">
                                            -->
                                        <div class="h-10 w-10 bg-[#00434b] rounded-full"></div>
                                    </button>

                                    <span v-else class="inline-flex rounded-md">
                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-xs leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                                {{ $page.props.auth.user.name }}

                                                <svg class="ms-2 -me-0.5 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
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

                                    <DropdownLink v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')">
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

const props = defineProps({
    title: String,
    pageTitle: {
        type: String,
        required: true, // Ensure that pageTitle is provided
    },
    breadcrumbs: {
        type: Array,
        required: true, // Ensure that breadcrumbs are provided
    },
});

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
    console.log('Mobile nav toggled:', mobileNavOpen.value);
}
</script>
