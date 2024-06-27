<script setup>
import { computed } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    status: String,
});

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(() => props.status === 'verification-link-sent');
</script>

<template>

    <Head title="Email Verification" />

    <AuthenticationCard>
        <template #logo>
            <AuthenticationCardLogo />
        </template>

        <div class="mb-4 text-sm text-gray-600">
            Please verify your email with the link we sent. <br> Didn't get it? We'll resend.
        </div>

        <div v-if="verificationLinkSent" class="mb-4 font-medium text-sm text-green-600">
            A new verification link has been.
        </div>

        <form @submit.prevent="submit">
            <div class="mt-4 flex items-center justify-between">
                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Resend Verification Email
                </PrimaryButton>
            </div>

            <div class="text-center mt-2">
                <Link :href="route('profile.show')"
                    class="underline text-sm text-gray-600 hover:text-blue-500">
                Edit Profile</Link>

                <Link :href="route('logout')" method="post" as="button"
                    class="underline text-sm text-gray-600 hover:text-blue-500 ml-2">
                Log Out
                </Link>
            </div>
        </form>
    </AuthenticationCard>
</template>
