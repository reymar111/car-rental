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
                let response = await axios.post('/reports/customer-feedback', this.form); // Replace with your API route
                this.data = response.data.result;

            } catch (error) {
                console.error("Error fetching available cars:", error);
            }
        },
    },

    mounted() {
        this.filter()
    }
}
</script>

<template>
    <Head title="Customer Feedback Report" />

    <Reports>
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-2 py-3">
                        Transaction #
                    </th>
                    <th scope="col" class="px-2 py-3">
                        Car
                    </th>
                    <th scope="col" class="px-2 py-3">
                        Renter
                    </th>
                    <th scope="col" class="px-2 py-3">
                        Rating
                    </th>
                    <th scope="col" class="px-2 py-3">
                        Feedback
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
                        {{item.car_brand_name}} {{ item.car_model_name }}
                    </td>
                    <td scope="row" class="px-2 font-medium text-gray-900 whitespace-nowrap">
                        {{ item.customer_name }}
                    </td>
                    <td scope="row" class="px-2 font-medium text-gray-900 whitespace-nowrap">
                        <span class="flex justify-left mb-3">
                            <span v-for="star in 5" :key="star">
                                <svg class="w-5 h-5"
                                    :class="star <= item.rating ? 'text-yellow-400' : 'text-gray-300'"
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
                    <td scope="row" class="px-2 font-medium text-gray-900 whitespace-nowrap">
                        {{ item.feedback }}
                    </td>
                </tr>

            </tbody>
        </table>

    </Reports>
</template>
