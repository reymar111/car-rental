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
                let response = await axios.post('/reports/car-owner-earning-report', this.form); // Replace with your API route
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
    <Head title="Car Owner Earning Report" />

    <Reports>
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-2 py-3">
                        Owner
                    </th>
                    <th scope="col" class="px-2 py-3">
                        Total Car Listed
                    </th>
                    <th scope="col" class="px-2 py-3">
                        Total Rentals
                    </th>
                    <th scope="col" class="px-2 py-3">
                        Total Earnings
                    </th>
                    <th scope="col" class="px-2 py-3">
                        Average Earnings per Rental
                    </th>
                    <th scope="col" class="px-2 py-3">
                        Average Earnings per Day
                    </th>

                </tr>
            </thead>
            <tbody>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600"
                    v-for="(item, index) in data" :key="index">
                    <td scope="row" class="px-2 font-medium text-gray-900 whitespace-nowrap">
                        {{ item.owner_name }}
                    </td>
                    <td scope="row" class="px-2 font-medium text-gray-900 whitespace-nowrap">
                        {{ item.total_cars_listed }}
                    </td>
                    <td scope="row" class="px-2 font-medium text-gray-900 whitespace-nowrap">
                        {{ item.total_rentals }}
                    </td>
                    <td scope="row" class="px-2 font-medium text-gray-900 whitespace-nowrap">
                        ₱ {{ item.total_earnings }}
                    </td>
                    <td scope="row" class="px-2 font-medium text-gray-900 whitespace-nowrap">
                        ₱ {{ item.average_earnings_per_rental }}
                    </td>
                    <td scope="row" class="px-2 font-medium text-gray-900 whitespace-nowrap">
                        ₱ {{ item.average_earnings_per_day }}
                    </td>
                </tr>

            </tbody>
        </table>

    </Reports>
</template>
