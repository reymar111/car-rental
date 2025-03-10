<script >
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';


export default {
    props: ['rent'],
    components: {
        AuthenticatedLayout,
        Head,
        Link,
        InputError
    },
    data() {
        return {
            form: useForm({
                reference_number: '',
                notes: '',
                proof_payment: null,

            }),

            uploadedFileUrl: null,  // Stores the uploaded file URL
            uploadedFileName: "",   // Stores the file name
            is_submitting: false,
            is_success: false,



        };
    },
    computed: {
        isValidPayment() {
            return this.form.reference_number.trim() !== "" && this.form.proof_payment !== null;
        }
    },
    methods: {
        goBack() {
            window.history.back();
        },

        handleFileUpload(event) {
            const file = event.target.files[0];

            if (file) {
                const allowedTypes = ["image/png", "image/jpeg", "application/pdf"];
                const maxSize = 2 * 1024 * 1024; // 2MB in bytes

                if (!allowedTypes.includes(file.type)) {
                    alert("Invalid file type. Please upload a PNG, JPG, or PDF.");
                    return;
                }

                if (file.size > maxSize) {
                    alert("File is too large. Maximum allowed size is 2MB.");
                    return;
                }

                // Create a URL for the uploaded file
                this.form.proof_payment = file; // Store the actual File object
                this.uploadedFileUrl = URL.createObjectURL(file); // Show preview
                this.uploadedFileName = file.name; // Store file name
            }
        },
        deleteFile() {
            // Clear the uploaded file data
            this.uploadedFileUrl = null;
            this.uploadedFileName = "";
            document.getElementById("dropzone-file").value = ""; // Reset the input field
        },

        async save() {
            if (this.isFormValid) return;

            try {
                this.is_submitting = true
                let formData = new FormData();
                formData.append('car_rental_id', this.rent.id);
                formData.append('reference_number', this.form.reference_number);
                formData.append('proof_payment', this.form.proof_payment);

                const response = await axios.post('/payment/store', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });

                // Update uploaded file info
                this.uploadedFileUrl = response.data.file_url;
                this.uploadedFileName = response.data.file_name;

                this.is_success = true
                this.is_submitting = false

            } catch (error) {
                console.error('Upload error:', error);
                alert('Payment submission failed. Please try again.');
            }
        }

    }
};
</script>

<template>
    <Head title="Pay" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 flex justify-between items-center">
                Pay 🛒 {{ rent.transaction_number }}

                <div class="flex gap-2">
                    <button @click="save" v-if="!is_submitting"
                        class="w-full sm:w-auto px-4 py-2.5 inline-flex items-center justify-center text-white rounded-lg
                            bg-blue-800 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300
                            transition-opacity duration-300"
                        :class="{'opacity-50 cursor-not-allowed pointer-events-none bg-gray-500 text-gray-300': !isValidPayment}"
                        :disabled="!isValidPayment"
                    >
                        <svg class="w-6 h-6 text-white-800 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M6 14h2m3 0h5M3 7v10a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1Z"/>
                        </svg>

                        <div class="text-sm font-semibold">Submit Payment</div>
                    </button>

                    <button @click="goBack" v-if="!is_submitting"
                        class="w-full sm:w-auto bg-green-800 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 text-white rounded-lg inline-flex items-center justify-center px-4 py-2.5 dark:bg-green-700 dark:hover:bg-green-600 dark:focus:ring-green-700">
                        <svg class="w-6 h-6 text-white-800 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 19-7-7 7-7"/>
                        </svg>
                        <div class="text-sm font-semibold">Back</div>
                    </button>

                    <button v-if="is_submitting" disabled type="button" class="w-full text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5">
                            <svg aria-hidden="true" role="status" class="inline w-4 h-4 me-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                            </svg>
                            Submitting ...

                        </button>
                </div>
            </h2>

        </template>

        <div class="py-10 h-full">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 h-full">
                <div class="overflow-hidden bg-gray shadow-sm sm:rounded-lg h-full flex flex-col md:flex-row">
                    <div class="w-full md:w-1/2 bg-white p-6">
                        <div class="grid gap-2 mb-2">
                            <label class="block text-sm font-medium text-gray-900 ">Reference Number</label>
                            <input v-model="form.reference_number" type="text" class="w-full p-2 border rounded-lg dark:bg-gray-600 dark:border-gray-500 " placeholder="" required>
                            <InputError class="mt-2" :message="form.reference_number.name" />
                        </div>

                        <div class="grid gap-2 mb-2">
                            <label class="block text-sm font-medium text-gray-900 ">Notes</label>
                            <textarea v-model="form.notes" rows="3" class="w-full p-2 border rounded-lg dark:bg-gray-600 dark:border-gray-500 " placeholder="" required></textarea>
                            <InputError class="mt-2" :message="form.notes.name" />
                        </div>



                    </div>
                    <div class="w-full md:w-1/2 bg-white p-6">
                        <div class="flex flex-col items-center justify-center w-full">
                            <div class="grid gap-2 mb-2">
                                <label class="block text-sm font-medium text-gray-900 ">Proof of Payment</label>
                            </div>

                            <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span></p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG or PDF (MAX. 2MB)</p>
                                </div>
                                <input
                                    id="dropzone-file"
                                    type="file"
                                    class="hidden"
                                    accept="image/png, image/jpeg, application/pdf"
                                    @change="handleFileUpload"
                                />
                            </label>

                            <!-- Display uploaded file link with delete button -->
                            <div v-if="uploadedFileUrl" class="mt-4 flex items-center space-x-2">
                                <a :href="uploadedFileUrl" target="_blank" class="text-blue-600 hover:underline">
                                    {{ uploadedFileName }}
                                </a>
                                <button
                                    @click="deleteFile"
                                    class="px-2 py-1 text-sm font-semibold text-white bg-red-600 rounded-lg hover:bg-red-700">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="is_success" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-50">
            <div class="relative w-full max-w-md max-h-[60vh] bg-white rounded-lg shadow-lg dark:bg-gray-700 flex flex-col">
                <!-- Modal Header -->
                <div class="p-4 border-b dark:border-gray-600 flex items-center justify-between sticky top-0 bg-white z-10">
                    <h3 class="text-lg font-semibold text-gray-900 ">Success</h3>
                </div>

                <!-- Scrollable Content Section -->
                <div class="overflow-y-auto max-h-[40vh] px-4 py-3 space-y-3 bg-white">
                    <p class="text-gray-600">
                        Your payment is successfully submitted
                    </p>
                    <p class="text-gray-600">
                        If you have any questions, feel free to contact our support team.
                    </p>
                </div>

                <!-- Close Button (Fixed at Bottom) -->
                <div class="p-4 border-t dark:border-gray-600 bg-white sticky bottom-0 z-10">
                    <Link :href="route('rental.show', {rental: rent.id})">
                        <button @click="is_success = false" class="w-full text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-4 py-2.5">
                            Close
                        </button>
                    </Link>
                </div>
            </div>
        </div>





    </AuthenticatedLayout>
</template>
