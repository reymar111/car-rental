<script >
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';


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

            release_car: useForm({
                id: null,
                transaction_number: '',
                active: false,
            }),


            return_car: useForm({
                id: null,
                transaction_number: '',
                active: false,
            }),

            is_released: false,
            is_returned: false,

            loading_button: false,

            rating: useForm({
                active: false,
                value: 0,
                hoverRating: 0,
                notes: '',
                is_rating: false,
                is_success: false,
                car_rental_id: '',

            }),
        };
    },
    computed: {
        user() {
            return usePage().props.auth.user // Get the authenticated user
        },
        computeReturnDate() {
            if (this.rent.number_days > 0 && this.rent.pickup_date != '') {
                const pickupDate = new Date(this.rent.pickup_date);
                pickupDate.setDate(pickupDate.getDate() + this.rent.number_days + 1);
                        // Format to MM/DD/YYYY
                const formattedDate = `${pickupDate.getMonth() + 1}/${pickupDate.getDate()}/${pickupDate.getFullYear()}`;
                return formattedDate;
            }

            return null;
        },

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
        goBack() {
            window.history.back();
        }
    },

    methods: {
        OpenreleaseCarDialog(item) {
            this.release_car.id = item.id
            this.release_car.transaction_number = item.transaction_number
            this.release_car.active = true
        },

        closeReleaseCarDialog() {
            this.release_car.id = null
            this.release_car.transaction_number = ''
            this.release_car.active = false
        },

        release() {
            this.release_car.post('/transaction/release/'+this.release_car.id, {
                onStart: () => {
                    this.loading_button = true;
                },
                onFinish: () => {
                    this.loading_button = false;
                    this.is_released = true
                    this.closeReleaseCarDialog()
                },
                onSuccess: () => {;
                    this.release_car.reset();
                },
            });
        },

        OpenReturnCarDialog(item) {
            this.return_car.id = item.id
            this.return_car.transaction_number = item.transaction_number
            this.return_car.active = true
        },

        closeReturnCarDialog() {
            this.return_car.id = null
            this.return_car.transaction_number = ''
            this.return_car.active = false
        },

        returnCar() {
            this.return_car.post('/transaction/return/'+this.return_car.id, {
                onStart: () => {
                    this.loading_button = true;
                },
                onFinish: () => {
                    this.loading_button = false;
                    this.is_returned = true
                    this.closeReturnCarDialog()
                },
                onSuccess: () => {;
                    this.return_car.reset();
                },
            });
        },

        openRating(item) {
            this.rating.car_rental_id = item
            this.rating.active = true
        },

        closeRating() {
            this.rating.active = false
            this.rating.value = 0
            this.rating.hoverRating = 0
            this.rating.notes = ''
            this.rating.is_rating = false
            this.rating.car_rental_id = ''
        },

        setRating(star) {
            this.rating.value = star;
        },
        submitRating() {
            this.rating.post('/rating/store/'+this.rating.car_rental_id, {
                onStart: () => {
                    this.rating.is_rating = true;
                },
                onFinish: () => {
                    this.rating.is_rating = false;
                    this.rating.is_success = true
                    this.closeRating()
                },
                onSuccess: () => {
                    this.modal = false;
                    this.form.reset();
                },
            });
        },
    }
};
</script>

<template>
    <Head title="Show" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="flex text-xl font-semibold leading-tight text-gray-800 justify-between items-center">
                🛒 {{ rent.transaction_number }}

                <div class="flex gap-2">
                    <Link :href="route('payment.create', {'rental' : rent.id})" v-if="rent.status_id === 2 && user.id === rent.user_id"
                        class="w-full sm:w-auto bg-blue-800 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 text-white rounded-lg inline-flex items-center justify-center px-4 py-2.5 dark:bg-blue-700 dark:hover:bg-blue-600 dark:focus:ring-blue-700">
                        <svg class="w-6 h-6 text-white-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M6 14h2m3 0h5M3 7v10a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1Z"/>
                        </svg>

                        <div class="text-sm font-semibold">Pay</div>
                    </Link>

                    <Link :href="route('rental.edit', {'rental' : rent.id})"  v-if="rent.status_id === 2"
                        class="w-full sm:w-auto bg-yellow-800 hover:bg-yellow-700 focus:ring-4 focus:outline-none focus:ring-yellow-300 text-white rounded-lg inline-flex items-center justify-center px-4 py-2.5 dark:bg-yellow-700 dark:hover:bg-yellow-600 dark:focus:ring-yellow-700">
                        <svg class="w-6 h-6 text-white-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                        </svg>
                        <div class="text-sm font-semibold">Edit</div>
                    </Link>

                    <button  @click="OpenreleaseCarDialog(rent)" v-if="rent.status_id === 3 && user.is_admin === 1"
                        class="w-full sm:w-auto bg-teal-800 hover:bg-teal-700 focus:ring-4 focus:outline-none focus:ring-teal-300 text-white rounded-lg inline-flex items-center justify-center px-4 py-2.5 dark:bg-teal-700 dark:hover:bg-teal-600 dark:focus:ring-teal-700">
                        <svg class="w-6 h-6 text-white-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m14 0-4 4m4-4-4-4"/>
                        </svg>

                        <div class="text-sm font-semibold">RELEASE CAR</div>
                    </button>

                    <button  @click="OpenReturnCarDialog(rent)" v-if="rent.status_id === 4 && user.is_admin === 1"
                        class="w-full sm:w-auto bg-orange-800 hover:bg-orange-700 focus:ring-4 focus:outline-none focus:ring-orange-300 text-white rounded-lg inline-flex items-center justify-center px-4 py-2.5 dark:bg-orange-700 dark:hover:bg-orange-600 dark:focus:ring-orange-700">
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l4-4m-4 4 4 4"/>
                        </svg>


                        <div class="text-sm font-semibold">RETURN CAR</div>
                    </button>

                    <button  @click="openRating(rent.id)" v-if="rent.status_id === 5 && rent.user_id == user.id && rent.rating == null"
                        class="w-full sm:w-auto bg-yellow-800 hover:bg-yellow-700 focus:ring-4 focus:outline-none focus:ring-yellow-300 text-white rounded-lg inline-flex items-center justify-center px-4 py-2.5 dark:bg-teal-700 dark:hover:bg-teal-600 dark:focus:ring-teal-700">
                        <div class="text-sm font-semibold">RATE YOUR EXPERIENCE</div>
                    </button>
                </div>
            </h2>

        </template>

        <div class="py-10 h-full">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 h-full">

                <div v-if="is_released" id="alert-border-2" class="flex items-center p-4 mb-4 text-green-800 border-t-4 border-green-300 bg-green-50  dark:border-green-800" role="alert">
                    <svg class="shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <div class="ms-3 text-sm font-medium">
                    Car released successfully
                    </div>
                    <button @click="is_released = false" type="button" class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8  dark:text-green-400 "  data-dismiss-target="#alert-border-2" aria-label="Close">
                    <span class="sr-only">Dismiss</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    </button>
                </div>

                <div v-if="is_returned" id="alert-border-2" class="flex items-center p-4 mb-4 text-green-800 border-t-4 border-green-300 bg-green-50  dark:border-green-800" role="alert">
                    <svg class="shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <div class="ms-3 text-sm font-medium">
                    Car returned successfully
                    </div>
                    <button @click="is_released = false" type="button" class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8  dark:text-green-400 "  data-dismiss-target="#alert-border-2" aria-label="Close">
                    <span class="sr-only">Dismiss</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    </button>
                </div>

                <div class="overflow-hidden bg-gray shadow-sm sm:rounded-lg h-full flex flex-col md:flex-row">
                    <!-- Column 1 -->
                    <div class="w-full md:w-1/2 p-4 border-b md:border-b-0 md:border-r border-gray-300">
                        <div class="relative z-0 w-full mb-5 group">
                            <div class="w-full p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-8 dark:bg-white-800">
                                <div class="flex items-center justify-between mb-4">
                                    <h5 class="text-xl font-bold leading-none text-gray-900 border-gray-100">Car Info</h5>
                                </div>

                                <div class="overflow-x-auto">
                                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        <tbody>
                                            <tr class="bg-white border-b text-black border-gray-200">
                                                <th scope="row" class="px-6 py-4 ">
                                                    Rent Status
                                                </th>
                                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                                                    {{ rent.status }}
                                                </td>
                                            </tr>
                                            <tr class="bg-white border-b text-black border-gray-200">
                                                <th scope="row" class="px-6 py-4 ">
                                                    Renter
                                                </th>
                                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                                                    {{ rent.user != null ? rent.user.name : '' }}
                                                </td>
                                            </tr>
                                            <tr class="bg-white border-b text-black border-gray-200">
                                                <th scope="row" class="px-6 py-4 ">
                                                    Destination
                                                </th>
                                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                                                {{ rent.city != null ? rent.city.name+', ' : '' }} {{ rent.province != null ? rent.province.name : '' }}
                                                </td>
                                            </tr>
                                            <tr class="bg-white border-b text-black border-gray-200">
                                                <th scope="row" class="px-6 py-4 ">
                                                    Car Details
                                                </th>
                                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                                                    {{ rent != null ? '🚘 '+ rent.car.model.brand.name+ ' - '+ rent.car.model.name + ' ' + rent.car.year : ''}}<br>
                                                    {{ rent != null ? 'Plate #: '+rent.car.plate_number : '' }} <br>
                                                    {{ rent != null ? 'Owner: '+rent.car.owner.full_name : '' }}
                                                </td>
                                            </tr>
                                            <tr class="bg-white border-b text-black border-gray-200">
                                                <th scope="row" class="px-6 py-4 ">
                                                    With Driver
                                                </th>
                                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                                                {{ rent.with_driver ? 'Yes' : 'No' }}
                                                </td>
                                            </tr>
                                            <tr class="bg-white border-b text-black border-gray-200">
                                                <th scope="row" class="px-6 py-4 ">
                                                    Number of Passengers
                                                </th>
                                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                                                {{ rent.number_passenger }}
                                                </td>
                                            </tr>
                                            <tr class="bg-white border-b text-black border-gray-200">
                                                <th scope="row" class="px-6 py-4 ">
                                                    Rent Days
                                                </th>
                                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                                                {{ rent.number_days }}
                                                </td>
                                            </tr>
                                            <tr class="bg-white border-b text-black border-gray-200">
                                                <th scope="row" class="px-6 py-4 ">
                                                    Pickup Date
                                                </th>
                                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                                                {{ rent.pickup_date }}
                                                </td>
                                            </tr>
                                            <tr class="bg-white border-b text-black border-gray-200">
                                                <th scope="row" class="px-6 py-4 ">
                                                    Return Date
                                                </th>
                                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                                                {{ computeReturnDate }}
                                                </td>
                                            </tr>

                                            <tr class="bg-white border-b text-black border-gray-200" v-if="rent.rating != null">
                                                <th scope="row" class="px-6 py-4 ">
                                                    Rating
                                                </th>
                                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                                                    <span class="flex justify-left mb-3">
                                                        <span v-for="star in 5" :key="star">
                                                            <svg class="w-5 h-5"
                                                                :class="star <= rent.rating.value ? 'text-yellow-400' : 'text-gray-300'"
                                                                aria-hidden="true"
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                fill="currentColor"
                                                                viewBox="0 0 22 20">
                                                                <path
                                                                    d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                                                            </svg>
                                                        </span>
                                                    </span>
                                                </td>
                                            </tr>

                                            <tr class="bg-white border-b text-black border-gray-200" v-if="rent.rating != null">
                                                <th scope="row" class="px-6 py-4 ">
                                                    Feedback
                                                </th>
                                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                                                {{ rent.rating != null ? rent.rating.notes : '' }}
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
                        <div class="bg-white border p-0 border-gray-200 shadow-sm sm:p-8 dark:bg-white-800 rounded-lg flex flex-col h-full">
                            <div class="flex items-center justify-between mb-4">
                                <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-black">Billing Info</h5>
                            </div>

                            <div class="relative overflow-x-auto">
                                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        <tbody>
                                            <tr class="bg-white border-b text-black border-gray-200">
                                                <th scope="row" colspan="2" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                                                    {{ rent.car != null ? '🚘 '+ rent.car.model.brand.name+ ' - '+ rent.car.model.name + ' ' + rent.car.year : ''}}
                                                </th>
                                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                                                    <span v-if="rent">
                                                    ₱{{ getProvince.is_within ? rent.car.model.type.rental_within : rent.car.model.type.rental_without }}/day
                                                </span>
                                                <span v-else>
                                                    N/A
                                                </span>
                                                </th>
                                                <th  class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">

                                                </th>

                                            </tr>
                                            <tr class="bg-white border-b text-black border-gray-200">
                                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                                                    Number of Days
                                                </th>
                                                <th class="px-6 py-4">

                                                </th>
                                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                                                    {{ rent.number_days }}
                                                </th>
                                                <th class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap  text-right">
                                                    ₱ {{ getSumNumberDays}}
                                                </th>
                                            </tr>
                                            <tr class="bg-white text-black">
                                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                                                    With Driver
                                                </th>
                                                <th class="px-6 py-4">

                                                </th>
                                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                                                    {{ rent.with_driver ? 'Yes (₱1000/day)' : 'No' }}
                                                </th>
                                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap  text-right">
                                                    {{ rent.with_driver ? '₱ '+rent.number_days * 1000 : '' }}
                                                </th>
                                            </tr>
                                            <tr class="bg-white text-black">
                                                <th scope="row" colspan="3" class="text-right px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                                                    Sum Total
                                                </th>
                                                <th scope="row" colspan="3" class="text-right px-6 py-4 font-medium text-gray-900 whitespace-nowrap  text-right">
                                                    ₱ {{ rent.total_amount }}
                                                </th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                        </div>

                        <div class="bg-white border p-0 border-gray-200 shadow-sm sm:p-8 dark:bg-white-800 rounded-lg flex flex-col h-full">
                            <div class="flex items-center justify-between mb-4">
                                <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-black">Payment Info</h5>
                            </div>

                            <div class="relative overflow-x-auto">
                                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        <tbody>
                                            <tr class="bg-white border-b text-black border-gray-200">
                                                <th scope="row" class="px-6 py-4 ">
                                                    Mode of Payment
                                                </th>
                                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                                                    {{ rent.payment != null ? rent.payment.name : ''}}
                                                </td>
                                            </tr>
                                            <tr class="bg-white border-b text-black border-gray-200">
                                                <th scope="row" class="px-6 py-4 ">
                                                    Payment Reference Number
                                                </th>
                                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                                                    {{ rent.proof_payment != null ? rent.proof_payment.reference_number : ''}}
                                                </td>
                                            </tr>
                                            <tr class="bg-white border-b text-black border-gray-200">
                                                <th scope="row" class="px-6 py-4">Proof of Payment</th>
                                                <td class="px-6 py-4">
                                                    <a v-if="rent.proof_payment != null"
                                                    :href="rent.proof_payment.proof_payment_link"
                                                    target="_blank"
                                                    class="px-3 py-1 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 focus:outline-none dark:bg-blue-500 dark:hover:bg-blue-400 dark:focus:ring-blue-600">
                                                        View
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr class="bg-white border-b text-black border-gray-200">
                                                <th scope="row" class="px-6 py-4 ">
                                                    Notes
                                                </th>
                                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                                                    {{ rent.proof_payment != null ? rent.proof_payment.notes : ''}}
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

        <div v-if="release_car.active" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-50">
            <div class="relative p-4 w-full max-w-md">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow-lg">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 border-b">
                        <h3 class="text-lg font-semibold text-gray-900 ">
                            Release this car: {{ release_car.transaction_number }}
                        </h3>
                        <button @click="closeReleaseCarDialog" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="crud-modal">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                    </div>
                    <!-- Modal body -->
                    <form class="p-4">

                        <button @click="release" v-if="!loading_button" class="w-full text-white bg-green-700 hover:bg-green-800 font-medium rounded-lg text-sm px-5 py-2.5">
                            RELEASE
                        </button>

                        <button v-if="loading_button" disabled type="button" class="w-full text-white bg-green-700 hover:bg-green-800 font-medium rounded-lg text-sm px-5 py-2.5">
                            <svg aria-hidden="true" role="status" class="inline w-4 h-4 me-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                            </svg>
                            RELEASING ...
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div v-if="return_car.active" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-50">
            <div class="relative p-4 w-full max-w-md">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow-lg">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 border-b">
                        <h3 class="text-lg font-semibold text-gray-900 ">
                            Return this car: {{ return_car.transaction_number }}
                        </h3>
                        <button @click="closeReturnCarDialog" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="crud-modal">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                    </div>
                    <!-- Modal body -->
                    <form class="p-4">

                        <button @click="returnCar" v-if="!loading_button" class="w-full text-white bg-green-700 hover:bg-green-800 font-medium rounded-lg text-sm px-5 py-2.5">
                            RETURN
                        </button>

                        <button v-if="loading_button" disabled type="button" class="w-full text-white bg-green-700 hover:bg-green-800 font-medium rounded-lg text-sm px-5 py-2.5">
                            <svg aria-hidden="true" role="status" class="inline w-4 h-4 me-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                            </svg>
                            RETURNING ...
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div v-if="rating.active" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-50">
            <div class="relative p-4 w-full max-w-md">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow-lg ">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 border-b ">
                        <h3 class="text-lg font-semibold text-gray-900">
                          Your rating is valuable to us!
                        </h3>
                        <button @click="closeRating" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="crud-modal">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                    </div>
                    <!-- Modal body -->
                    <form class="p-4">

                        <div class="flex items-center mb-3">
                            <span
                            v-for="star in 5" :key="star" @click="setRating(star)" @mouseover="rating.hoverRating = star" @mouseleave="rating.hoverRating = 0" class="cursor-pointer">
                            <svg
                                class="w-10 h-10" :class="{ 'text-yellow-400': star <= (rating.hoverRating || rating.value), 'text-gray-300': star > (rating.hoverRating || rating.value), }" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"
                                />
                            </svg>
                            </span>
                        </div>

                        <div class="grid gap-2">
                            <label class="block text-sm font-medium text-gray-900">Notes</label>
                            <textarea v-model="rating.notes" rows="3" class="w-full p-2 border rounded-lg text-black border-gray-500" placeholder="" required></textarea>
                            <InputError class="mt-2" :message="rating.notes.name" />
                        </div>

                        <br>

                        <button @click="submitRating" v-if="!rating.is_rating && rating.active" class="w-full text-white bg-green-700 hover:bg-green-800 font-medium rounded-lg text-sm px-5 py-2.5">
                            RATE
                        </button>

                        <button v-if="rating.is_rating" disabled type="button" class="w-full text-white bg-green-700 hover:bg-green-800 font-medium rounded-lg text-sm px-5 py-2.5">
                            <svg aria-hidden="true" role="status" class="inline w-4 h-4 me-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                            </svg>
                            RATING  ...

                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div v-if="rating.is_success" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-50">
            <div class="relative w-full max-w-md max-h-[60vh] bg-white rounded-lg shadow-lg dark:bg-gray-700 flex flex-col">
                <!-- Modal Header -->
                <div class="p-4 border-b dark:border-gray-600 flex items-center justify-between sticky top-0 bg-white z-10">
                    <h3 class="text-lg font-semibold text-gray-900">Success</h3>
                </div>

                <!-- Scrollable Content Section -->
                <div class="overflow-y-auto max-h-[40vh] px-4 py-3 space-y-3 bg-white">
                    <p class="text-gray-600">
                        Thank your for your feedback. It means a lot to us!
                    </p>
                </div>

                <!-- Close Button (Fixed at Bottom) -->
                <div class="p-4 border-t dark:border-gray-600 bg-white sticky bottom-0 z-10">
                    <Link :href="route('rental.show', {rental: rent.id})">
                        <button @click="rating.is_success = false" class="w-full text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-4 py-2.5">
                            Close
                        </button>
                    </Link>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
