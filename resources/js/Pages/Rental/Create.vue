<script >
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3'

export default {
    components: {
        AuthenticatedLayout,
        Head,
    },

    props: ['provinces'],

    data() {
        return {
            step: 1, // Current step
            steps: [
                { id: 1, title: "Destination", description: "Select your destination" },
                { id: 2, title: "Select A Car", description: "Choose your desired car" },
                { id: 3, title: "Payment Info", description: "Setup your payment" },
                { id: 4, title: "Finalize", description: "Finalize your rent" },
            ],
            form: useForm({
                route_id: '',
                route_city_id: '',
                car_id: '',
            }),

            cities: [],
        };
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
                class="flex items-center space-x-2.5 "
                :class="step === s.id ? 'text-blue-900 dark:text-blue-500 ' : 'text-gray-500 dark:text-gray-400'">
              <span class="flex items-center justify-center w-8 h-8 border rounded-full shrink-0"
                    :class="step === s.id ? 'border-blue-600 dark:border-blue-500' : 'border-gray-500 dark:border-gray-400'">
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
          <div v-if="step === 1" class="w-full p-6 bg-gray-100 rounded-lg">
            <p class="mb-4">🚗 Choose your destination from the available places.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="relative z-0 w-full mb-5 group">
                <label for="floating_email" class="peer-focus:font-medium absolute text-sm text-black-500 dark:text-black-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Select Province</label>
                <select @change="mountCities" v-model="form.route_id" id="models" class="block py-2.5 px-0 w-full text-sm text-black bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-black dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="Select Province" required >
                    <option v-for="(item, index) in provinces" :value="item.id" :key="index">{{ item.name }}</option>
                </select>
            </div>

            <div class="relative z-0 w-full mb-5 group">
                <label for="floating_email" class="peer-focus:font-medium absolute text-sm text-black-500 dark:text-black-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Select Province</label>
                <select v-model="form.route_city_id" id="models" class="block py-2.5 px-0 w-full text-sm text-black bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-black dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="Select Province" required >
                    <option v-for="(item, index) in cities" :value="item.id" :key="index">{{ item.name }}</option>
                </select>
            </div>

            </div>

            <button @click="nextStep" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded" :disabled="form.route_city_id == ''">Next</button>
          </div>

          <div v-if="step === 2" class="w-full p-6 bg-gray-100 rounded-lg">
            <p class="mb-4">🚘 Select the car that best suits your trip.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="relative z-0 w-full mb-5 group">
                <label for="floating_email" class="peer-focus:font-medium absolute text-sm text-black-500 dark:text-black-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Select Your Car</label>
            </div>

            <div class="relative z-0 w-full mb-5 group">
                <label for="floating_email" class="peer-focus:font-medium absolute text-sm text-black-500 dark:text-black-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Available Cars</label>
            </div>

            </div>

            <button @click="prevStep" class="mr-2 px-4 py-2 bg-gray-400 text-white rounded">Back</button>
            <button @click="nextStep" class="px-4 py-2 bg-blue-500 text-white rounded">Next</button>
          </div>

          <div v-if="step === 3" class="w-full p-6 bg-gray-100 rounded-lg">
            <p>💳 Enter your payment details to proceed.</p>
            <button @click="prevStep" class="mr-2 px-4 py-2 bg-gray-400 text-white rounded">Back</button>
            <button @click="nextStep" class="px-4 py-2 bg-blue-500 text-white rounded">Next</button>
          </div>

          <div v-if="step === 4" class="w-full p-6 bg-gray-100 rounded-lg">
            <p>✅ Review and confirm your rental details.</p>
            <button @click="prevStep" class="mr-2 px-4 py-2 bg-gray-400 text-white rounded">Back</button>
            <button @click="finalize" class="px-4 py-2 bg-green-500 text-white rounded">Finish</button>
          </div>
        </div>

      </div>
    </div>
  </div>


    </AuthenticatedLayout>
</template>
