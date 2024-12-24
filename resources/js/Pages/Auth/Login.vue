<template>
    <Head title="Log in" />

    <AuthLayout>
        <AuthenticationCard>
            <template #logo>
                <AuthenticationCardLogo />
            </template>

            <div v-if="status" class="mb-4 font-medium text-xs text-green-600">
                {{ status }}
            </div>

            <form @submit.prevent="submit">
                <div>
                    <InputLabel class="text-white font-light" for="email" value="Email Address" />
                    <TextInput id="email" v-model="form.email" type="email" placeholder="Email Address" class="border-white/10 text-white placeholder:text-white/50 placeholder:font-light mt-1 block w-full bg-[#1A565D] rounded-lg text-xs focus:border-[#BCDA84] focus:ring-[#BCDA84]" required />
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <div class="mt-4">
                    <InputLabel class="text-white font-light" for="password" value="Password" />
                    <TextInput id="password" v-model="form.password" type="password" placeholder="Password" class="border-white/10 text-white placeholder:text-white/50 placeholder:font-light mt-1 block w-full bg-[#1A565D] rounded-lg text-xs focus:border-[#BCDA84] focus:ring-[#BCDA84]" required />
                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <div class="flex items-center justify-between mt-4">
                    <label class="flex items-center">
                        <Checkbox class="bg-[#1A565D] text-[#BCDA84]" v-model:checked="form.remember" name="remember" />
                        <span class="ms-2 text-xs text-white font-light">Remember me</span>
                    </label>

                    <div>
                        <Link :href="route('password.request')"
                              class="underline text-xs text-white font-light hover:text-white/80">
                            Forgot your password?
                        </Link>
                    </div>
                </div>

                <div class="mt-4">
                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Log In
                    </PrimaryButton>
                </div>

                <div class="flex justify-center mt-2 text-xs text-white font-light">
                    Not registered?
                    <Link :href="route('register')" class="ml-1 underline text-xs text-white hover:text-white/80">
                        Register
                    </Link>
                </div>
            </form>
        </AuthenticationCard>
    </AuthLayout>
</template>

<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import AuthLayout from '@/Layouts/AuthLayout.vue';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>
