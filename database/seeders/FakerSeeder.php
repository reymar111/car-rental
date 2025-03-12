<?php

namespace Database\Seeders;

use App\Models\Cars;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FakerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $owner = Faker::create();

        foreach (range(1, 10) as $index) {
            DB::table('car_owners')->insert([
                'first_name' => $owner->firstNameMale,
                'middle_name' => $owner->firstNameMale,
                'last_name' => $owner->lastName,
                'contact_number' => $owner->phoneNumber,
                'address' => $owner->address,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $car = Faker::create();

        foreach (range(1, 40) as $index) {
            DB::table('cars')->insert([
                'owner_id' => $car->numberBetween(1, 10),
                'model_id' => $car->numberBetween(1, 82),
                'color_id' => $car->numberBetween(1, 16),
                'type_id' => $car->numberBetween(1, 11),
                'year' => $car->year(),
                'plate_number' => strtoupper($car->bothify('??? ####')), // Example: ABC 1234
                'max_capacity' => $car->numberBetween(1, 7),
                'is_available' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = Faker::create();

        foreach (range(1, 20) as $index)
        {
            DB::table('users')->insert([
                'name' => $user->name,
                'email' => $user->unique()->safeEmail,
                'password' => bcrypt('1234567890'), // Default password
                'is_admin' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $rental = Faker::create();

        $cities = DB::table('route_cities')
            ->join('routes', 'route_cities.route_id', '=', 'routes.id')
            ->select('route_cities.id as city_id', 'routes.id as route_id')
            ->get();

        foreach(range(1, 50) as $index) {
            $randomCity = $cities->random();

            DB::table('car_rentals')->insert([
                'transaction_number' => 'TXN-' . strtoupper(uniqid()),
                'user_id' => $rental->numberBetween(2, 20),
                'route_id' =>  $randomCity->route_id,
                'route_city_id' => $randomCity->city_id,
                'car_id' => $rental->numberBetween(1, 20),
                'number_passenger' => $rental->numberBetween(1, 5),
                'number_days' => $rental->numberBetween(1, 4),
                'car_type_id' => $rental->numberBetween(1, 11),
                'with_driver' => $rental->boolean,
                'car_color_id' => $rental->numberBetween(1,4),
                'total_amount' => $rental->randomFloat(2, 2500, 15000),
                'payment_id' => $rental->numberBetween(1,3),
                'pickup_date' => $rental->dateTimeBetween('now', '+30 days')->format('Y-m-d H:i:s'),
                'status_id' => $rental->numberBetween(1, 5),
                'created_at' => $rental->dateTimeBetween('now', '+30 days')->format('Y-m-d H:i:s'),
                'updated_at' => $rental->dateTimeBetween('now', '+30 days')->format('Y-m-d H:i:s'),
            ]);
        }

        $feedback = Faker::create();

        foreach(range(1, 40) as $index) {
            DB::table('car_rental_ratings')->insert([
                'car_rental_id' => $index,
                'value' => $feedback->numberBetween(1,5),
                'notes' => $feedback->sentence,
            ]);
        }
    }
}
