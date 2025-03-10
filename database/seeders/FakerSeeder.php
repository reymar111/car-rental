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

        $faker = Faker::create();

        foreach (range(1, 40) as $index) {
            DB::table('cars')->insert([
                'owner_id' => $faker->numberBetween(1, 10),
                'model_id' => $faker->numberBetween(1, 82),
                'color_id' => $faker->numberBetween(1, 16),
                'type_id' => $faker->numberBetween(1, 11),
                'year' => $faker->year(),
                'plate_number' => strtoupper($faker->bothify('??? ####')), // Example: ABC 1234
                'max_capacity' => $faker->numberBetween(1, 7),
                'is_available' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
