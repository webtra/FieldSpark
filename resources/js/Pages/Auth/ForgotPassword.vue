<template>

    <Head title="Forgot Password" />

    <AuthLayout>
        <AuthenticationCard>
            <template #logo>
                <AuthenticationCardLogo />
            </template>

            <div class="mb-4 text-xs text-white font-light">
                Forgot your password? <br> Enter your email, and we'll send you a reset link.
            </div>

            <div v-if="status" class="mb-4 font-medium text-xs text-green-600">
                {{ status }}
            </div>

            <form @submit.prevent="submit">
                <div>
                    <InputLabel class="text-white font-light" for="email" value="Email Address" />
                    <TextInput id="email" v-model="form.email" type="email" placeholder="Email Address"
                               class="border-white/10 text-white placeholder:text-white/50 placeholder:font-light mt-1 block w-full bg-[#1A565D] rounded-lg text-xs focus:border-[#BCDA84] focus:ring-[#BCDA84]" required />
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Reset Password
                    </PrimaryButton>
                </div>

                <div class="flex justify-center mt-2 text-xs text-white font-light">
                    Go back to
                    <Link :href="route('login')" class="ml-1 underline text-xs text-white hover:text-white/80">
                        Login
                    </Link>
                </div>
            </form>
        </AuthenticationCard>
    </AuthLayout>
</template>

<script setup>
import {Head, Link, useForm} from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import AuthLayout from "@/Layouts/AuthLayout.vue";

defineProps({
    status: String,
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>
