<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register" />
        <section class="bg-white-90 dark:bg-white-900 w-full h-screen">
                <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0 w-full">
                    <!-- <img class="rounded-full w-50 h-35" src="/logo.png" alt="image description"> -->
                    <div class="max-w-[500px] w-full bg-gray-200 rounded-lg shadow dark:border md:mt-0 xl:p-0">
                        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                        <h1 class="text-xl font-bold leading-tight tracking-tight">
                            Register your account
                        </h1>

                        <form @submit.prevent="submit">
                            <div>
                                <InputLabel for="name" value="Name" />

                                <TextInput
                                    id="name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.name"
                                    required
                                    autofocus
                                    autocomplete="name"
                                />

                                <InputError class="mt-2" :message="form.errors.name" />
                            </div>

                            <div class="mt-4">
                                <InputLabel for="email" value="Email" />

                                <TextInput
                                    id="email"
                                    type="email"
                                    class="mt-1 block w-full"
                                    v-model="form.email"
                                    required
                                    autocomplete="username"
                                />

                                <InputError class="mt-2" :message="form.errors.email" />
                            </div>


                            <div class="mt-4">
                                <InputLabel for="contact_number" value="Contact Number" />

                                <TextInput
                                    id="contact_number"
                                    type="number"
                                    class="mt-1 block w-full"
                                    v-model="form.contact_number"
                                    required
                                    autocomplete="username"
                                />

                                <InputError class="mt-2" :message="form.errors.contact_number" />
                            </div>

                            <div class="mt-4">
                                <InputLabel for="address" value="Address" />

                                <TextInput
                                    id="address"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.address"
                                    required
                                    autocomplete="username"
                                />

                                <InputError class="mt-2" :message="form.errors.address" />
                            </div>


                            <div class="mt-4">
                                <InputLabel for="password" value="Password" />

                                <TextInput
                                    id="password"
                                    type="password"
                                    class="mt-1 block w-full"
                                    v-model="form.password"
                                    required
                                    autocomplete="new-password"
                                />

                                <InputError class="mt-2" :message="form.errors.password" />
                            </div>

                            <div class="mt-4">
                                <InputLabel
                                    for="password_confirmation"
                                    value="Confirm Password"
                                />

                                <TextInput
                                    id="password_confirmation"
                                    type="password"
                                    class="mt-1 block w-full"
                                    v-model="form.password_confirmation"
                                    required
                                    autocomplete="new-password"
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.password_confirmation"
                                />
                            </div>

                            <div class="mt-4 flex items-center justify-end">
                                <Link
                                    :href="route('login')"
                                    class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                >
                                    Already registered?
                                </Link>

                                <PrimaryButton
                                    class="ms-4"
                                    :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing"
                                >
                                    Register
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </GuestLayout>
</template>
