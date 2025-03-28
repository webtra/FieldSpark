<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import ActionMessage from '@/Components/ActionMessage.vue';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('user-password.update'), {
        errorBag: 'updatePassword',
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }

            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value.focus();
            }
        },
    });
};
</script>

<template>
    <FormSection @submitted="updatePassword">
        <template #title>
            Update Password
        </template>

        <template #description>
            Ensure your account is using a long, random password to stay secure.
        </template>

        <template #form>
            <div class="col-span-6">
                <InputLabel for="current_password" value="Current Password" />
                <TextInput id="current_password" ref="currentPasswordInput" v-model="form.current_password"
                           type="password" class="mt-1 block w-full" placeholder="Current Password"
                           autocomplete="current-password" />
                <InputError :message="form.errors.current_password" class="mt-2" />
            </div>

            <div class="col-span-6">
                <InputLabel for="password" value="New Password" />
                <TextInput id="password" ref="passwordInput" v-model="form.password" type="password"
                           class="mt-1 block w-full" placeholder="New Password" autocomplete="new-password" />
                <InputError :message="form.errors.password" class="mt-2" />
            </div>

            <div class="col-span-6">
                <InputLabel for="password_confirmation" value="Confirm Password" />
                <TextInput id="password_confirmation" v-model="form.password_confirmation" type="password"
                           class="mt-1 block w-full" placeholder="Confirm Password" autocomplete="new-password" />
                <InputError :message="form.errors.password_confirmation" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <div class="w-full my-2">
                <ActionMessage :on="form.recentlySuccessful">
                    Saved.
                </ActionMessage>

                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Save
                </PrimaryButton>
            </div>
        </template>
    </FormSection>
</template>
