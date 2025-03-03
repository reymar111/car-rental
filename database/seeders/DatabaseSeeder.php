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
            ['id' => 1, 'name' => 'Sedan'],
            ['id' => 2, 'name' => 'Hatchback'],
            ['id' => 3, 'name' => 'Crossover (CUV)'],
            ['id' => 4, 'name' => 'Sports (SUV)'],
            ['id' => 5, 'name' => 'Full-Size SUV'],
            ['id' => 6, 'name' => 'Pickup Truck'],
            ['id' => 7, 'name' => 'Van'],
            ['id' => 8, 'name' => 'Minivan'],
            ['id' => 9, 'name' => 'Sports Car'],
            ['id' => 10, 'name' => 'Electric Vehicle (EV)'],
            ['id' => 11, 'name' => 'Hybrid'],
        ];

        foreach($types as $car_type) {
            DB::table('car_types')->insert(['name' => $car_type['name']]);
        }

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
            'Mazda', 
            'Subaru', 
            'BMW', 
            'Mercedes-Benz', 
            'Volkswagen', 
            'Foton', 
            'Chery', 
            'Geely', 
            'MG', 
            'Peugeot', 
            'Lexus', 
            'Audi', 
            'Jeep', 
            'Volvo', 
            'Porsche', 
            'Jaguar', 
            'Land Rover', 
            'Changan', 
            'Dongfeng', 
            'BAIC', 
            'BYD', 
            'Tata', 
            'GAC', 
            'Haval', 
            'Great Wall Motors', 
            'Maxus', 
            'SsangYong', 
            'FAW', 
            'JMC'
        ];

        foreach($brands as $brand) {
            DB::table('car_brands')->insert(['name' => $brand]);
        }

        
        $models = [
            ['id' => 1, 'name' => 'Toyota', 'models' => [
                ['brand_id' => 1, 'name' => 'Vios', 'type_id' => 1], // Sedan
                ['brand_id' => 1, 'name' => 'Wigo', 'type_id' => 2], // Hatchback
                ['brand_id' => 1, 'name' => 'Corolla Cross', 'type_id' => 3], // Crossover (CUV)
                ['brand_id' => 1, 'name' => 'Fortuner', 'type_id' => 4], // Sports (SUV)
                ['brand_id' => 1, 'name' => 'Land Cruiser', 'type_id' => 5], // Full-Size SUV
                ['brand_id' => 1, 'name' => 'Hilux', 'type_id' => 6], // Pickup Truck
                ['brand_id' => 1, 'name' => 'HiAce', 'type_id' => 7], // Van
                ['brand_id' => 1, 'name' => 'Innova', 'type_id' => 8], // Minivan
                ['brand_id' => 1, 'name' => 'GR Supra', 'type_id' => 9], // Sports Car
                ['brand_id' => 1, 'name' => 'bZ4X', 'type_id' => 10], // Electric Vehicle (EV)
                ['brand_id' => 1, 'name' => 'Prius', 'type_id' => 11], // Hybrid
            ]],
            ['id' => 2, 'name' => 'Mitsubishi', 'models' => [
                ['brand_id' => 2, 'name' => 'Mirage G4', 'type_id' => 1], // Sedan
                ['brand_id' => 2, 'name' => 'Mirage', 'type_id' => 2], // Hatchback
                ['brand_id' => 2, 'name' => 'Xpander', 'type_id' => 3], // Crossover (CUV)
                ['brand_id' => 2, 'name' => 'Montero Sport', 'type_id' => 4], // Sports (SUV)
                ['brand_id' => 2, 'name' => 'Pajero', 'type_id' => 5], // Full-Size SUV
                ['brand_id' => 2, 'name' => 'Strada', 'type_id' => 6], // Pickup Truck
                ['brand_id' => 2, 'name' => 'L300', 'type_id' => 7], // Van
            ]],
            ['id' => 3, 'name' => 'Honda', 'models' => [
                ['brand_id' => 3, 'name' => 'City', 'type_id' => 1], // Sedan
                ['brand_id' => 3, 'name' => 'Brio', 'type_id' => 2], // Hatchback
                ['brand_id' => 3, 'name' => 'HR-V', 'type_id' => 3], // Crossover (CUV)
                ['brand_id' => 3, 'name' => 'CR-V', 'type_id' => 4], // Sports (SUV)
                ['brand_id' => 3, 'name' => 'Pilot', 'type_id' => 5], // Full-Size SUV
                ['brand_id' => 3, 'name' => 'Ridgeline', 'type_id' => 6], // Pickup Truck
                ['brand_id' => 3, 'name' => 'Odyssey', 'type_id' => 8], // Minivan
                ['brand_id' => 3, 'name' => 'Civic Type R', 'type_id' => 9], // Sports Car
                ['brand_id' => 3, 'name' => 'e:NS1', 'type_id' => 10], // Electric Vehicle (EV)
                ['brand_id' => 3, 'name' => 'Insight', 'type_id' => 11], // Hybrid
            ]],
            ['id' => 4, 'name' => 'Ford', 'models' => [
                ['brand_id' => 4, 'name' => 'Focus', 'type_id' => 1], // Sedan
                ['brand_id' => 4, 'name' => 'Fiesta', 'type_id' => 2], // Hatchback
                ['brand_id' => 4, 'name' => 'EcoSport', 'type_id' => 3], // Crossover (CUV)
                ['brand_id' => 4, 'name' => 'Everest', 'type_id' => 4], // Sports (SUV)
                ['brand_id' => 4, 'name' => 'Expedition', 'type_id' => 5], // Full-Size SUV
                ['brand_id' => 4, 'name' => 'Ranger', 'type_id' => 6], // Pickup Truck
                ['brand_id' => 4, 'name' => 'Transit', 'type_id' => 7], // Van
                ['brand_id' => 4, 'name' => 'Mustang', 'type_id' => 9], // Sports Car
                ['brand_id' => 4, 'name' => 'Mustang Mach-E', 'type_id' => 10], // Electric Vehicle (EV)
            ]],
            ['id' => 5, 'name' => 'Nissan', 'models' => [
                ['brand_id' => 5, 'name' => 'Almera', 'type_id' => 1], // Sedan
                ['brand_id' => 5, 'name' => 'March', 'type_id' => 2], // Hatchback
                ['brand_id' => 5, 'name' => 'Kicks', 'type_id' => 3], // Crossover (CUV)
                ['brand_id' => 5, 'name' => 'Terra', 'type_id' => 4], // Sports (SUV)
                ['brand_id' => 5, 'name' => 'Patrol', 'type_id' => 5], // Full-Size SUV
                ['brand_id' => 5, 'name' => 'Navara', 'type_id' => 6], // Pickup Truck
                ['brand_id' => 5, 'name' => 'Urvan', 'type_id' => 7], // Van
                ['brand_id' => 5, 'name' => 'GT-R', 'type_id' => 9], // Sports Car
                ['brand_id' => 5, 'name' => 'Leaf', 'type_id' => 10], // Electric Vehicle (EV)
                ['brand_id' => 5, 'name' => 'X-Trail Hybrid', 'type_id' => 11], // Hybrid
            ]],
        ];

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
