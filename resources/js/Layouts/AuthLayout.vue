<template>
    <div class="min-h-screen flex items-center justify-center bg-cover bg-center bg-no-repeat"
        :style="{ backgroundImage: 'url(/storage/login-register.jpg)', backgroundSize: 'cover' }">
        <slot></slot>
    </div>
</template>

<script setup>
// No additional setup required if it's a simple layout
</script>

<style scoped>
/* Optional: Add any specific styling for auth pages here */
</style>
