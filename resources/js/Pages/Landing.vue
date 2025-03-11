<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link, Head } from '@inertiajs/vue3';
import logo from '@/assets/logo.png';
</script>

<template>
    <Head title="Home" />

<GuestLayout>

</GuestLayout>
        <section id="home" class="bg-white mt-16">
            <div class="mt-0 pb-0 grid max-w-screen-xl px-4 py-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12">
                <div class="mr-auto place-self-center lg:col-span-7">
                    <h1 class="max-w-6xl mb-4 text-4xl font-extrabold tracking-tight leading-none md:text-5xl xl:text-6xl">
                        S-Trip Car Rental
                    </h1>
                    <p class="max-w-2xl mb-6 font-light text-gray-800 lg:mb-8 md:text-lg lg:text-xl">
                        Seamless booking, effortless checkout, and hassle-free rides—all in one place.
                        Secure, reliable, and stress-free travel, wherever you go. 🌍🚘 🚗✨
                    </p>
                    <Link :href="route('register')" class="bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-blue-300
                        inline-flex items-center justify-center px-5 py-3 mr-3 text-base font-medium text-center text-white
                        rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300">
                        Rent a Car 🚗
                    </Link>
                </div>
                <div class="hidden lg:mt-0 lg:col-span-5 lg:flex">
                    <img src="/car.webp" class="h-auto max-w-full" alt="mockup">
                </div>
            </div>

            <!-- Car Logos Grid -->
            <div class="mt-0 max-w-screen-xl px-4 py-8 mx-auto grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 xl:grid-cols-8
                        gap-4 p-6 justify-items-center items-center">
                <div class="flex justify-center items-center">
                    <img src="/logos/toyota.png" alt="Toyota" class="w-24 h-auto grayscale">
                </div>
                <div class="flex justify-center items-center">
                    <img src="/logos/mitsubishi.png" alt="Mitsubishi" class="w-24 h-auto grayscale">
                </div>
                <div class="flex justify-center items-center">
                    <img src="/logos/honda.png" alt="Honda" class="w-24 h-auto grayscale">
                </div>
                <div class="flex justify-center items-center">
                    <img src="/logos/ford.png" alt="Ford" class="w-24 h-auto grayscale">
                </div>
                <div class="flex justify-center items-center">
                    <img src="/logos/nissan.png" alt="Nissan" class="w-24 h-auto grayscale">
                </div>
                <div class="flex justify-center items-center">
                    <img src="/logos/suzuki.jpg" alt="Suzuki" class="w-24 h-auto grayscale">
                </div>
                <div class="flex justify-center items-center">
                    <img src="/logos/hyundai.png" alt="Hyundai" class="w-24 h-auto grayscale">
                </div>
                <div class="flex justify-center items-center">
                    <img src="/logos/mazda.png" alt="Hyundai" class="w-24 h-auto grayscale">
                </div>
            </div>


        </section>

        <section id="about" class="bg-gray-100 ">
            <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
                <div class="max-w-screen-lg text-white-500 sm:text-lg ">
                    <h2 class="mb-4 text-4xl tracking-tight font-bold text-black-900 "><span class="font-extrabold">S-Trip Car Rental</span> – Powering Seamless Travel Locally.</h2>
                    <p class="mb-4 font-light">Effortlessly track and manage your rentals with our easy-to-use platform. From booking to drop-off, streamline operations and enhance customer experiences—all in one place.</p>
                    <p class="mb-4 font-medium">Deliver top-notch service without the hassle. Simplify processes, reduce wait times, and keep every trip smooth and stress-free. 🚗✨</p>
                    <!-- <a href="#" class="inline-flex items-center font-medium text-primary-600 hover:text-primary-800 dark:text-primary-500 dark:hover:text-primary-700">
                        Learn more
                        <svg class="ml-1 w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    </a> -->
                </div>
            </div>
        </section>

        <section id="services" class="bg-gray-100">
            <div class="py-2 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
                <div class="mx-auto max-w-screen-md text-center mb-8 lg:mb-12">
                    <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 ">Business Class Vehicles</h2>
                    <p class="mb-5 font-light text-gray-500 sm:text-xl ">Choose the perfect car type for your needs. Whether for daily commutes, off-road adventures, or luxurious travel, we have the right vehicle for you.</p>
                </div>
                <div class="space-y-8 lg:grid lg:grid-cols-3 sm:gap-6 xl:gap-10 lg:space-y-0">
                    <!-- Pricing Card -->
                    <div class="flex flex-col p-6 mx-auto max-w-lg text-center text-black-900 bg-white rounded-lg border border-gray-100 shadow  xl:p-8  ">
                        <h3 class="mb-4 text-2xl font-semibold">🚘 Sedan</h3>
                        <p class="font-light text-gray-500 sm:text-lg ">Best option for personal use & for your next project.</p>
                        <div class="flex justify-center items-baseline my-8">
                            Starts at <span class="mr-2 text-4xl font-extrabold"> &nbsp; ₱2500</span>
                            <span class="text-gray-500 ">/day</span>
                        </div>
                        <!-- List -->
                        <ul role="list" class="mb-8 space-y-4 text-left">
                            <li class="flex items-center space-x-3">
                                <!-- Icon -->
                                <svg class="flex-shrink-0 w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                <span>Fuel Efficiency</span>
                            </li>
                            <li class="flex items-center space-x-3">
                                <!-- Icon -->
                                <svg class="flex-shrink-0 w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                <span> Compact & Comfortable</span>
                            </li>
                            <li class="flex items-center space-x-3">
                                <!-- Icon -->
                                <svg class="flex-shrink-0 w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                <span>Affordable</span>
                            </li>
                        </ul>
                        <a href="#" class="text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:ring-primary-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">Get started</a>
                    </div>
                    <!-- Pricing Card -->
                    <div class="flex flex-col p-6 mx-auto max-w-lg text-center text-gray-900 bg-white rounded-lg border border-gray-100 shadow  xl:p-8  ">
                        <h3 class="mb-4 text-2xl font-semibold">🚙 SUV</h3>
                        <p class="font-light text-gray-500 sm:text-lg ">Best for fuel efficiency, comfort, and city driving.</p>
                        <div class="flex justify-center items-baseline my-8">
                            Starts at <span class="mr-2 text-4xl font-extrabold"> &nbsp; ₱4500</span>
                            <span class="text-gray-500 ">/day</span>
                        </div>
                        <!-- List -->
                        <ul role="list" class="mb-8 space-y-4 text-left">
                            <li class="flex items-center space-x-3">
                                <!-- Icon -->
                                <svg class="flex-shrink-0 w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                <span>Spacious Interior</span>
                            </li>
                            <li class="flex items-center space-x-3">
                                <!-- Icon -->
                                <svg class="flex-shrink-0 w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                <span>All-Terrain Capability</span>
                            </li>
                            <li class="flex items-center space-x-3">
                                <!-- Icon -->
                                <svg class="flex-shrink-0 w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                <span>Powerful Performance</span>
                            </li>
                        </ul>
                        <a href="#" class="text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:ring-primary-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">Get started</a>
                    </div>
                    <!-- Pricing Card -->
                    <div class="flex flex-col p-6 mx-auto max-w-lg text-center text-gray-900 bg-white rounded-lg border border-gray-100 shadow  xl:p-8  ">
                        <h3 class="mb-4 text-2xl font-semibold">🚗 Luxury</h3>
                        <p class="font-light text-gray-500 sm:text-lg ">Best for large scale uses and extended redistribution rights.</p>
                        <div class="flex justify-center items-baseline my-8">
                            Starts at <span class="mr-2 text-4xl font-extrabold"> &nbsp; ₱8500</span>
                            <span class="text-gray-500 ">/day</span>
                        </div>
                        <!-- List -->
                        <ul role="list" class="mb-8 space-y-4 text-left">
                            <li class="flex items-center space-x-3">
                                <!-- Icon -->
                                <svg class="flex-shrink-0 w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                <span>Premium Comfort</span>
                            </li>
                            <li class="flex items-center space-x-3">
                                <!-- Icon -->
                                <svg class="flex-shrink-0 w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                <span>Advanced Technology</span>
                            </li>
                            <li class="flex items-center space-x-3">
                                <!-- Icon -->
                                <svg class="flex-shrink-0 w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                <span> Elegant Design</span>
                            </li>
                        </ul>
                        <a href="#" class="text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:ring-primary-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">Get started</a>
                    </div>
                </div>
            </div>
        </section>

        <footer id="contact" class="p-1s bg-white md:p-8 lg:p-10 ">
            <div class="mx-auto max-w-screen-xl text-center">
                <a href="#" class="flex justify-center items-center text-2xl font-semibold text-black-900 ">
                    <ApplicationLogo />
                </a>
                <p class="my-6 text-gray-500 -400">Tuguegarao City, Cagayan</p>

                <span class="text-sm text-gray-500 sm:text-center ">© 2025-2026 <a href="#" class="hover:underline">S-Trip</a>. All Rights Reserved.</span>
            </div>
        </footer>



</template>
