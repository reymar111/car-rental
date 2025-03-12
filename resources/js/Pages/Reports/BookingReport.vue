<script>
    import Reports from '@/Pages/Reports.vue';
    import { Head } from '@inertiajs/vue3';
    import InputError from '@/Components/InputError.vue';
    import { useForm } from '@inertiajs/vue3'

export default {
    components: {
        Reports,
        Head,
        InputError
    },
    data() {
        return {
            form: useForm({
                from: '',
                to: '',
            }),

            search: '',

            data: [],
        }
    },

    methods: {
        async filter() {
            try {
                let response = await axios.post('/reports/booking-report', this.form); // Replace with your API route
                this.data = response.data.result;

            } catch (error) {
                console.error("Error fetching available cars:", error);
            }
        },
    },

    mounted() {

    }
}
</script>

<template>
    <Head title="Booking Report" />

    <Reports>
        <div class="p-4 bg-white dark:bg-gray-900">
            <div class="flex items-center gap-2">

                <div class="relative flex-1">
                    <div class="relative overflow-x-auto">
                        <div class="flex items-center gap-x-4 mt-4">
                            <!-- From Input -->
                            <div class="relative z-0 w-1/3 group">
                                <input v-model="form.from" type="date" name="from" id="from"
                                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-black dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    placeholder=" " required />
                                <label for="from"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-black-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                    From
                                </label>
                            </div>

                            <!-- To Input -->
                            <div class="relative z-0 w-1/3 group">
                                <input v-model="form.to" type="date" name="to" id="to"
                                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-black dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    placeholder=" " required />
                                <label for="to"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-black-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                    To
                                </label>
                            </div>

                            <!-- Button -->
                            <button @click="filter"
                                class="px-4 py-2 text-white bg-blue-700 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
                                Generate
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>



        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-2 py-3">
                        Transaction #
                    </th>
                    <th scope="col" class="px-2 py-3">
                        Renter
                    </th>
                    <th scope="col" class="px-2 py-3">
                        Car
                    </th>
                    <th scope="col" class="px-2 py-3">
                        Pickup Date
                    </th>
                    <th scope="col" class="px-2 py-3">
                        Route
                    </th>
                    <th scope="col" class="px-2 py-3">
                        With Driver
                    </th>
                    <th scope="col" class="px-2 py-3">
                        Payment Mode
                    </th>
                    <th scope="col" class="px-2 py-3">
                        Rent Status
                    </th>

                </tr>
            </thead>
            <tbody>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600"
                    v-for="(item, index) in data" :key="index">
                    <td scope="row" class="px-2 font-medium text-gray-900 whitespace-nowrap">
                        {{ item.transaction_number }}
                    </td>
                    <td scope="row" class="px-2 font-medium text-gray-900 whitespace-nowrap">
                        {{ item.renter != null ? item.renter.name : '' }}
                    </td>
                    <td scope="row" class="px-2 font-medium text-gray-900 whitespace-nowrap">
                        {{ item != null ? item.car.model.brand.name+ ' - '+ item.car.model.name + ' ' + item.car.year : ''}}
                    </td>
                    <td scope="row" class="px-2 font-medium text-gray-900 whitespace-nowrap">
                        {{ item.pickup_date }}
                    </td>
                    <td scope="row" class="px-2 font-medium text-gray-900 whitespace-nowrap">
                        {{ item.city != null ? item.city.name+', ' : '' }} {{ item.province != null ? item.province.name : '' }}
                    </td>
                    <td scope="row" class="px-2 font-medium text-gray-900 whitespace-nowrap">
                        {{ item.with_driver ? 'Yes' : 'No' }}
                    </td>
                    <td scope="row" class="px-2 font-medium text-gray-900 whitespace-nowrap">
                        {{ item.payment != null ? item.payment.name : '' }}
                    </td>
                    <td scope="row" class="px-2 font-medium text-gray-900 whitespace-nowrap">
                        {{ item.status }}
                    </td>

                </tr>

            </tbody>
        </table>

    </Reports>
</template>
