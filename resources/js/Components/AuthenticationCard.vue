<template>
    <div class="min-h-screen flex flex-col justify-center px-4 items-center bg-gray-100">
        <div>
            <slot name="logo" />
        </div>

        <div class="w-full max-w-md mt-6 px-6 py-4 bg-white shadow overflow-hidden rounded">
            <slot />
        </div>
    </div>
</template>