<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
    first_name: '',
    last_name: '',
    email: '',
    team_name: '',
    password: '',
    password_confirmation: '',
    terms: false,
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="Register" />

    <AuthenticationCard>
        <template #logo>
            <AuthenticationCardLogo />
        </template>

        <form @submit.prevent="submit">
            <div class="flex items-center space-x-4">
                <div class="w-full">
                    <InputLabel class="text-white font-light" for="first_name" value="First Name" />
                    <TextInput id="first_name" v-model="form.first_name" type="text" placeholder="First Name" class="border-white/10 text-white placeholder:text-white/50 placeholder:font-light mt-1 block w-full bg-[#1A565D] rounded-lg text-xs focus:border-[#BCDA84] focus:ring-[#BCDA84]" required />
                    <InputError class="mt-2" :message="form.errors.first_name" />
                </div>

                <div class="w-full">
                    <InputLabel class="text-white font-light" for="last_name" value="Last Name" />
                    <TextInput id="last_name" v-model="form.last_name" type="text" placeholder="Last Name" class="border-white/10 text-white placeholder:text-white/50 placeholder:font-light mt-1 block w-full bg-[#1A565D] rounded-lg text-xs focus:border-[#BCDA84] focus:ring-[#BCDA84]" required />
                    <InputError class="mt-2" :message="form.errors.last_name" />
                </div>
            </div>

            <div class="mt-4">
                <InputLabel class="text-white font-light" for="email" value="Email Address" />
                <TextInput
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="border-white/10 text-white placeholder:text-white/50 placeholder:font-light mt-1 block w-full bg-[#1A565D] rounded-lg text-xs focus:border-[#BCDA84] focus:ring-[#BCDA84]"
                    required
                    autocomplete="username"
                    placeholder="Email Address"
                />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel class="text-white font-light" for="team_name" value="Organization Name" />
                <TextInput
                    id="team_name"
                    v-model="form.team_name"
                    type="text"
                    class="border-white/10 text-white placeholder:text-white/50 placeholder:font-light mt-1 block w-full bg-[#1A565D] rounded-lg text-xs focus:border-[#BCDA84] focus:ring-[#BCDA84]"
                    required
                    placeholder="Organization Name"
                />
                <InputError class="mt-2" :message="form.errors.team_name" />
            </div>

            <div class="flex space-x-4 items-center mt-4">
                <div class="w-full">
                    <InputLabel class="text-white font-light" for="password" value="Password" />
                    <TextInput
                        id="password"
                        v-model="form.password"
                        type="password"
                        class="border-white/10 text-white placeholder:text-white/50 placeholder:font-light mt-1 block w-full bg-[#1A565D] rounded-lg text-xs focus:border-[#BCDA84] focus:ring-[#BCDA84]"
                        required
                        autocomplete="new-password"
                        placeholder="Password"
                    />
                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <div class="w-full">
                    <InputLabel class="text-white font-light" for="password_confirmation" value="Confirm Password" />
                    <TextInput
                        id="password_confirmation"
                        v-model="form.password_confirmation"
                        type="password"
                        class="border-white/10 text-white placeholder:text-white/50 placeholder:font-light mt-1 block w-full bg-[#1A565D] rounded-lg text-xs focus:border-[#BCDA84] focus:ring-[#BCDA84]"
                        required
                        autocomplete="new-password"
                        placeholder="Confirm Password"
                    />
                    <InputError class="mt-2" :message="form.errors.password_confirmation" />
                </div>
            </div>

            <div v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature" class="my-4">
                <InputLabel for="terms">
                    <div class="flex items-center">
                        <Checkbox class="bg-[#1A565D] text-[#BCDA84]" id="terms" v-model:checked="form.terms" name="terms" required />

                        <div class="text-white font-light hover:text-white/80 ms-2">
                            I agree to the <a target="_blank" :href="route('terms.show')" class="underline text-xs text-white font-light hover:text-white/80">Terms of Service</a> and <a target="_blank" :href="route('policy.show')" class="underline text-xs text-white font-light hover:text-white/80">Privacy Policy</a>
                        </div>
                    </div>
                    <InputError class="mt-2" :message="form.errors.terms" />
                </InputLabel>
            </div>

            <div>
                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Register
                </PrimaryButton>
            </div>

            <div class="flex justify-center mt-2 text-xs text-white font-light">
                Already registered?
                <Link :href="route('login')" class="ml-1 underline text-xs text-white font-light hover:text-white/80">
                    Login
                </Link>
            </div>
        </form>
    </AuthenticationCard>
</template>
