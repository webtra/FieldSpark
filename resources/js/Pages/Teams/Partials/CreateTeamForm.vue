<template>
    <FormSection @submitted="createTeam">
        <template #title>
          Organization Details
        </template>

        <template #description>
            Create a new organization to collaborate with others.
        </template>

        <template #form>
            <div class="col-span-6">
                <InputLabel value="Organization Owner" />

                <div class="flex items-center mt-2">
                    <img class="object-cover size-12 rounded-full" :src="$page.props.auth.user.profile_photo_url" :alt="$page.props.auth.user.first_name">

                    <div class="ms-4 leading-tight">
                        <div class="text-gray-900">{{ $page.props.auth.user.first_name }} {{ $page.props.auth.user.last_name }}</div>
                        <div class="text-sm text-gray-700">
                            {{ $page.props.auth.user.email }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-6">
                <InputLabel for="name" value="Organization Name" />
                <TextInput
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="block w-full mt-1"
                    autofocus
                    placeholder="Organization Name"
                />
                <InputError :message="form.errors.name" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Create
            </PrimaryButton>
        </template>
    </FormSection>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
    name: '',
});

const createTeam = () => {
    form.post(route('teams.store'), {
        errorBag: 'createTeam',
        preserveScroll: true,
    });
};
</script>
