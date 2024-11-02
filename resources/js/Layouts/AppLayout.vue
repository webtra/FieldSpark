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
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
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
                                <span
                                    class="ml-4 font-medium tracking-wider text-white/50 text-[10px]">CULTIVATION</span>
                            </li>

                            <li>
                                <Link :href="route('cultivar.index')"
                                    class="flex items-center pl-6 py-2.5 space-x-3 text-white border-l-4 border-[#00434b] hover:border-[#BCDA84] hover:bg-[#003C43]"
                                    :class="{ 'border-l-4 border-[#BCDA84] bg-[#003C43] text-white': $page.url === '/cultivar' }">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="size-5">
                                    <path fill-rule="evenodd"
                                        d="M12 3.75a6.715 6.715 0 0 0-3.722 1.118.75.75 0 1 1-.828-1.25 8.25 8.25 0 0 1 12.8 6.883c0 3.014-.574 5.897-1.62 8.543a.75.75 0 0 1-1.395-.551A21.69 21.69 0 0 0 18.75 10.5 6.75 6.75 0 0 0 12 3.75ZM6.157 5.739a.75.75 0 0 1 .21 1.04A6.715 6.715 0 0 0 5.25 10.5c0 1.613-.463 3.12-1.265 4.393a.75.75 0 0 1-1.27-.8A6.715 6.715 0 0 0 3.75 10.5c0-1.68.503-3.246 1.367-4.55a.75.75 0 0 1 1.04-.211ZM12 7.5a3 3 0 0 0-3 3c0 3.1-1.176 5.927-3.105 8.056a.75.75 0 1 1-1.112-1.008A10.459 10.459 0 0 0 7.5 10.5a4.5 4.5 0 1 1 9 0c0 .547-.022 1.09-.067 1.626a.75.75 0 0 1-1.495-.123c.041-.495.062-.996.062-1.503a3 3 0 0 0-3-3Zm0 2.25a.75.75 0 0 1 .75.75c0 3.908-1.424 7.485-3.781 10.238a.75.75 0 0 1-1.14-.975A14.19 14.19 0 0 0 11.25 10.5a.75.75 0 0 1 .75-.75Zm3.239 5.183a.75.75 0 0 1 .515.927 19.417 19.417 0 0 1-2.585 5.544.75.75 0 0 1-1.243-.84 17.915 17.915 0 0 0 2.386-5.116.75.75 0 0 1 .927-.515Z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="tracking-wider text-xs">
                                    Cultivars
                                </span>
                                </Link>
                            </li>

                            <li>
                                <Link :href="route('crop.index')"
                                    class="flex items-center pl-6 py-2.5 space-x-3 text-white border-l-4 border-[#00434b] hover:border-[#BCDA84] hover:bg-[#003C43]"
                                    :class="{ 'border-l-4 border-[#BCDA84] bg-[#003C43] text-white': $page.url === '/crop' }">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="size-5">
                                    <path
                                        d="M19.906 9c.382 0 .749.057 1.094.162V9a3 3 0 0 0-3-3h-3.879a.75.75 0 0 1-.53-.22L11.47 3.66A2.25 2.25 0 0 0 9.879 3H6a3 3 0 0 0-3 3v3.162A3.756 3.756 0 0 1 4.094 9h15.812ZM4.094 10.5a2.25 2.25 0 0 0-2.227 2.568l.857 6A2.25 2.25 0 0 0 4.951 21H19.05a2.25 2.25 0 0 0 2.227-1.932l.857-6a2.25 2.25 0 0 0-2.227-2.568H4.094Z" />
                                </svg>
                                <span class="tracking-wider text-xs">
                                    Crops
                                </span>
                                </Link>
                            </li>

                            <li class="my-1">
                                <span
                                    class="ml-4 font-medium tracking-wider text-white/50 text-[10px]">AGROCHEMICALS</span>
                            </li>

                            <li>
                                <Link :href="route('agrochemical.index')"
                                    class="flex items-center pl-6 py-2.5 space-x-3 text-white border-l-4 border-[#00434b] hover:border-[#BCDA84] hover:bg-[#003C43]"
                                    :class="{ 'border-l-4 border-[#BCDA84] bg-[#003C43] text-white': $page.url === '/agrochemical' }">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="size-5">
                                    <path fill-rule="evenodd"
                                        d="M10.5 3.798v5.02a3 3 0 0 1-.879 2.121l-2.377 2.377a9.845 9.845 0 0 1 5.091 1.013 8.315 8.315 0 0 0 5.713.636l.285-.071-3.954-3.955a3 3 0 0 1-.879-2.121v-5.02a23.614 23.614 0 0 0-3 0Zm4.5.138a.75.75 0 0 0 .093-1.495A24.837 24.837 0 0 0 12 2.25a25.048 25.048 0 0 0-3.093.191A.75.75 0 0 0 9 3.936v4.882a1.5 1.5 0 0 1-.44 1.06l-6.293 6.294c-1.62 1.621-.903 4.475 1.471 4.88 2.686.46 5.447.698 8.262.698 2.816 0 5.576-.239 8.262-.697 2.373-.406 3.092-3.26 1.47-4.881L15.44 9.879A1.5 1.5 0 0 1 15 8.818V3.936Z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="tracking-wider text-xs">
                                    Agrochemicals
                                </span>
                                </Link>
                            </li>

                            <!--<li class="my-1">
                                <span class="ml-4 font-medium tracking-wider text-white/50 text-[10px]">USERS</span>
                            </li>

                            <li>
                                <Link :href="route('user.index')"
                                    class="flex items-center pl-6 py-2.5 space-x-3 text-white border-l-4 border-[#00434b] hover:border-[#BCDA84] hover:bg-[#003C43]"
                                    :class="{ 'border-l-4 border-[#BCDA84] bg-[#003C43] text-white': $page.url === '/user' }">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="size-5">
                                    <path fill-rule="evenodd"
                                        d="M8.25 6.75a3.75 3.75 0 1 1 7.5 0 3.75 3.75 0 0 1-7.5 0ZM15.75 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM2.25 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM6.31 15.117A6.745 6.745 0 0 1 12 12a6.745 6.745 0 0 1 6.709 7.498.75.75 0 0 1-.372.568A12.696 12.696 0 0 1 12 21.75c-2.305 0-4.47-.612-6.337-1.684a.75.75 0 0 1-.372-.568 6.787 6.787 0 0 1 1.019-4.38Z"
                                        clip-rule="evenodd" />
                                    <path
                                        d="M5.082 14.254a8.287 8.287 0 0 0-1.308 5.135 9.687 9.687 0 0 1-1.764-.44l-.115-.04a.563.563 0 0 1-.373-.487l-.01-.121a3.75 3.75 0 0 1 3.57-4.047ZM20.226 19.389a8.287 8.287 0 0 0-1.308-5.135 3.75 3.75 0 0 1 3.57 4.047l-.01.121a.563.563 0 0 1-.373.486l-.115.04c-.567.2-1.156.349-1.764.441Z" />
                                </svg>
                                <span class="tracking-wider text-xs">
                                    Users
                                </span>
                                </Link>
                            </li>
                            -->
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
                            <span class="ml-4 font-medium tracking-wider text-white/50 text-[10px]">CULTIVATION</span>
                        </li>

                        <li>
                            <Link :href="route('cultivar.index')"
                                class="flex items-center pl-6 py-2.5 space-x-3 text-white border-l-4 border-[#00434b] hover:border-[#BCDA84] hover:bg-[#003C43]"
                                :class="{ 'border-l-4 border-[#BCDA84] bg-[#003C43] text-white': $page.url === '/cultivar' }">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-5">
                                <path fill-rule="evenodd"
                                    d="M12 3.75a6.715 6.715 0 0 0-3.722 1.118.75.75 0 1 1-.828-1.25 8.25 8.25 0 0 1 12.8 6.883c0 3.014-.574 5.897-1.62 8.543a.75.75 0 0 1-1.395-.551A21.69 21.69 0 0 0 18.75 10.5 6.75 6.75 0 0 0 12 3.75ZM6.157 5.739a.75.75 0 0 1 .21 1.04A6.715 6.715 0 0 0 5.25 10.5c0 1.613-.463 3.12-1.265 4.393a.75.75 0 0 1-1.27-.8A6.715 6.715 0 0 0 3.75 10.5c0-1.68.503-3.246 1.367-4.55a.75.75 0 0 1 1.04-.211ZM12 7.5a3 3 0 0 0-3 3c0 3.1-1.176 5.927-3.105 8.056a.75.75 0 1 1-1.112-1.008A10.459 10.459 0 0 0 7.5 10.5a4.5 4.5 0 1 1 9 0c0 .547-.022 1.09-.067 1.626a.75.75 0 0 1-1.495-.123c.041-.495.062-.996.062-1.503a3 3 0 0 0-3-3Zm0 2.25a.75.75 0 0 1 .75.75c0 3.908-1.424 7.485-3.781 10.238a.75.75 0 0 1-1.14-.975A14.19 14.19 0 0 0 11.25 10.5a.75.75 0 0 1 .75-.75Zm3.239 5.183a.75.75 0 0 1 .515.927 19.417 19.417 0 0 1-2.585 5.544.75.75 0 0 1-1.243-.84 17.915 17.915 0 0 0 2.386-5.116.75.75 0 0 1 .927-.515Z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="tracking-wider text-xs">
                                Cultivars
                            </span>
                            </Link>
                        </li>

                        <li>
                            <Link :href="route('crop.index')"
                                class="flex items-center pl-6 py-2.5 space-x-3 text-white border-l-4 border-[#00434b] hover:border-[#BCDA84] hover:bg-[#003C43]"
                                :class="{ 'border-l-4 border-[#BCDA84] bg-[#003C43] text-white': $page.url === '/crop' }">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-5">
                                <path
                                    d="M19.906 9c.382 0 .749.057 1.094.162V9a3 3 0 0 0-3-3h-3.879a.75.75 0 0 1-.53-.22L11.47 3.66A2.25 2.25 0 0 0 9.879 3H6a3 3 0 0 0-3 3v3.162A3.756 3.756 0 0 1 4.094 9h15.812ZM4.094 10.5a2.25 2.25 0 0 0-2.227 2.568l.857 6A2.25 2.25 0 0 0 4.951 21H19.05a2.25 2.25 0 0 0 2.227-1.932l.857-6a2.25 2.25 0 0 0-2.227-2.568H4.094Z" />
                            </svg>
                            <span class="tracking-wider text-xs">
                                Crops
                            </span>
                            </Link>
                        </li>

                        <li class="my-1">
                            <span class="ml-4 font-medium tracking-wider text-white/50 text-[10px]">AGROCHEMICALS</span>
                        </li>

                        <li>
                            <Link :href="route('agrochemical.index')"
                                class="flex items-center pl-6 py-2.5 space-x-3 text-white border-l-4 border-[#00434b] hover:border-[#BCDA84] hover:bg-[#003C43]"
                                :class="{ 'border-l-4 border-[#BCDA84] bg-[#003C43] text-white': $page.url === '/agrochemical' }">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-5">
                                <path fill-rule="evenodd"
                                    d="M10.5 3.798v5.02a3 3 0 0 1-.879 2.121l-2.377 2.377a9.845 9.845 0 0 1 5.091 1.013 8.315 8.315 0 0 0 5.713.636l.285-.071-3.954-3.955a3 3 0 0 1-.879-2.121v-5.02a23.614 23.614 0 0 0-3 0Zm4.5.138a.75.75 0 0 0 .093-1.495A24.837 24.837 0 0 0 12 2.25a25.048 25.048 0 0 0-3.093.191A.75.75 0 0 0 9 3.936v4.882a1.5 1.5 0 0 1-.44 1.06l-6.293 6.294c-1.62 1.621-.903 4.475 1.471 4.88 2.686.46 5.447.698 8.262.698 2.816 0 5.576-.239 8.262-.697 2.373-.406 3.092-3.26 1.47-4.881L15.44 9.879A1.5 1.5 0 0 1 15 8.818V3.936Z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="tracking-wider text-xs">
                                Agrochemicals
                            </span>
                            </Link>
                        </li>

                        <!--<li class="my-1">
                            <span class="ml-4 font-medium tracking-wider text-white/50 text-[10px]">USERS</span>
                        </li>

                        <li>
                            <Link :href="route('user.index')"
                                class="flex items-center pl-6 py-2.5 space-x-3 text-white border-l-4 border-[#00434b] hover:border-[#BCDA84] hover:bg-[#003C43]"
                                :class="{ 'border-l-4 border-[#BCDA84] bg-[#003C43] text-white': $page.url === '/user' }">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-5">
                                <path fill-rule="evenodd"
                                    d="M8.25 6.75a3.75 3.75 0 1 1 7.5 0 3.75 3.75 0 0 1-7.5 0ZM15.75 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM2.25 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM6.31 15.117A6.745 6.745 0 0 1 12 12a6.745 6.745 0 0 1 6.709 7.498.75.75 0 0 1-.372.568A12.696 12.696 0 0 1 12 21.75c-2.305 0-4.47-.612-6.337-1.684a.75.75 0 0 1-.372-.568 6.787 6.787 0 0 1 1.019-4.38Z"
                                    clip-rule="evenodd" />
                                <path
                                    d="M5.082 14.254a8.287 8.287 0 0 0-1.308 5.135 9.687 9.687 0 0 1-1.764-.44l-.115-.04a.563.563 0 0 1-.373-.487l-.01-.121a3.75 3.75 0 0 1 3.57-4.047ZM20.226 19.389a8.287 8.287 0 0 0-1.308-5.135 3.75 3.75 0 0 1 3.57 4.047l-.01.121a.563.563 0 0 1-.373.486l-.115.04c-.567.2-1.156.349-1.764.441Z" />
                            </svg>
                            <span class="tracking-wider text-xs">
                                Users
                            </span>
                            </Link>
                        </li>
                        -->
                    </ul>
                </div>
            </nav>
        </div>

        <!-- Slot for page-specific content -->
        <main class="flex-grow lg:ml-64  bg-gray-100 text-xs z-10">
            <div class="bg-white px-4 py-2 md:sticky top-0 shadow-sm">
                <div class="flex items-center justify-between">
                    <p class="font-medium text-lg text-black">{{ $page.props.pageTitle }}</p>
                    <div class="flex items-center -mr-1 md:-mr-0">
                        <!-- Settings Dropdown -->
                        <div class="relative">
                            <Dropdown align="right" width="48">
                                <template #trigger>
                                    <button v-if="$page.props.jetstream.managesProfilePhotos"
                                        class="flex text-xs border-2 border-transparent rounded-full focus:outline-none focus:border-[#BCDA84] transition">
                                        <!-- <img class="h-10 w-10 rounded-full object-cover"
                                            :src="$page.props.auth.user.profile_photo_url"
                                            :alt="$page.props.auth.user.first_name">
                                            -->
                                        <div class="h-10 w-10 bg-[#00434b] rounded-full">

                                        </div>
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
                                    <!-- Account Management
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        Manage Account
                                    </div>
                                     -->

                                    <DropdownLink :href="route('profile.show')">
                                        Profile
                                    </DropdownLink>

                                    <DropdownLink :href="route('user.index')">
                                        Users
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
import { usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';

defineProps({
    title: String,
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
    // console.log('Mobile nav open:', mobileNavOpen.value);
}
</script>
