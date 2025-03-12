<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Chart, registerables } from 'chart.js';
Chart.register(...registerables);

import { Head } from '@inertiajs/vue3';

export default {
    components: {
        AuthenticatedLayout,
        Head
    },
    props: {
        revenues: Object, // Data received from Inertia
        bookings: Object,
    },
    data() {
        return {

        }
    },
    watch: {
        revenues: {
            handler(newRevenues) {
                if (newRevenues) {
                this.updateChart(newRevenues);
                }
            },
            immediate: true, // Run on component mount
            deep: true,
        },
    },
    mounted() {
        Chart.register(...registerables);
        this.initCharts();
    },
    methods: {
        initCharts() {

            if (!this.revenues) return;

            this.chartInstance = new Chart(this.$refs.revenueChart, {
                type: "line",
                data: {
                labels: this.revenues.labels,
                datasets: [
                    {
                    label: "Revenue (₱ in thousands)",
                    data: this.revenues.data,
                    borderColor: "blue",
                    tension: 0.3,
                    backgroundColor: "rgba(0, 0, 255, 0.2)",
                    borderWidth: 5,
                    },
                ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            ticks: {
                                autoSkip: true, // Automatically skip labels if they don't fit
                                maxRotation: 0, // Prevents text from rotating
                                minRotation: 0,
                            }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1000, // Change the step size to 10,000
                                callback: function (value) {
                                return "₱" + value.toLocaleString(); // Format with commas
                                },
                            },
                        },
                    },
                    plugins: {
                        legend: {
                        labels: {
                            usePointStyle: true,
                            boxWidth: 10
                        }
                    }
                }
                }
            });

            const ctx = this.$refs.bookingChart;
            if (ctx) {
                this.bookingChartInstance = new Chart(ctx, {
                type: "line",
                data: {
                    labels: this.bookings.labels,
                    datasets: [
                    {
                        label: "Bookings",
                        data: this.bookings,
                        borderColor: "green",
                        tension: 0.3,
                        backgroundColor: "rgba(0, 128, 0, 0.2)",
                        borderWidth: 5,
                    },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                    x: {
                        ticks: {
                        autoSkip: true,
                        maxRotation: 0,
                        minRotation: 0,
                        },
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                        stepSize: 10, // Adjust step size if needed
                        callback: function (value) {
                            return value.toLocaleString(); // Format with commas
                        },
                        },
                    },
                    },
                    plugins: {
                    legend: {
                        labels: {
                        usePointStyle: true,
                        boxWidth: 10,
                        },
                    },
                    },
                },
                });
            }

        // // Payment Transactions Report (Doughnut Chart)
        // new Chart(this.$refs.paymentChart, {
        //     type: 'doughnut',
        //     data: {
        //     labels: ['Credit Card', 'PayPal', 'Bank Transfer'],
        //     datasets: [{ data: [60, 25, 15], backgroundColor: ['red', 'blue', 'yellow'] }]
        //     }
        // });

        // // Car Utilization Report (Horizontal Bar Chart)
        // new Chart(this.$refs.utilizationChart, {
        //     type: 'horizontalBar',
        //     data: {
        //     labels: ['Car A', 'Car B', 'Car C'],
        //     datasets: [{ label: 'Usage (hours)', data: [50, 75, 90], backgroundColor: 'purple' }]
        //     }
        // });

        // // Car Owner Earnings Report (Line Chart)
        // new Chart(this.$refs.earningsChart, {
        //     type: 'line',
        //     data: {
        //     labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
        //     datasets: [{ label: 'Earnings ($)', data: [2000, 3000, 4000, 3500, 5000], borderColor: 'orange' }]
        //     }
        // });

        // // Car Status Report (Pie Chart)
        // new Chart(this.$refs.statusChart, {
        //     type: 'pie',
        //     data: {
        //     labels: ['Available', 'Booked'],
        //     datasets: [{ data: [40, 60], backgroundColor: ['green', 'red'] }]
        //     }
        // });

        // // Customer Feedback Report (Radar Chart)
        // new Chart(this.$refs.feedbackChart, {
        //     type: 'radar',
        //     data: {
        //     labels: ['Service', 'Pricing', 'Cleanliness', 'Support'],
        //     datasets: [{ label: 'Ratings', data: [4, 3, 5, 4], backgroundColor: 'rgba(0,0,255,0.2)', borderColor: 'blue' }]
        //     }
        // });
        },

        updateChart(newRevenues) {
            if (this.chartInstance) {
                this.chartInstance.destroy(); // Destroy previous instance to avoid duplication
            }
            this.initCharts(); // Reinitialize chart with updated data
        },
    }
}
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Dashboard
            </h2>
        </template>

        <div class="py-2">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 gap-4 p-4">
                    <!-- Revenues Report -->
                    <div class="col-span-2 p-4 bg-white shadow rounded-lg h-[400px] flex flex-col">
                    <h2 class="text-lg font-bold">Revenues</h2>
                    <canvas ref="revenueChart"></canvas>
                    </div>

                    <!-- Booking Report -->
                    <div class="p-4 bg-white shadow rounded-lg">
                    <h2 class="text-lg font-bold">Booking Report</h2>
                    <canvas ref="bookingChart"></canvas>
                    </div>

                    <!-- Payment Transactions Report -->
                    <div class="p-4 bg-white shadow rounded-lg">
                    <h2 class="text-lg font-bold">Payment Transactions Report</h2>
                    <canvas ref="paymentChart"></canvas>
                    </div>

                    <!-- Car Utilization Report -->
                    <div class="p-4 bg-white shadow rounded-lg">
                    <h2 class="text-lg font-bold">Car Utilization Report</h2>
                    <canvas ref="utilizationChart"></canvas>
                    </div>

                    <!-- Car Owner Earnings Report -->
                    <div class="p-4 bg-white shadow rounded-lg">
                    <h2 class="text-lg font-bold">Car Owner Earnings Report</h2>
                    <canvas ref="earningsChart"></canvas>
                    </div>

                    <!-- Car Status Report -->
                    <div class="p-4 bg-white shadow rounded-lg">
                    <h2 class="text-lg font-bold">Car Status Report</h2>
                    <canvas ref="statusChart"></canvas>
                    </div>

                    <!-- Customer Feedback Report -->
                    <div class="p-4 bg-white shadow rounded-lg">
                    <h2 class="text-lg font-bold">Customer Feedback Report</h2>
                    <canvas ref="feedbackChart"></canvas>
                    </div>
                </div>
            </div>
            </div>

    </AuthenticatedLayout>
</template>


<style>
.grid {
  display: grid;
  gap: 1rem;
}
.bg-white {
  background: white;
}
.shadow {
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}
.rounded-lg {
  border-radius: 8px;
}
.p-4 {
  padding: 1rem;
}
</style>

