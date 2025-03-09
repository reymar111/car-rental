<script >
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';


export default {
    props: ['rentals'],
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
    <Head title="My Travels" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                My Travels
            </h2>
        </template>

        <div class="py-10">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-9 text-gray-900">

                        <div class="flex items-center gap-2">
                            <!-- Buttons -->
                            <Link :href="route('rental.create')">
                                <button type="button" class="px-6 py-3.5 text-base font-medium text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 rounded-lg text-center me-2 mb-2">
                                    RENT A CAR
                                </button>
                            </Link>
                        </div>


                        <div v-for="(item, index) in rentals" :key="index"
                                    class="w-full p-4 mb-3 text-left bg-white border border-gray-200 rounded-lg shadow-xl sm:p-8 dark:bg-gray-800 dark:border-gray-700
                                    transition duration-100 ease-in-out transform hover:shadow-1xl hover:scale-104 hover:border-blue-500">
                            <h5 class="mb-2 text-3xl font-bold text-gray-900 dark:text-white flex justify-between items-center">
                                <span>
                                    {{ item.city != null ? item.city.name+ ',' : ''}} {{ item.province != null ? item.province.name : '' }}
                                </span>
                                <span class="text-blue-600 font-medium">For Payment</span>
                            </h5>
                            <p class="mb-1 text-base text-gray-500 sm:text-lg dark:text-gray-400">🛒 {{ item.transaction_number }}</p>
                            <p class="mb-1 text-base text-gray-500 sm:text-lg dark:text-gray-400">🚗 {{ item.car.model.brand.name }} {{ item.car.model.name }} {{ item.car.year }}</p>

                            <div class="items-left justify-left space-y-4 sm:flex sm:space-y-0 sm:space-x-4 rtl:space-x-reverse">

                                <Link :href="route('rental.show', {'rental' : item.id})" class="w-full sm:w-auto bg-blue-800 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 text-white rounded-lg inline-flex items-left justify-center px-4 py-2.5 dark:bg-blue-700 dark:hover:bg-blue-600 dark:focus:ring-blue-700">
                                    <svg class="me-3 w-7 h-7" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/>
                                        <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                    </svg>

                                    <div class="w-12 text-left rtl:text-right">
                                            <div class="mt-1 font-sans text-sm font-semibold">View</div>
                                    </div>
                                </Link>

                                <Link :href="route('rental.edit', {'rental' : item.id})" class="w-full sm:w-auto bg-green-800 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 text-white rounded-lg inline-flex items-left justify-center px-4 py-2.5 dark:bg-green-700 dark:hover:bg-green-600 dark:focus:ring-green-700">
                                    <svg class="w-6 h-6 text-white-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                                    </svg>

                                    <div class="w-12 text-left rtl:text-right">
                                            <div class="mt-1 font-sans text-sm font-semibold">Edit</div>
                                    </div>
                                </Link>

                                <!-- <a href="#" class="w-full sm:w-auto bg-gray-800 hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-300 text-white rounded-lg inline-flex items-center justify-center px-4 py-2.5 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700">
                                    <svg class="me-3 w-7 h-7" aria-hidden="true" focusable="false" data-prefix="fab" data-icon="google-play" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M325.3 234.3L104.6 13l280.8 161.2-60.1 60.1zM47 0C34 6.8 25.3 19.2 25.3 35.3v441.3c0 16.1 8.7 28.5 21.7 35.3l256.6-256L47 0zm425.2 225.6l-58.9-34.1-65.7 64.5 65.7 64.5 60.1-34.1c18-14.3 18-46.5-1.2-60.8zM104.6 499l280.8-161.2-60.1-60.1L104.6 499z"></path></svg>


                                    <svg class="me-3 w-7 h-7" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15v4m6-6v6m6-4v4m6-6v6M3 11l6-5 6 5 5.5-5.5"/>
                                    </svg>


                                    <div class="text-left rtl:text-right">
                                        <div class="mt-0 font-sans text-sm font-semibold"> Rate</div>
                                    </div>
                                </a> -->
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
