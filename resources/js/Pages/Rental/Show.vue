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
    computed: {
        getProvince() {
            return this.provinces.find(route => route.id === this.rent.route_id) || null;
        },

        getSumNumberDays() {
            if(this.rent.car != null) {
                let amount = this.getProvince.is_within
                    ? this.rent.car.model.type.rental_within
                    : this.rent.car.model.type.rental_without;

                let number_days = this.rent.number_days;

                return amount * number_days;
            }
        },
    }
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

        <div class="py-10 h-full">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 h-full">
        <div class="overflow-hidden bg-gray shadow-sm sm:rounded-lg h-full flex flex-col md:flex-row">
            <!-- Column 1 -->
            <div class="w-full md:w-1/2 p-4 border-b md:border-b-0 md:border-r border-gray-300">
                <div class="relative z-0 w-full mb-5 group">
                    <div class="w-full p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-8 dark:bg-white-800 dark:border-gray-700">
                        <div class="flex items-center justify-between mb-4">
                            <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-black">Car Info</h5>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <tbody>
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                        <th scope="row" class="px-6 py-4 ">
                                            Rent Status
                                        </th>
                                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ rent.status }}
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                        <th scope="row" class="px-6 py-4 ">
                                            Destination
                                        </th>
                                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                           {{ rent.city != null ? rent.city.name+', ' : '' }} {{ rent.province != null ? rent.province.name : '' }}
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                        <th scope="row" class="px-6 py-4 ">
                                            Car Details
                                        </th>
                                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ rent != null ? '🚘 '+ rent.car.model.brand.name+ ' - '+ rent.car.model.name + ' ' + rent.car.year : ''}}<br>
                                            {{ rent != null ? 'Plate #: '+rent.car.plate_number : '' }} <br>
                                            {{ rent != null ? 'Owner: '+rent.car.owner.full_name : '' }}
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                        <th scope="row" class="px-6 py-4 ">
                                            With Driver
                                        </th>
                                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                           {{ rent.with_driver ? 'Yes' : 'No' }}
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                        <th scope="row" class="px-6 py-4 ">
                                            Number of Passengers
                                        </th>
                                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                           {{ rent.number_passenger }}
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                        <th scope="row" class="px-6 py-4 ">
                                            Rent Days
                                        </th>
                                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                           {{ rent.number_days }}
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                        <th scope="row" class="px-6 py-4 ">
                                            Pickup Date
                                        </th>
                                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                           {{ rent.pickup_date }}
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                        <th scope="row" class="px-6 py-4 ">
                                            Return Date
                                        </th>
                                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                           {{ rent.return_date }}
                                        </td>
                                    </tr>


                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Column 2 (Grid with 2 Full Rows) -->
            <div class="w-full md:w-1/2 p-4 grid grid-rows-2 gap-4 h-full">
                <div class="bg-white border p-0 border-gray-200 shadow-sm sm:p-8 dark:bg-white-800 dark:border-gray-700 rounded-lg flex flex-col h-full">
                    <div class="flex items-center justify-between mb-4">
                        <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-black">Billing Info</h5>
                    </div>

                    <div class="relative overflow-x-auto">
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <tbody>
                                    <tr class="bg-white border-b dark:bg-gray-800 border-gray-200">
                                        <th scope="row" colspan="2" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ rent.car != null ? '🚘 '+ rent.car.model.brand.name+ ' - '+ rent.car.model.name + ' ' + rent.car.year : ''}}
                                        </th>
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            <span v-if="rent">
                                            ₱{{ getProvince.is_within ? rent.car.model.type.rental_within : rent.car.model.type.rental_without }}/day
                                        </span>
                                        <span v-else>
                                            N/A
                                        </span>
                                        </th>
                                        <th  class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">

                                        </th>

                                    </tr>
                                    <tr class="bg-white border-b dark:bg-gray-800 border-gray-200">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            Number of Days
                                        </th>
                                        <th class="px-6 py-4">

                                        </th>
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ rent.number_days }}
                                        </th>
                                        <th class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-right">
                                            ₱ {{ getSumNumberDays}}
                                        </th>
                                    </tr>
                                    <tr class="bg-white dark:bg-gray-800">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            With Driver
                                        </th>
                                        <th class="px-6 py-4">

                                        </th>
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ rent.with_driver ? 'Yes (₱1000/day)' : 'No' }}
                                        </th>
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-right">
                                            {{ rent.with_driver ? '₱ '+rent.number_days * 1000 : '' }}
                                        </th>
                                    </tr>
                                    <tr class="bg-white dark:bg-gray-800">
                                        <th scope="row" colspan="3" class="text-right px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            Sum Total
                                        </th>
                                        <th scope="row" colspan="3" class="text-right px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-right">
                                            ₱ {{ rent.total_amount }}
                                        </th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                </div>

                <div class="bg-white border p-0 border-gray-200 shadow-sm sm:p-8 dark:bg-white-800 dark:border-gray-700 rounded-lg flex flex-col h-full">
                    <div class="flex items-center justify-between mb-4">
                        <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-black">Payment Info</h5>
                    </div>

                    <div class="relative overflow-x-auto">
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <tbody>
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                        <th scope="row" class="px-6 py-4 ">
                                            Mode of Payment
                                        </th>
                                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ rent.payment != null ? rent.payment.name : ''}}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>




    </AuthenticatedLayout>
</template>
