<script >
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';

export default {
    components: {
        AuthenticatedLayout,
        Head,
        Link,
    },

    props: ['provinces', 'car_types', 'car_colors', 'payments', 'renters'],

    data() {
        return {
            step: 1, // Current step
            steps: [
                { id: 1, title: "Destination", description: "Select your destination" },
                { id: 2, title: "Select A Car", description: "Choose your desired car" },
                { id: 3, title: "Billing & Payment", description: "Setup your payment" },
                { id: 4, title: "Finalize", description: "Finalize your rent" },
            ],
            form: useForm({
                route_id: '',
                route_city_id: '',
                car_id: '',
                number_passenger: 0,
                number_days: 0,
                car_type_id: '',
                with_driver: false,
                car_color_id: '',
                total_amount: '',
                payment_id: '',
                pickup_date: '',
                for_edit: false,
                renter_id: '',
            }),

            cities: [],
            available_cars: [],
            selected_car: null,
            is_searching: false,
            term_condition: false,
            is_success: false,
            is_loading_submission: false,
        };
    },
    computed: {
        user() {
            return usePage().props.auth.user // Get the authenticated user
        },

        computeReturnDate() {
            if (this.form.number_days > 0 && this.form.pickup_date != '') {
                const pickupDate = new Date(this.form.pickup_date);
                pickupDate.setDate(pickupDate.getDate() + this.form.number_days + 1);
                        // Format to MM/DD/YYYY
                const formattedDate = `${pickupDate.getMonth() + 1}/${pickupDate.getDate()}/${pickupDate.getFullYear()}`;
                return formattedDate;
            }

            return null;
        },

        getSumNumberDays() {
            if(this.selected_car != null) {
                let amount = this.getProvince.is_within
                    ? this.selected_car.model.type.rental_within
                    : this.selected_car.model.type.rental_without;

                let number_days = this.form.number_days;

                return amount * number_days;
            }
        },

        getSumTotal() {
            if (this.selected_car != null) {
                let number_of_days = this.form.number_days;
                let with_driver = this.form.with_driver ? 1000 * number_of_days : 0;
                let amount = this.getProvince.is_within
                    ? this.selected_car.model.type.rental_within
                    : this.selected_car.model.type.rental_without;

                return (amount * number_of_days) + with_driver;
            }
            return 0; // Default to 0 if no car is selected
        },

        isStep1Valid() {
            return this.form.route_city_id == '';
        },

        isStep2Valid() {
            return this.form.car_id != '' && this.form.number_passenger > 0 && this.form.number_days > 0;
        },
        isStep3Valid() {
            return this.form.pickup_date != '' && this.form.payment_id != '';
        },
        getProvince() {
            return this.provinces.find(route => route.id == this.form.route_id) || null;
        },
        getCity() {
            return this.cities.find(city => city.id == this.form.route_city_id) || null;
        },
        getCar() {
            return this.available_cars.find(car => car.id == this.form.car_id) || null;
        },
        getCarType() {
            return this.car_types.find(type => type.id == this.form.car_type_id) || null;
        },
        getCarColor() {
            return this.car_colors.find(type => type.id == this.form.car_type_id) || null;
        },
        getPayment() {
            return this.payments.find(payment => payment.id == this.form.payment_id) || null;
        }
    },
    methods: {
        nextStep() {
            if (this.step < 4) this.step++;
        },
        prevStep() {
            if (this.step > 1) this.step--;
        },
        finalize() {
            alert("Rental process completed! 🚀");
            this.step = 1; // Reset stepper
        },
        mountCities(event) {
            const selectedId = event.target.value;
            const selectedItem = this.provinces.find(item => item.id == selectedId);
            if (selectedItem) {
                this.cities = selectedItem.cities;
            }
        },

        async searchAvailableCars() {
            try {
                this.is_searching = true;
                this.form.car_id = ''
                let response = await axios.post('/rental/search_available_car', this.form); // Replace with your API route
                this.available_cars = response.data.available_cars;
            } catch (error) {
                console.error("Error fetching available cars:", error);
            }

            this.is_searching = false;
        },

        selectCar(item) {
            this.selected_car = item
            this.form.car_id = item.id;

        },

        async save() {
            try {
                this.is_loading_submission = true
                this.form.total_amount = this.getSumTotal
                let response = await axios.post('/rental/store', this.form);
                if(response) {
                    this.is_loading_submission = false
                    this.term_condition = false
                    this.is_success = true
                }

            } catch(error) {
                console.error("Error fetching available cars:", error);
                this.is_loading_submission = false
            }
        }
    }
};
</script>



<template>
    <Head title="Rent a Car" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Rent a Car
            </h2>
        </template>

        <div class="py-10 h-full">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 h-full">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg h-full flex flex-col">

                <!-- Static Step Header -->
                <div class="p-9 text-gray-900 border-b border-gray-200 dark:border-gray-700 flex-grow">
                <ol class="flex w-full justify-between">
                    <li v-for="(s, index) in steps" :key="index"
                        class="flex items-center space-x-2.5 p-6"
                        :class="step == s.id ? 'bg-blue-200 text-blue-900 dark:text-blue-900' : 'text-gray-500 dark:text-gray-400'">
                    <span class="flex items-center justify-center w-8 h-8 border rounded-full shrink-0"
                            :class="step == s.id ? 'border-blue-600 dark:border-blue-500' : 'border-gray-500 dark:border-gray-400'">
                        {{ s.id }}
                    </span>
                    <span>
                        <h3 class="font-medium leading-tight">{{ s.title }}</h3>
                        <p class="text-sm">{{ s.description }}</p>
                    </span>
                    </li>
                </ol>
                </div>

                <!-- Full-Width Step Content -->
                <div class="w-full flex-grow p-6">
                <div v-if="step == 1" class="w-full p-6 bg-gray-100 rounded-lg">
                    <p class="mb-4">🚗 Choose your destination from the available places.</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="relative z-0 w-full mb-5 group" v-if="user.is_admin == 1">
                            <label for="floating_email" class="peer-focus:font-medium absolute text-sm text-black-500 dark:text-black-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Select Renter</label>
                            <select v-model="form.renter_id" id="models" class="block py-2.5 px-0 w-full text-sm text-black bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-black dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="Select Province" required >
                                <option v-for="(item, index) in renters" :value="item.id" :key="index">{{ item.name }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="relative z-0 w-full mb-5 group">
                            <label for="floating_email" class="peer-focus:font-medium absolute text-sm text-black-500 dark:text-black-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Select Province</label>
                            <select @change="mountCities" v-model="form.route_id" id="models" class="block py-2.5 px-0 w-full text-sm text-black bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-black dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="Select Province" required >
                                <option v-for="(item, index) in provinces" :value="item.id" :key="index">{{ item.name }}</option>
                            </select>
                        </div>

                        <div class="relative z-0 w-full mb-5 group">
                            <label for="floating_email" class="peer-focus:font-medium absolute text-sm text-black-500 dark:text-black-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Select City</label>
                            <select v-model="form.route_city_id" id="models" class="block py-2.5 px-0 w-full text-sm text-black bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-black dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="Select Province" required >
                                <option v-for="(item, index) in cities" :value="item.id" :key="index">{{ item.name }}</option>
                            </select>
                        </div>

                        </div>
                        <div class="flex justify-end mt-4">
                            <button @click="nextStep" class="mt-2 px-4 py-2 rounded text-white" :class="isStep1Valid ? 'bg-gray-300' : 'bg-blue-500'" :disabled="isStep1Valid">Next</button>
                        </div>
                    </div>

                <div v-if="step == 2" class="w-full p-6 bg-gray-100 rounded-lg">
                    <p class="mb-6">🚘 Select the car that best suits your trip.</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="relative z-0 w-full mb-5 group">
                            <label class="peer-focus:font-medium absolute text-sm text-black-500 dark:text-black-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Select Your Car</label>

                            <div class="mt-4 relative z-0 w-full mb-5 group">
                                <input v-model="form.number_passenger" type="number" name="test" id="test" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-black dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                <label for="test" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-black-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Number of Passengers</label>
                            </div>

                            <div class="relative z-0 w-full mb-5 group">
                                <input v-model="form.number_days" type="number" name="test" id="test" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-black dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                <label for="test" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-black-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Number of Days</label>
                            </div>

                            <div class="relative z-0 w-full mb-5 group">
                                <select v-model="form.car_type_id" id="models" class="block py-2.5 px-0 w-full text-sm text-black bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-black dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="Car Type" required >
                                    <option v-for="(item, index) in car_types" :value="item.id" :key="index">{{ item.name }}</option>
                                </select>
                                <label for="floating_email" class="peer-focus:font-medium absolute text-sm text-black-500 dark:text-black-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Car Type</label>
                            </div>

                            <div class="relative z-0 w-full mb-5 group">
                                <input v-model="form.with_driver" id="default-checkbox" type="checkbox" :value="form.with_driver" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="default-checkbox" class="ms-2 text-sm font-medium text-gray-900 dark:text-black">With Driver</label>
                            </div>

                            <div class="relative z-0 w-full mb-5 group">
                                <select v-model="form.car_color_id" id="models" class="block py-2.5 px-0 w-full text-sm text-black bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-black dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="Car Color" required >
                                    <option v-for="(item, index) in car_colors" :value="item.id" :key="index">{{ item.name }}</option>
                                </select>
                                <label for="floating_email" class="peer-focus:font-medium absolute text-sm text-black-500 dark:text-black-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Car Color</label>
                            </div>

                            <button v-if="!is_searching" @click="searchAvailableCars" class="w-full px-4 py-2 bg-blue-500 text-white rounded">Search</button>

                            <button v-if="is_searching" disabled type="button" class="w-full text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5">
                                <svg aria-hidden="true" role="status" class="inline w-4 h-4 me-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                                </svg>
                                Searching ...

                            </button>
                        </div>

                        <div class="relative z-0 w-full mb-5 group">
                            <div class="w-full p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-8 dark:bg-white-800 dark:border-gray-700">
                                <div class="flex items-center justify-between mb-4">
                                    <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-black">Available Cars</h5>
                            </div>
                            <div class="flow-root">
                                    <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                                        <li class="py-3 sm:py-4"    :style="{
                                                backgroundColor: form.car_id == item.id ? '#37afde' : 'transparent',
                                                borderRadius: '8px'
                                            }"  v-for="(item, index) in available_cars" :key="index">
                                            <div class="flex items-center">
                                                <div class="flex-1 min-w-0 ms-4">
                                                    <p class="text-sm font-medium text-gray-900 truncate dark:text-black">
                                                        🚘 {{ item.model.brand.name }} - {{ item.model.name }} {{ item.year }}
                                                    </p>
                                                    <p class="text-sm text-black-300 truncate dark:text-black">
                                                        Plate #:{{ item.plate_number }}
                                                    </p>
                                                    <p class="text-sm text-black-300 truncate dark:text-black">
                                                        Owner:{{ item.owner.full_name }}
                                                    </p>
                                                </div>
                                                <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-black">
                                                    <button v-if="item.id != form.car_id" @click="selectCar(item)" type="button" class="text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Choose</button>
                                                    <button v-if="item.id == form.car_id" type="button" class="text-white bg-gradient-to-r from-gray-400 via-gray-500 to-gray-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-gray-300 dark:focus:ring-gray-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2" disabled>Selected</button>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                            </div>

                            </div>
                        </div>

                    </div>

                    <div class="flex justify-end mt-4">
                        <button @click="prevStep" class="mr-2 px-4 py-2 bg-gray-400 text-white rounded">Back</button>
                        <button @click="nextStep" class="mt-0 px-4 py-2 rounded text-white" :class="!isStep2Valid ? 'bg-gray-300' : 'bg-blue-500'" :disabled="!isStep2Valid">Next</button>
                    </div>
                </div>

                <div v-if="step == 3" class="w-full p-6 bg-gray-100 rounded-lg">
                    <p class="mb-4">💳 Enter your payment details to proceed.</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="relative z-0 w-full mb-5 group">

                            <div class="w-full p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6 dark:bg-white-800">
                                <h5 class="mb-3 text-base font-semibold text-gray-900 md:text-xl">
                                Billing Information
                                </h5>
                                <div class="relative overflow-x-auto">
                                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 ">
                                        <tbody>
                                            <tr class="bg-white border-b dark:bg-gray-800 border-gray-200">
                                                <th scope="row" colspan="2" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    {{ selected_car != null ? '🚘 '+ selected_car.model.brand.name+ ' - '+ selected_car.model.name + ' ' + selected_car.year : ''}}
                                                </th>
                                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    <span v-if="selected_car && getProvince">
                                                    ₱{{ getProvince.is_within ? selected_car.model.type.rental_within : selected_car.model.type.rental_without }}/day
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
                                                    {{ form.number_days }}
                                                </th>
                                                <th class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-right">
                                                    ₱ {{getSumNumberDays}}
                                                </th>
                                            </tr>
                                            <tr class="bg-white dark:bg-gray-800">
                                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    With Driver
                                                </th>
                                                <th class="px-6 py-4">

                                                </th>
                                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    {{ form.with_driver ? 'Yes (₱1000/day)' : 'No' }}
                                                </th>
                                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-right">
                                                    {{ form.with_driver ? '₱ '+form.number_days * 1000 : '' }}
                                                </th>
                                            </tr>
                                            <tr class="bg-white dark:bg-gray-800">
                                                <th scope="row" colspan="3" class="text-right px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    Sum Total
                                                </th>
                                                <th scope="row" colspan="3" class="text-right px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-right">
                                                    ₱ {{ getSumTotal }}
                                                </th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>

                            <div class="mt-2 w-full p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6 dark:bg-white-800">
                                <h5 class="mb-3 text-base font-semibold text-gray-900 md:text-xl dark:text-black">
                                Booking Dates
                                </h5>
                                <div class="relative overflow-x-auto">
                                    <div class="mt-4 relative z-0 w-full mb-5 group">
                                        <input v-model="form.pickup_date" type="date" name="test" id="test" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-black dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                        <label for="test" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-black-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Pickup Date</label>
                                    </div>
                                </div>

                                <div class="relative overflow-x-auto" v-if="computeReturnDate != null">
                                    <div class="mt-4 relative z-0 w-full mb-5 group">
                                        You will return the rented car on or before: <b>{{ computeReturnDate }}</b>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="relative z-0 w-full mb-5 group">
                            <p class="mb-2">Payment Methods</p>
                            <div class="p-3 md:p-5">
                                <ul class="space-y-2 mb-1">
                                    <li v-for="(item, index) in payments" :key="index">
                                        <input
                                            v-model="form.payment_id"
                                            type="radio"
                                            :id="item.id"
                                            name="job"
                                            :value="item.id"
                                            class="hidden peer"
                                            required
                                        />
                                        <label
                                            :for="item.id"
                                            class="inline-flex items-center justify-between w-full p-3 text-gray-900 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-500 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 dark:peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-900 hover:bg-gray-100 dark:text-white dark:bg-gray-600 dark:hover:bg-gray-500"
                                        >
                                            <div class="block">
                                                <div class="w-full text-lg font-semibold">{{ item.name }}</div>
                                                <div class="w-full text-gray-500 dark:text-gray-400">{{ item.account_number }}</div>
                                            </div>

                                            <svg class="w-4 h-4 ms-3 rtl:rotate-180 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                                            </svg>
                                        </label>
                                    </li>
                                </ul>

                            </div>

                        </div>

                    </div>


                    <div class="flex justify-end mt-4">
                        <button @click="prevStep" class="mr-2 px-4 py-2 bg-gray-400 text-white rounded">Back</button>
                        <button @click="nextStep" class="mt-0 px-4 py-2 rounded text-white" :class="!isStep3Valid ? 'bg-gray-300' : 'bg-blue-500'" :disabled="!isStep3Valid">Next</button>
                    </div>
                </div>

                <div v-if="step == 4" class="w-full p-6 bg-gray-100 rounded-lg">
                    <p class="mb-3">✅ Review and confirm your rental details.</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="relative z-0 w-full mb-5 group">
                            <div class="w-full p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-8 dark:bg-white-800 dark:border-gray-700">
                                <div class="flex items-center justify-between mb-4">
                                    <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-black">Details</h5>
                                </div>

                                <div class="relative overflow-x-auto">
                                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        <tbody>
                                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                                <th scope="row" class="px-6 py-4 ">
                                                    Destination
                                                </th>
                                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ getCity != null ? getCity.name+', ' : '' }} {{getProvince != null ? getProvince.name : ''}}
                                                </td>
                                            </tr>
                                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                                <th scope="row" class="px-6 py-4 ">
                                                    Car Details
                                                </th>
                                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    {{ selected_car != null ? '🚘 '+ selected_car.model.brand.name+ ' - '+ selected_car.model.name + ' ' + selected_car.year : ''}}<br>
                                                    {{ selected_car != null ? 'Plate #: '+selected_car.plate_number : '' }} <br>
                                                    {{ selected_car != null ? 'Owner: '+selected_car.owner.full_name : '' }}
                                                </td>
                                            </tr>
                                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                                <th scope="row" class="px-6 py-4 ">
                                                    With Driver
                                                </th>
                                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ form.with_driver ? 'Yes' : 'No' }}
                                                </td>
                                            </tr>
                                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                                <th scope="row" class="px-6 py-4 ">
                                                    Number of Passengers
                                                </th>
                                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ form.number_passenger }}
                                                </td>
                                            </tr>
                                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                                <th scope="row" class="px-6 py-4 ">
                                                    Rent Days
                                                </th>
                                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ form.number_days }}
                                                </td>
                                            </tr>
                                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                                <th scope="row" class="px-6 py-4 ">
                                                    Pickup Date
                                                </th>
                                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ form.pickup_date }}
                                                </td>
                                            </tr>
                                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                                <th scope="row" class="px-6 py-4 ">
                                                    Return Date
                                                </th>
                                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    {{  computeReturnDate }}
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>

                        <div class="relative z-0 w-full mb-5 group">
                            <div class="w-full p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-8 dark:bg-white-800 dark:border-gray-700">
                                <div class="flex items-center justify-between mb-4">
                                    <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-black">Payment</h5>
                                </div>

                                <div class="relative overflow-x-auto">
                                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        <tbody>
                                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                                <th scope="row" class="px-6 py-4 ">
                                                    Mode of Payment
                                                </th>
                                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    {{ getPayment != null ? getPayment.name : ''}}
                                                </td>
                                            </tr>
                                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                                <th scope="row" class="px-6 py-4 ">
                                                    Total Payment
                                                </th>
                                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    ₱ {{ getSumTotal }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end mt-4">
                        <button @click="prevStep" class="mr-2 px-4 py-2 bg-gray-400 text-white rounded">Back</button>
                        <button @click="term_condition = true" class="px-4 py-2 bg-gray-500 text-white rounded">Finish</button>
                    </div>
                </div>
                </div>

            </div>
            </div>
        </div>

        <!-- Terms and conditions -->
        <div v-if="term_condition" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-50">
            <div class="relative w-full max-w-4xl max-h-[90vh] bg-white rounded-lg shadow-lg dark:bg-gray-700 flex flex-col">
                <!-- Modal Header -->
                <div class="p-4 border-b dark:border-gray-600 flex items-center justify-between sticky top-0 bg-white z-10">
                    <h3 class="text-lg font-semibold text-gray-900">Terms and Conditions</h3>
                    <button @click="term_condition = false" type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>

                <!-- Scrollable Terms Section -->
                <div class="overflow-y-auto max-h-[70vh] p-6 space-y-6 bg-white">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center"><i class="fa-solid fa-credit-card text-blue-600 mr-2"></i> 1. Payment Process</h2>
                        <p class="text-gray-600 mt-1"><span class="font-semibold">1.1.</span> Payments for car rental services can be made via GCash QR code through our secure online payment system.</p>
                        <p class="text-gray-600 mt-1"><span class="font-semibold">1.2.</span> By using GCash, you confirm that you are the authorized user of the GCash account and have sufficient funds to complete the transaction.</p>
                    </div>

                    <div>
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center"><i class="fa-solid fa-tag text-green-600 mr-2"></i> 2. Pricing and Fees</h2>
                        <p class="text-gray-600 mt-1"><span class="font-semibold">2.1.</span> Rental prices are subject to change based on availability and other factors, and all applicable fees will be disclosed during the booking process.</p>
                        <p class="text-gray-600 mt-1"><span class="font-semibold">2.2.</span> Prices are quoted in Philippine Peso and may include taxes and additional charges.</p>
                    </div>

                    <div>
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center"><i class="fa-solid fa-receipt text-purple-600 mr-2"></i> 3. Confirmation of Payment</h2>
                        <p class="text-gray-600 mt-1"><span class="font-semibold">3.1.</span> Upon successful payment via GCash QR code, you need to upload the screenshot and transaction number below, and it will serve as your receipt.</p>
                    </div>

                    <div>
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center"><i class="fa-solid fa-ban text-red-600 mr-2"></i> 4. Cancellation and Refund Policy</h2>
                        <p class="text-gray-600 mt-1"><span class="font-semibold">4.1.</span> Cancellations must adhere to our cancellation policy, available on our website.</p>
                        <p class="text-gray-600 mt-1"><span class="font-semibold">4.2.</span> Refunds will be processed according to the terms outlined in our cancellation policy.</p>
                    </div>

                    <div>
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center"><i class="fa-solid fa-shield-halved text-yellow-600 mr-2"></i> 5. Security and Privacy</h2>
                        <p class="text-gray-600 mt-1"><span class="font-semibold">5.1.</span> We prioritize the security of your payment information, utilizing industry-standard encryption for transactions.</p>
                        <p class="text-gray-600 mt-1"><span class="font-semibold">5.2.</span> Your personal information will be managed in accordance with our Privacy Policy.</p>
                    </div>

                    <div>
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center"><i class="fa-solid fa-gavel text-gray-600 mr-2"></i> 6. Limitation of Liability</h2>
                        <p class="text-gray-600 mt-1"><span class="font-semibold">6.1.</span> The Company is not liable for any indirect or consequential damages arising from the use of the GCash QR code payment.</p>
                    </div>

                    <div>
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center"><i class="fa-solid fa-file-contract text-indigo-600 mr-2"></i> 7. Changes to Terms</h2>
                        <p class="text-gray-600 mt-1"><span class="font-semibold">7.1.</span> We reserve the right to modify these Terms at any time, effective immediately upon posting on our website.</p>
                    </div>

                    <div>
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center"><i class="fa-solid fa-envelope text-blue-600 mr-2"></i> 8. Contact Information</h2>
                        <p class="text-gray-600 mt-1">For questions regarding these Terms, please contact us at:</p>
                        <p class="mt-2 font-medium">S-TRIP A Smart UV Express Car Rental And Booking System Of Tuguegarao City</p>
                        <p class="text-gray-600">Tuguegarao City, Cagayan Valley</p>
                        <p class="text-gray-600">📧 <a href="mailto:jayronpaolobacarro2@gmail.com" class="text-blue-500 hover:underline">jayronpaolobacarro2@gmail.com</a></p>
                    </div>
                </div>

                <!-- Acknowledgment Button (Fixed at Bottom) -->
                <div class="p-4 border-t dark:border-gray-600 bg-white sticky bottom-0 z-10">
                    <button v-if="!is_loading_submission" @click="save" class="w-full text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5">
                        I Agree to the Terms & Conditions, Submit
                    </button>
                </div>
                <button v-if="is_loading_submission" disabled type="button" class="w-full text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5">
                <svg aria-hidden="true" role="status" class="inline w-4 h-4 me-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                </svg>
                Submitting ...

            </button>
            </div>
        </div>

        <!-- Small Rent Success Modal -->
        <div v-if="is_success" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-50">
            <div class="relative w-full max-w-md max-h-[60vh] bg-white rounded-lg shadow-lg dark:bg-gray-700 flex flex-col">
                <!-- Modal Header -->
                <div class="p-4 border-b dark:border-gray-600 flex items-center justify-between sticky top-0 bg-white z-10">
                    <h3 class="text-lg font-semibold text-gray-900 ">Success</h3>
                </div>

                <!-- Scrollable Content Section -->
                <div class="overflow-y-auto max-h-[40vh] px-4 py-3 space-y-3 bg-white">
                    <p class="text-gray-600 ">
                        Your car rental booking has been successfully processed.
                    </p>
                    <p class="text-gray-600 ">
                        If you have any questions, feel free to contact our support team.
                    </p>
                </div>

                <!-- Close Button (Fixed at Bottom) -->
                <div class="p-4 border-t dark:border-gray-600 bg-white sticky bottom-0 z-10">
                    <Link :href="route('rental.index')">
                        <button @click="is_success = false" class="w-full text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-4 py-2.5">
                            Close
                        </button>
                    </Link>
                </div>
            </div>
        </div>




    </AuthenticatedLayout>
</template>
