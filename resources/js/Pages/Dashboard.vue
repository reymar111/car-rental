<script >
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

export default {
    props: [
        'rev_total_revenue',
        'rev_percentage_change',
        'rev_top_earning_category',
        'monthly_summary',
        'new_listings',
        'most_popular_car',
        'total_users',
        'new_sign_up',
        'average_rating',
        'most_praised_feature',
    ],
    components: {
        AuthenticatedLayout,
        Head
    },
    data() {
        return {

        }
    }
}
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
                    <div class="md:col-span-2 bg-white p-6 rounded-lg shadow-lg">
                        <h2 class="text-2xl font-bold text-gray-800">Total Revenue</h2>
                        <p class="text-gray-600">This week</p>
                        <div class="mt-4 p-4 bg-gray-100 rounded-lg">
                            <p class="text-4xl font-semibold text-green-600">₱ {{rev_total_revenue  }}</p>
                            <p class="text-sm text-gray-500">{{rev_percentage_change >= 0 ? '+' : '-'}}{{rev_percentage_change}}% from last week</p>
                            <p class="mt-2 text-gray-700">Top Earning Category: {{ rev_top_earning_category }}</p>
                        </div>
                    </div>

                    <!-- Statistics Panel -->
                    <div class="bg-white p-6 rounded-lg shadow-lg">
                        <h3 class="text-xl font-bold text-gray-800">Monthly Summary</h3>
                        <div class="mt-4 p-4 bg-gray-100 rounded-lg">
                            <p class="text-lg text-gray-700">Total Bookings: <span class="font-semibold text-blue-600">{{ monthly_summary != null ? monthly_summary.total_bookings : '' }}</span></p>
                            <p class="text-lg text-gray-700">Completed Trips: <span class="font-semibold text-green-600">{{ monthly_summary != null ? monthly_summary.completed_trips : '' }}</span></p>
                            <p class="text-lg text-gray-700">Canceled Trips: <span class="font-semibold text-red-600">{{ monthly_summary != null ? monthly_summary.canceled_trips : '' }}</span></p>
                        </div>
                    </div>
                </div>

                <!-- Secondary Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                    <div class="bg-white p-6 rounded-lg shadow-lg">
                        <h4 class="text-xl font-bold text-gray-800">New Listings</h4>
                        <div class="mt-2 p-4 bg-gray-100 rounded-lg">
                            <p class="text-gray-700">{{ new_listings }} new cars added this week</p>
                            <p class="text-gray-700">Most popular: <span class="font-semibold">{{ most_popular_car != null ? most_popular_car.name : '' }}</span></p>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-lg">
                        <h4 class="text-xl font-bold text-gray-800">Users</h4>
                        <div class="mt-2 p-4 bg-gray-100 rounded-lg">
                            <p class="text-gray-700">Total Users: <span class="font-semibold text-blue-600">{{ total_users }}</span></p>
                            <p class="text-gray-700">New Signups: <span class="font-semibold text-green-600">{{ new_sign_up }}</span> this week</p>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-lg">
                        <h4 class="text-xl font-bold text-gray-800">Customer Ratings</h4>
                        <div class="mt-2 p-4 bg-gray-100 rounded-lg">
                            <p class="text-gray-700">Average Rating: <span class="font-semibold text-yellow-500">{{average_rating}}/5</span></p>
                            <p class="text-gray-700">Most Praised Feature: <span class="font-semibold">{{ most_praised_feature }}</span></p>
                        </div>
                    </div>
                </div>
        </div>
    </div>

    </AuthenticatedLayout>
</template>
