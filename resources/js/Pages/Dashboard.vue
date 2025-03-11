<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Dashboard
            </h2>
        </template>

        <div class="py-10">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Main Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Sales Report -->
                <div class="md:col-span-2 bg-white p-4 rounded-lg shadow-lg">
                    <h2 class="text-xl font-bold">$45,385</h2>
                    <p class="text-gray-400">Sales this week</p>
                    <div class="mt-4 h-64 bg-gray-700 rounded-lg"></div>
                </div>

                <!-- Statistics Panel -->
                <div class="bg-white p-4 rounded-lg shadow-lg">
                    <h3 class="text-lg font-bold">Statistics this month</h3>
                    <div class="mt-4 h-48 bg-gray-700 rounded-lg"></div>
                </div>
                </div>

                <!-- Secondary Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                    <div class="bg-white p-4 rounded-lg shadow-lg">
                    <h4 class="text-lg font-bold">New Products</h4>
                    <div class="mt-2 h-24 bg-gray-700 rounded-lg"></div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-lg">
                    <h4 class="text-lg font-bold">Users</h4>
                    <div class="mt-2 h-24 bg-gray-700 rounded-lg"></div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-lg">
                    <h4 class="text-lg font-bold">Audience by Age</h4>
                    <div class="mt-2 h-24 bg-gray-700 rounded-lg"></div>
                </div>
                </div>
            </div>
            </div>

    </AuthenticatedLayout>
</template>
