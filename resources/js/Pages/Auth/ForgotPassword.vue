<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <GuestLayout>
        <Head title="Forgot Password" />
        <section class="bg-white-90 dark:bg-white-900 w-full h-screen">
                <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0 w-full">
                    <!-- <img class="rounded-full w-50 h-35" src="/logo.png" alt="image description"> -->
                    <div class="max-w-[500px] w-full bg-gray-200 rounded-lg shadow dark:border md:mt-0 xl:p-0">
                        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                            <div class="mb-4 text-sm text-gray-600">
                                Forgot your password? No problem. Just let us know your email
                                address and we will email you a password reset link that will allow
                                you to choose a new one.
                            </div>

                            <div
                                v-if="status"
                                class="mb-4 text-sm font-medium text-green-600"
                            >
                                {{ status }}
                            </div>

                            <form @submit.prevent="submit">
                                <div>
                                    <InputLabel for="email" value="Email" />

                                    <TextInput
                                        id="email"
                                        type="email"
                                        class="mt-1 block w-full"
                                        v-model="form.email"
                                        required
                                        autofocus
                                        autocomplete="username"
                                    />

                                    <InputError class="mt-2" :message="form.errors.email" />
                                </div>

                                <div class="mt-4 flex items-center justify-end">
                                    <PrimaryButton
                                        :class="{ 'opacity-25': form.processing }"
                                        :disabled="form.processing"
                                    >
                                        Email Password Reset Link
                                    </PrimaryButton>
                                </div>
                            </form>
                        </div>
                </div>
            </div>
        </section>
    </GuestLayout>
</template>
