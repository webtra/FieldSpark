<template>
    <div class="min-h-screen flex flex-col justify-center items-center bg-cover bg-center" style="background-image: url('/storage/login-register.jpg')">
        <div class="w-[350px] md:w-[400px] mt-6 px-8 py-8 bg-[#00434b] border border-[#1A565D] overflow-hidden rounded flex flex-col items-center">
            <div class="w-full flex justify-center pt-4 pb-8">
                <slot name="logo" />
            </div>

            <div class="w-full">
                <slot />
            </div>
        </div>
    </div>
</template>

<script setup>
</script>
