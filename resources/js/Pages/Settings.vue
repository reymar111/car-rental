<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';

</script>

<template>
    <Head title="Settings" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Settings
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
                                    <svg className="w-6 h-6 text-black" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M12 20a7.966 7.966 0 0 1-5.002-1.756l.002.001v-.683c0-1.794 1.492-3.25 3.333-3.25h3.334c1.84 0 3.333 1.456 3.333 3.25v.683A7.966 7.966 0 0 1 12 20ZM2 12C2 6.477 6.477 2 12 2s10 4.477 10 10c0 5.5-4.44 9.963-9.932 10h-.138C6.438 21.962 2 17.5 2 12Zm10-5c-1.84 0-3.333 1.455-3.333 3.25S10.159 13.5 12 13.5c1.84 0 3.333-1.455 3.333-3.25S13.841 7 12 7Z" clip-rule="evenodd"/>
                                    </svg>

                                    &nbsp; Owners
                                </Link>
                                </li>
                                <li>
                                    <Link
                                        :href="route('car.index')"
                                        :class="route().current('car.index') ? 'inline-flex items-center px-4 py-3 rounded-lg text-black bg-blue-300 hover:text-blue-900  hover:bg-blue-100 w-full' : 'inline-flex items-center px-4 py-3 rounded-lg hover:text-gray-900 bg-gray-100 hover:bg-blue-100 w-full '"
                                    >
                                    <svg class="w-6 h-6 text-black" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.153 19 21 12l-4.847-7H3l4.848 7L3 19h13.153Z"/>
                                    </svg>

                                        &nbsp; Cars
                                    </Link>
                                </li>

                                <li>
                                    <Link
                                        :href="route('brand.index')"
                                        :class="route().current('brand.index') ? 'inline-flex items-center px-4 py-3 rounded-lg text-black bg-blue-300 hover:text-blue-900  hover:bg-blue-100 w-full' : 'inline-flex items-center px-4 py-3 rounded-lg hover:text-gray-900 bg-gray-100 hover:bg-blue-100 w-full '"
                                    >
                                    <svg class="w-6 h-6 text-black" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 8v8m0-8h8M8 8H6a2 2 0 1 1 2-2v2Zm0 8h8m-8 0H6a2 2 0 1 0 2 2v-2Zm8 0V8m0 8h2a2 2 0 1 1-2 2v-2Zm0-8h2a2 2 0 1 0-2-2v2Z"/>
                                    </svg>

                                    &nbsp; Car - Brands
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

                                        &nbsp; Car - Models
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

                                        &nbsp; Car - Types
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

                                        &nbsp; Car - Colors
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

                                        &nbsp; Payment Modes
                                    </Link>
                                </li>


                                <li>
                                    <Link
                                        :href="route('route.index')"
                                        :class="route().current('route.index') ? 'inline-flex items-center px-4 py-3 rounded-lg text-black bg-blue-300 hover:text-blue-900  hover:bg-blue-100 w-full' : 'inline-flex items-center px-4 py-3 rounded-lg hover:text-gray-900 bg-gray-100 hover:bg-blue-100 w-full '"
                                    >
                                    <svg class="w-6 h-6 text-black" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M10.271 5.575C8.967 4.501 7 5.43 7 7.12v9.762c0 1.69 1.967 2.618 3.271 1.544l5.927-4.881a2 2 0 0 0 0-3.088l-5.927-4.88Z" clip-rule="evenodd"/>
                                    </svg>

                                        &nbsp; Province
                                    </Link>
                                </li>

                                <li>
                                    <Link
                                        :href="route('route_city.index')"
                                        :class="route().current('route_city.index') ? 'inline-flex items-center px-4 py-3 rounded-lg text-black bg-blue-300 hover:text-blue-900  hover:bg-blue-100 w-full' : 'inline-flex items-center px-4 py-3 rounded-lg hover:text-gray-900 bg-gray-100 hover:bg-blue-100 w-full '"
                                    >
                                    <svg class="w-6 h-6 text-black" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M10.271 5.575C8.967 4.501 7 5.43 7 7.12v9.762c0 1.69 1.967 2.618 3.271 1.544l5.927-4.881a2 2 0 0 0 0-3.088l-5.927-4.88Z" clip-rule="evenodd"/>
                                    </svg>

                                        &nbsp; Cities
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
