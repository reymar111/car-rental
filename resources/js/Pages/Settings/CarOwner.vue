<script>
    import Settings from '@/Pages/Settings.vue';
    import { Head } from '@inertiajs/vue3';
    import InputError from '@/Components/InputError.vue';
    import { useForm } from '@inertiajs/vue3'

export default {
    components: {
        Settings,
        Head,
        InputError
    },
    props: ['owners'],
    // Properties returned from data() become reactive state
    // and will be exposed on `this`.
    data() {
        return {
            form: useForm({
                id: null,
                first_name: '',
                middle_name: '',
                last_name: '',
                ext_name: '',
                contact: '',
                address: '',
            }), 
            
            is_edit: false,
            modal: false,
            loading_button: false,
            disabled_button: false,
        }
    },

    // Methods are functions that mutate state and trigger updates.
    // They can be bound as event handlers in templates.
    methods: {
        save() {
            this.form.post('/owner/store', {
                onStart: () => {
                    this.loading_button = true;
                },
                onFinish: () => {
                    this.loading_button = false;
                },
                onSuccess: () => {
                    this.modal = false;
                    this.form.reset();
                },
            });
        }
    },

    // Lifecycle hooks are called at different stages
    // of a component's lifecycle.
    // This function will be called when the component is mounted.
    mounted() {
        
    }
}
</script>

<template>
    <Head title="Owner" />

    <Settings>
        <div class="pb-4 bg-white dark:bg-gray-900">
            <div class="flex items-center gap-2">
                <!-- Buttons -->
                <button @click="modal = true" class="px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    Create New
                </button>
                <!-- Input field pushed to the right -->
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </div>
                    <input type="text" id="table-search" class="block pt-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search for items">
                </div>
            </div>
        </div>

        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Owner
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Address
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Contact #
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        Apple MacBook Pro 17"
                    </th>
                    <td class="px-6 py-4">
                        Silver
                    </td>
                    <td class="px-6 py-4">
                        Laptop
                    </td>
                    <td class="px-6 py-4">
                        <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                    </td>
                </tr>
             
            </tbody>
        </table>

        <!-- Main modal -->
<!-- Main modal -->
<div v-if="modal" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-50">
    <div class="relative p-4 w-full max-w-md">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow-lg dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 border-b dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Create Car Owner
                </h3>
                <button @click="modal = false" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="crud-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
            </div>
            <!-- Modal body -->
            <form class="p-4">
                <div class="grid gap-4 mb-4">
                    <label class="block text-sm font-medium text-gray-900 dark:text-white">First Name</label>
                    <input v-model="form.first_name" type="text" class="w-full p-2 border rounded-lg dark:bg-gray-600 dark:border-gray-500 dark:text-white" placeholder="Type first name" required>
                    <InputError class="mt-2" :message="form.errors.first_name" />

                    <label class="block text-sm font-medium text-gray-900 dark:text-white">Middle Name</label>
                    <input v-model="form.middle_name" type="text" class="w-full p-2 border rounded-lg dark:bg-gray-600 dark:border-gray-500 dark:text-white" placeholder="Type midle name" required>

                    <label class="block text-sm font-medium text-gray-900 dark:text-white">Last Name</label>
                    <input v-model="form.last_name" type="text" class="w-full p-2 border rounded-lg dark:bg-gray-600 dark:border-gray-500 dark:text-white" placeholder="Type last name" required>
                    
                    <label class="block text-sm font-medium text-gray-900 dark:text-white">Ext Name</label>
                    <input v-model="form.ext_name" type="text" class="w-full p-2 border rounded-lg dark:bg-gray-600 dark:border-gray-500 dark:text-white" placeholder="Type ext name" required>
                    
                    <label class="block text-sm font-medium text-gray-900 dark:text-white">Contact #</label>
                    <input v-model="form.contact_number" type="number" class="w-full p-2 border rounded-lg dark:bg-gray-600 dark:border-gray-500 dark:text-white" placeholder="0912345678" required>

                    <label class="block text-sm font-medium text-gray-900 dark:text-white">Address</label>
                    <textarea v-model="form.address" rows="4" class="w-full p-2 border rounded-lg dark:bg-gray-600 dark:border-gray-500 dark:text-white" placeholder="Addres"></textarea>                    
                </div>
                <button @click="save" v-if="!loading_button" type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5">
                    SAVE
                </button>

                <button v-if="loading_button" disabled type="button" class="w-full text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5">
                    <svg aria-hidden="true" role="status" class="inline w-4 h-4 me-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                    </svg>
                    Saving...
                </button>
            </form>
        </div>
    </div>
</div>


    </Settings>
</template>
