<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $users = [
            [
                'name' => 'John Doe',
                'email' => 'admin@admin.com',
                'password' => bcrypt('1234567890'),
                'is_admin' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'John Doe',
                'email' => 'user@user.com',
                'password' => bcrypt('1234567890'),
                'is_admin' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        foreach($users as $user) {
            DB::table('users')->insert($user);
        }

        $types = [
            ['id' => 1, 'name' => 'Sedan', 'rental_within' => '2500', 'rental_without' => '4000'],
            ['id' => 2, 'name' => 'Hatchback', 'rental_within' => '0', 'rental_without' => '0'],
            ['id' => 3, 'name' => 'Crossover', 'rental_within' => '0', 'rental_without' => '0'],
            ['id' => 4, 'name' => 'SUV', 'rental_within' => '3500', 'rental_without' => '5500'],
            ['id' => 5, 'name' => 'Luxury Van', 'rental_within' => '8500', 'rental_without' => '8500'],
            ['id' => 6, 'name' => 'Pickup', 'rental_within' => '3600', 'rental_without' => '5500'],
            ['id' => 7, 'name' => 'Van', 'rental_within' => '5500', 'rental_without' => '7500'],
            ['id' => 8, 'name' => 'Minivan', 'rental_within' => '0', 'rental_without' => '0'],
            ['id' => 9, 'name' => 'Sports Car', 'rental_within' => '0', 'rental_without' => '0'],
            ['id' => 10, 'name' => 'Electric Vehicle (EV)', 'rental_within' => '0', 'rental_without' => '0'],
            ['id' => 11, 'name' => 'Hybrid', 'rental_within' => '0', 'rental_without' => '0'],
        ];

        $brands = [
            'Toyota',
            'Mitsubishi',
            'Honda',
            'Ford',
            'Nissan',
            'Suzuki',
            'Isuzu',
            'Hyundai',
            'Chevrolet',
            'Kia',
        ];

        $models = [
            ['id' => 1, 'name' => 'Toyota', 'models' => [
                ['brand_id' => 1, 'name' => 'Vios', 'type_id' => 1],
                ['brand_id' => 1, 'name' => 'Wigo', 'type_id' => 2],
                ['brand_id' => 1, 'name' => 'Corolla Cross', 'type_id' => 3],
                ['brand_id' => 1, 'name' => 'Fortuner', 'type_id' => 4],
                ['brand_id' => 1, 'name' => 'Land Cruiser', 'type_id' => 5],
                ['brand_id' => 1, 'name' => 'Hilux', 'type_id' => 6],
                ['brand_id' => 1, 'name' => 'HiAce', 'type_id' => 7],
                ['brand_id' => 1, 'name' => 'Innova', 'type_id' => 8],
                ['brand_id' => 1, 'name' => 'Rush', 'type_id' => 3],
            ]],
            ['id' => 2, 'name' => 'Mitsubishi', 'models' => [
                ['brand_id' => 2, 'name' => 'Mirage G4', 'type_id' => 1],
                ['brand_id' => 2, 'name' => 'Xpander', 'type_id' => 3],
                ['brand_id' => 2, 'name' => 'Montero Sport', 'type_id' => 4],
                ['brand_id' => 2, 'name' => 'Strada', 'type_id' => 6],
                ['brand_id' => 2, 'name' => 'L300', 'type_id' => 7],
            ]],
            ['id' => 3, 'name' => 'Honda', 'models' => [
                ['brand_id' => 3, 'name' => 'City', 'type_id' => 1],
                ['brand_id' => 3, 'name' => 'Brio', 'type_id' => 2],
                ['brand_id' => 3, 'name' => 'HR-V', 'type_id' => 3],
                ['brand_id' => 3, 'name' => 'CR-V', 'type_id' => 4],
                ['brand_id' => 3, 'name' => 'BR-V', 'type_id' => 3],
            ]],
            ['id' => 4, 'name' => 'Ford', 'models' => [
                ['brand_id' => 4, 'name' => 'Everest', 'type_id' => 4],
                ['brand_id' => 4, 'name' => 'Ranger', 'type_id' => 6],
                ['brand_id' => 4, 'name' => 'Territory', 'type_id' => 3],
                ['brand_id' => 4, 'name' => 'Mustang', 'type_id' => 9],
            ]],
            ['id' => 5, 'name' => 'Nissan', 'models' => [
                ['brand_id' => 5, 'name' => 'Almera', 'type_id' => 1],
                ['brand_id' => 5, 'name' => 'Navara', 'type_id' => 6],
                ['brand_id' => 5, 'name' => 'Terra', 'type_id' => 4],
                ['brand_id' => 5, 'name' => 'Urvan', 'type_id' => 7],
            ]],
            ['id' => 6, 'name' => 'Suzuki', 'models' => [
                ['brand_id' => 6, 'name' => 'Ertiga', 'type_id' => 8],
                ['brand_id' => 6, 'name' => 'Dzire', 'type_id' => 1],
                ['brand_id' => 6, 'name' => 'Celerio', 'type_id' => 2],
                ['brand_id' => 6, 'name' => 'Jimny', 'type_id' => 4],
            ]],
            ['id' => 7, 'name' => 'Isuzu', 'models' => [
                ['brand_id' => 7, 'name' => 'D-Max', 'type_id' => 6],
                ['brand_id' => 7, 'name' => 'MU-X', 'type_id' => 4],
            ]],
            ['id' => 8, 'name' => 'Hyundai', 'models' => [
                ['brand_id' => 8, 'name' => 'Accent', 'type_id' => 1],
                ['brand_id' => 8, 'name' => 'Tucson', 'type_id' => 3],
                ['brand_id' => 8, 'name' => 'Staria', 'type_id' => 5],
            ]],
            ['id' => 9, 'name' => 'Chevrolet', 'models' => [
                ['brand_id' => 9, 'name' => 'Trailblazer', 'type_id' => 4],
                ['brand_id' => 9, 'name' => 'Tracker', 'type_id' => 3],
            ]],
            ['id' => 10, 'name' => 'Kia', 'models' => [
                ['brand_id' => 10, 'name' => 'Soluto', 'type_id' => 1],
                ['brand_id' => 10, 'name' => 'Seltos', 'type_id' => 3],
                ['brand_id' => 10, 'name' => 'Carnival', 'type_id' => 8],
            ]],
        ];

        foreach ($types as $car_type) {
            DB::table('car_types')->insert([
                'name' => $car_type['name'],
                'rental_within' => $car_type['rental_within'],
                'rental_without' => $car_type['rental_without'],
            ]);
        }

        foreach ($brands as $brand) {
            DB::table('car_brands')->insert(['name' => $brand]);
        }

        foreach ($models as $brand) {
            foreach ($brand['models'] as $model) {
                DB::table('car_models')->insert([
                    'brand_id' => $model['brand_id'],
                    'name' => $model['name'],
                    'type_id' => $model['type_id']
                ]);
            }
        }

        foreach($models as $brand) {
            $brand_id = $brand['id'];
            $models = $brand['models'];
            foreach($models as $model) {
                $model['brand_id'] = $brand_id;
                DB::table('car_models')->insert($model);
            }
        }


        $colors = [
            'White',
            'Black',
            'Silver',
            'Gray',
            'Red',
            'Blue',
            'Yellow',
            'Orange',
            'Green',
            'Purple',
            'Matte Black',
            'Matte Gray',
            'Matte Red',
            'Matte Blue',
            'Matte Yellow',
            'Matte Orange',
        ];

        foreach($colors as $color) {
            DB::table('car_colors')->insert(['name' => $color]);
        }

        $status = [
            'Pending',
            'Approved',
            'Declined',
            'Cancelled',
            'Completed'
        ];

        foreach($status as $stat) {
            DB::table('car_statuses')->insert(['name' => $stat]);
        }

        $payment_modes = [
            'Cash',
            'GCash',
            'PayMaya',
            'Credit Card',
        ];

        foreach($payment_modes as $mode) {
            DB::table('payment_modes')->insert(['name' => $mode]);
        }

    }
}
