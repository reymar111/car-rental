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
    props: ['users'],
    data() {
        return {
            form: useForm({
                id: null,
                name: '',
                email: '',
                administrator: false,
                contact_number: '',
                address: '',
                password: '',
            }),

            search: '',

            is_edit: false,
            toast: false,

            is_created: false,
            is_updated: false,

            modal: false,
            loading_button: false,
            disabled_button: false,
        }
    },

    computed: {
        filter() {
            if (!this.search) return this.users;

            return this.users.filter(user => {
                return Object.values(user).some(value =>
                    String(value).toLowerCase().includes(this.search.toLowerCase())
                );
            });
        }
    },

    methods: {
        save() {
            this.form.post('/account/store', {
                onStart: () => {
                    this.loading_button = true;
                },
                onFinish: () => {
                    this.loading_button = false;
                    this.toast = true
                    this.is_updated = true
                },
                onSuccess: () => {
                    this.modal = false;
                    this.form.reset();
                },
            });
        },

        edit(user) {
            this.is_edit = true
            this.form.id = user.id
            this.form.name = user.name
            this.form.email = user.email
            this.form.is_admin = user.is_admin
            this.form.contact_number = user.contact_number
            this.form.address = user.address
            this.form.administrator = user.is_admin == 1 ? true : false
            this.modal = true
        },

        update() {
            this.form.patch(`/account/update/${this.form.id}`, {
                onStart: () => {
                    this.loading_button = true;
                },
                onFinish: () => {
                    this.loading_button = false;
                    this.is_updated = true;
                },
                onSuccess: () => {
                    this.modal = false;
                    this.is_updated = true;
                    this.form.reset();
                },
            });
        },

        closeModal() {
            this.form.id =null
            this.form.name = ''
            this.form.email = ''
            this.form.is_admin = ''
            this.form.contact_number = ''
            this.form.address = ''
            this.form.password = ''

            this.search = ''

            this.is_edit = false
            this.toast = false
            this.is_created = false
            this.is_updated = false

            this.modal = false
            this.loading_button = false
            this.disabled_button = false
        },
    },

    mounted() {

    }
}
</script>

<template>
    <Head title="Users" />

    <Settings>
        <div class="pb-4 bg-white dark:bg-gray-900">
            <div class="flex items-center gap-2">
                <!-- Buttons -->
                <button @click="modal = true" class="px-4 py-2 text-white bg-blue-700 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    Create New
                </button>
                <!-- Input field pushed to the right -->
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </div>
                    <input v-model="search" type="text" id="table-search" class="block pt-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search for cities">
                </div>
            </div>
        </div>

        <div v-if="is_created" id="alert-border-2" class="flex items-center p-4 mb-4 text-green-800 border-t-4 border-green-300 bg-green-50 dark:text-green-400 dark:bg-gray-800 dark:border-green-800" role="alert">
            <svg class="shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <div class="ms-3 text-sm font-medium">
            User created successfully
            </div>
            <button @click="is_created = false" type="button" class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700"  data-dismiss-target="#alert-border-2" aria-label="Close">
            <span class="sr-only">Dismiss</span>
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
            </button>
        </div>

        <div v-if="is_updated" id="alert-border-2" class="flex items-center p-4 mb-4 text-green-800 border-t-4 border-green-300 bg-green-50 dark:text-green-400 dark:bg-gray-800 dark:border-green-800" role="alert">
            <svg class="shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <div class="ms-3 text-sm font-medium">
            Changes Saved
            </div>
            <button @click="is_updated = false" type="button" class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700"  data-dismiss-target="#alert-border-2" aria-label="Close">
            <span class="sr-only">Dismiss</span>
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
            </button>
        </div>

        <table class="w-full max-w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        #
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Name
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Administrator
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600"
                    v-for="(item, index) in filter" :key="index">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ index + 1 }}
                    </th>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ item.name }}
                    </th>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ item.is_admin == 1 ? 'Yes' : 'No' }}
                    </th>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <button @click="edit(item)" type="button" class="mr-2 px-3 py-2 text-xs font-medium text-center inline-flex items-center text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                            <svg class="w-4 h-4 text-white-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                            </svg>
                            Edit
                        </button>
                    </td>
                </tr>

            </tbody>
        </table>

        <!-- Main modal -->
        <div v-if="modal" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-50">
            <div class="relative p-4 w-full max-w-md">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow-lg dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 border-b dark:border-gray-600">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            {{ is_edit ? 'Update ' + form.name : 'Create'}} user
                        </h3>
                        <button @click="closeModal" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="crud-modal">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                    </div>
                    <!-- Modal body -->
                    <form class="p-4">
                        <div class="grid gap-2 mb-2">
                            <label class="block text-sm font-medium text-gray-900 dark:text-white">Name</label>
                            <input v-model="form.name" type="text" class="w-full p-2 border rounded-lg dark:bg-gray-600 dark:border-gray-500 dark:text-white" placeholder="Name" required>
                            <InputError class="mt-2" :message="form.errors.name" />
                        </div>

                        <div class="grid gap-2 mb-2">
                            <label class="block text-sm font-medium text-gray-900 dark:text-white">Email</label>
                            <input v-model="form.email" type="email" class="w-full p-2 border rounded-lg dark:bg-gray-600 dark:border-gray-500 dark:text-white" placeholder="Email" required>
                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>

                        <div class="grid gap-2 mb-2">
                            <label class="block text-sm font-medium text-gray-900 dark:text-white">Contact Number</label>
                            <input v-model="form.contact_number" type="number" class="w-full p-2 border rounded-lg dark:bg-gray-600 dark:border-gray-500 dark:text-white" placeholder="Contact Number" required>
                            <InputError class="mt-2" :message="form.errors.contact_number" />
                        </div>

                        <div class="grid gap-2 mb-2">
                            <label class="block text-sm font-medium text-gray-900 dark:text-white">Address</label>
                            <input v-model="form.address" type="text" class="w-full p-2 border rounded-lg dark:bg-gray-600 dark:border-gray-500 dark:text-white" placeholder="Address" required>
                            <InputError class="mt-2" :message="form.errors.address" />
                        </div>

                        <div class="grid gap-2 mb-2">
                            <label class="block text-sm font-medium text-gray-900 dark:text-white">Password</label>
                            <input v-model="form.password" type="password" class="w-full p-2 border rounded-lg dark:bg-gray-600 dark:border-gray-500 dark:text-white" placeholder="Password" required>
                            <InputError class="mt-2" :message="form.errors.password" />
                        </div>

                        <div class="flex  items-center gap-2 mb-5 mt-5">
                            <input v-model="form.administrator" id="default-checkbox" type="checkbox" :value="form.administrator" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="default-checkbox" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Administrator</label>
                        </div>

                        <br />

                        <button @click="save" v-if="!loading_button && !is_edit" class="w-full text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5">
                            SAVE
                        </button>

                        <button @click="update" v-if="!loading_button && is_edit" class="w-full text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5">
                            UPDATE
                        </button>

                        <button v-if="loading_button" disabled type="button" class="w-full text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5">
                            <svg aria-hidden="true" role="status" class="inline w-4 h-4 me-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                            </svg>
                            {{ is_edit ? 'Updating' : 'Saving...'}}

                        </button>
                    </form>
                </div>
            </div>
        </div>

    </Settings>
</template>
