<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';

</script>

<template>
    <Head title="Reports" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Reports
            </h2>
        </template>

        <div class="py-10">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 p-4">
                            <div class="...">
                                <ul class="flex-column space-y space-y-4 text-sm font-medium text-gray-500 md:me-4 mb-4 md:mb-0">
                                <li>
                                    <Link
                                        :href="route('owner.index')"
                                        :class="route().current('owner.index') ? 'inline-flex items-center px-4 py-3 rounded-lg text-black bg-blue-300 hover:text-blue-900  hover:bg-blue-100 w-full' : 'inline-flex items-center px-4 py-3 rounded-lg hover:text-gray-900 bg-gray-100 hover:bg-blue-100 w-full '"
                                    >
                                    <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M6 14h2m3 0h5M3 7v10a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1Z"/>
                                    </svg>


                                    &nbsp; Revenues Report
                                </Link>
                                </li>
                                <li>
                                    <Link
                                        :href="route('car.index')"
                                        :class="route().current('car.index') ? 'inline-flex items-center px-4 py-3 rounded-lg text-black bg-blue-300 hover:text-blue-900  hover:bg-blue-100 w-full' : 'inline-flex items-center px-4 py-3 rounded-lg hover:text-gray-900 bg-gray-100 hover:bg-blue-100 w-full '"
                                    >
                                    <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M6 2a2 2 0 0 0-2 2v15a3 3 0 0 0 3 3h12a1 1 0 1 0 0-2h-2v-2h2a1 1 0 0 0 1-1V4a2 2 0 0 0-2-2h-8v16h5v2H7a1 1 0 1 1 0-2h1V2H6Z" clip-rule="evenodd"/>
                                    </svg>


                                        &nbsp; Booking Report
                                    </Link>
                                </li>
                                <li>
                                    <Link
                                        :href="route('car.index')"
                                        :class="route().current('car.index') ? 'inline-flex items-center px-4 py-3 rounded-lg text-black bg-blue-300 hover:text-blue-900  hover:bg-blue-100 w-full' : 'inline-flex items-center px-4 py-3 rounded-lg hover:text-gray-900 bg-gray-100 hover:bg-blue-100 w-full '"
                                    >
                                    <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m17 21-5-4-5 4V3.889a.92.92 0 0 1 .244-.629.808.808 0 0 1 .59-.26h8.333a.81.81 0 0 1 .589.26.92.92 0 0 1 .244.63V21Z"/>
                                    </svg>


                                        &nbsp; Payment Transactions Report
                                    </Link>
                                </li>

                                <li>
                                    <Link
                                        :href="route('brand.index')"
                                        :class="route().current('brand.index') ? 'inline-flex items-center px-4 py-3 rounded-lg text-black bg-blue-300 hover:text-blue-900  hover:bg-blue-100 w-full' : 'inline-flex items-center px-4 py-3 rounded-lg hover:text-gray-900 bg-gray-100 hover:bg-blue-100 w-full '"
                                    >
                                    <svg class="w-6 h-6 text-gray-800 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7H7.312"/>
                                    </svg>


                                    &nbsp; Car Utilization Report
                                </Link>
                                </li>

                                <li>
                                    <Link
                                        :href="route('model.index')"
                                        :class="route().current('model.index') ? 'inline-flex items-center px-4 py-3 rounded-lg text-black bg-blue-300 hover:text-blue-900  hover:bg-blue-100 w-full' : 'inline-flex items-center px-4 py-3 rounded-lg hover:text-gray-900 bg-gray-100 hover:bg-blue-100 w-full '"
                                    >
                                        <svg class="w-6 h-6 text-black" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 6H6m12 4H6m12 4H6m12 4H6"/>
                                        </svg>

                                        &nbsp; Payment Transactions Report
                                    </Link>
                                </li>

                                <li>
                                    <Link
                                        :href="route('type.index')"
                                        :class="route().current('type.index') ? 'inline-flex items-center px-4 py-3 rounded-lg text-black bg-blue-300 hover:text-blue-900  hover:bg-blue-100 w-full' : 'inline-flex items-center px-4 py-3 rounded-lg hover:text-gray-900 bg-gray-100 hover:bg-blue-100 w-full '"
                                    >
                                    <svg class="w-6 h-6 text-black" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 14v4.833A1.166 1.166 0 0 1 16.833 20H5.167A1.167 1.167 0 0 1 4 18.833V7.167A1.166 1.166 0 0 1 5.167 6h4.618m4.447-2H20v5.768m-7.889 2.121 7.778-7.778"/>
                                    </svg>

                                        &nbsp; Car Owner Earnings Report
                                    </Link>
                                </li>

                                <li>
                                    <Link
                                        :href="route('color.index')"
                                        :class="route().current('color.index') ? 'inline-flex items-center px-4 py-3 rounded-lg text-black bg-blue-300 hover:text-blue-900  hover:bg-blue-100 w-full' : 'inline-flex items-center px-4 py-3 rounded-lg hover:text-gray-900 bg-gray-100 hover:bg-blue-100 w-full '"
                                    >
                                    <svg class="w-6 h-6 text-black" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v13H7a2 2 0 0 0-2 2Zm0 0a2 2 0 0 0 2 2h12M9 3v14m7 0v4"/>
                                    </svg>

                                        &nbsp; Car Status Report
                                    </Link>
                                </li>


                                <li>
                                    <Link
                                        :href="route('payment_mode.index')"
                                        :class="route().current('payment_mode.index') ? 'inline-flex items-center px-4 py-3 rounded-lg text-black bg-blue-300 hover:text-blue-900  hover:bg-blue-100 w-full' : 'inline-flex items-center px-4 py-3 rounded-lg hover:text-gray-900 bg-gray-100 hover:bg-blue-100 w-full '"
                                    >
                                    <svg class="w-6 h-6 text-black" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8H5m12 0a1 1 0 0 1 1 1v2.6M17 8l-4-4M5 8a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.6M5 8l4-4 4 4m6 4h-4a2 2 0 1 0 0 4h4a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1Z"/>
                                    </svg>

                                        &nbsp; Customer Feedback Report
                                    </Link>
                                </li>
                            </ul>
                            </div>

                            <div class="col-span-2">
                                <div class="p-1 bg-gray-100 text-medium text-gray-500 dark:text-gray-400 dark:bg-gray-800 rounded-lg w-full overflow-hidden">
                                    <div class="w-full max-w-full overflow-auto">
                                        <slot />
                                    </div>
                                </div>
                            </div>


                        </div>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
