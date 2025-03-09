<script >
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';


export default {
    props: ['rent', 'provinces', 'car_types', 'car_colors', 'payments'],
    components: {
        AuthenticatedLayout,
        Head,
        Link,
    },
    data() {
        return {
            search: '',
        };
    },
};
</script>

<template>
    <Head title="Show" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="flex text-xl font-semibold leading-tight text-gray-800 flex justify-between items-center">
                🛒 {{ rent.transaction_number }}

                <div class="flex gap-2">
                    <Link :href="route('rental.show', {'rental' : rent.id})"
                        class="w-full sm:w-auto bg-blue-800 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 text-white rounded-lg inline-flex items-center justify-center px-4 py-2.5 dark:bg-blue-700 dark:hover:bg-blue-600 dark:focus:ring-blue-700">
                        <svg class="w-6 h-6 text-white-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M6 14h2m3 0h5M3 7v10a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1Z"/>
                        </svg>

                        <div class="text-sm font-semibold">Pay</div>
                    </Link>

                    <Link :href="route('rental.edit', {'rental' : rent.id})"
                        class="w-full sm:w-auto bg-green-800 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 text-white rounded-lg inline-flex items-center justify-center px-4 py-2.5 dark:bg-green-700 dark:hover:bg-green-600 dark:focus:ring-green-700">
                        <svg class="w-6 h-6 text-white-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                        </svg>
                        <div class="text-sm font-semibold">Edit</div>
                    </Link>
                </div>
            </h2>

        </template>

    </AuthenticatedLayout>
</template>
