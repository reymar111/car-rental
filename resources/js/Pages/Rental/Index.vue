<script >
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Link, useForm } from '@inertiajs/vue3';


export default {
    props: ['rentals', 'is_canceled'],
    components: {
        AuthenticatedLayout,
        Head,
        Link,
    },
    data() {
        return {
            search: '',
            rating: useForm({
                active: false,
                value: 0,
                hoverRating: 0,
                notes: '',
                is_rating: false,
                is_success: false,
                car_rental_id: '',

            }),

            current_cancel: useForm({
                id: '',
                transaction_number: '',
                active: false
            }),

            loading_button: false,
        };
    },
    methods: {
        openCancelModal(item) {
            this.current_cancel.id = item.id
            this.current_cancel.transaction_number = item.transaction_number
            this.current_cancel.active = true
        },
        closeCancelModal() {
            this.current_cancel.id = ''
            this.current_cancel.transaction_number = ''
            this.current_cancel.active = false
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
        cancelTrip() {
            this.loading_button = true
            this.current_cancel.patch('/rental/cancel/'+this.current_cancel.id, {
                onStart: () => {
                    this.loading_button = true
                },
                onFinish: () => {
                    this.loading_button = false
                    this.closeCancelModal()
                },
                onSuccess: () => {
                    this.loading_button = false
                    this.closeCancelModal()
                },
            });
        },
    }
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

                        <div v-if="is_canceled" id="alert-border-2" class="flex items-center p-4 mb-4 text-green-800 border-t-4 border-green-300 bg-green-50 dark:text-green-400 dark:bg-gray-800 dark:border-green-800" role="alert">
                            <svg class="shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                            </svg>
                            <div class="ms-3 text-sm font-medium">
                                Trip canceled!
                            </div>
                        </div>


                        <div v-for="(item, index) in rentals" :key="index"
                                    class="w-full p-4 mb-3 text-left bg-white border border-gray-200 rounded-lg shadow-xl sm:p-8
                                    transition duration-100 ease-in-out transform hover:shadow-1xl hover:scale-104 hover:border-blue-500">

                                    <h5 class="mb-2 text-3xl font-bold text-gray-900  flex justify-between items-center">
                                        <span>
                                            {{ item.city != null ? item.city.name+ ',' : ''}} {{ item.province != null ? item.province.name : '' }}
                                        </span>
                                        <span class="text-lg text-blue-600 font-medium">{{ item.status }}</span>
                                    </h5>

                            <p class="mb-1 text-base text-gray-500 sm:text-lg">🛒 {{ item.transaction_number }}</p>
                            <p class="mb-1 text-base text-gray-500 sm:text-lg">🚗 {{ item.car.model.brand.name }} {{ item.car.model.name }} {{ item.car.year }}</p>

                            <div class="flex items-center justify-start space-x-4">
                                <!-- View Button -->
                                <Link :href="route('rental.show', {'rental' : item.id})" class="
                                        w-full sm:w-auto bg-blue-800 hover:bg-blue-700 inline-flex items-center justify-center
                                        text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-cyan-300
                                        font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                                    <svg class="w-6 h-6 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/>
                                        <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                    </svg>
                                    <span class="text-sm font-semibold">View</span>
                                </Link>

                                <!-- Pay Button -->
                                <Link v-if="item.status_id == 2" :href="route('payment.create', {'rental' : item.id})" class="
                                        w-full sm:w-auto bg-blue-800 hover:bg-blue-700 inline-flex items-center justify-center
                                        text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300
                                        font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                                    <svg class="w-6 h-6 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M6 14h2m3 0h5M3 7v10a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1Z"/>
                                    </svg>
                                    <span class="text-sm font-semibold">Pay</span>
                                </Link>

                                <!-- Cancel Button -->
                                <button v-if="item.status_id == 2 || item.status_id == 3 || item.status_id == 6 || item.status_id == 7" @click="openCancelModal(item)" class="
                                        w-full sm:w-auto bg-blue-800 hover:bg-blue-700 inline-flex items-center justify-center
                                        text-white bg-gradient-to-r from-orange-500 via-orange-600 to-orange-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-orange-300
                                        font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                                        <svg class="w-6 h-6 text-white-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
[                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/>
                                        </svg>

                                    <span class="text-sm font-semibold">Cancel</span>
                                </button>

                                <button v-if="item.status_id == 5 && item.rating == null" @click="openRating(item.id)" class="
                                        w-full sm:w-auto bg-blue-800 hover:bg-blue-700 inline-flex items-center justify-center
                                        text-white bg-gradient-to-r from-green-500 via-green-600 to-green-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300
                                        font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                                        <svg class="me-3 w-7 h-7" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15v4m6-6v6m6-4v4m6-6v6M3 11l6-5 6 5 5.5-5.5"/>
                                    </svg>
                                    <span class="text-sm font-semibold">Rate</span>
                                </button>

                                <span class="flex justify-end mb-3" v-if="item.rating != null">
                                        <span v-for="star in 5" :key="star">
                                            <svg class="w-10 h-10"
                                                :class="star <= item.rating.value ? 'text-yellow-400' : 'text-gray-300'"
                                                aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg"
                                                fill="currentColor"
                                                viewBox="0 0 22 20">
                                                <path
                                                    d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                                            </svg>
                                        </span>
                                    </span>
                            </div>

                        </div>

                    </div>
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
                    <Link :href="route('rental.index')">
                        <button @click="rating.is_success = false" class="w-full text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-4 py-2.5">
                            Close
                        </button>
                    </Link>
                </div>
            </div>
        </div>

        <div v-if="current_cancel.active" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-50">
            <div class="relative p-4 w-full max-w-md">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow-lg dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 border-b dark:border-gray-600">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                          Cancel {{current_cancel.transaction_number }}
                        </h3>


                        <button @click="closeCancelModal" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="crud-modal">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                    </div>
                    <!-- Modal body -->
                    <form class="p-4">
                        <h4 class="text-md mb-2 text-gray-900 dark:text-white">
                            Canceling this trip is irreversible. Are you sure you want to cancel this trip?
                        </h4>

                        <button @click="cancelTrip" v-if="!loading_button && current_cancel.active" class="w-full text-white bg-red-700 hover:bg-red-800 font-medium rounded-lg text-sm px-5 py-2.5">
                            YES, CANCEL
                        </button>

                        <button v-if="loading_button" disabled type="button" class="w-full text-white bg-red-700 hover:bg-red-800 font-medium rounded-lg text-sm px-5 py-2.5">
                            <svg aria-hidden="true" role="status" class="inline w-4 h-4 me-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                            </svg>
                            Cancelling ...

                        </button>
                    </form>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
