<?php

namespace App\Http\Controllers;

use App\Models\CarRental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function RevenueReport(Request $request)
    {

        $result = CarRental::with(['renter', 'car', 'car.model', 'car.model.brand'])
                        ->whereBetween('created_at', [$request->from, $request->to])
                        ->get();


        return response()->json([
            'result' => $result
        ]);

    }

    public function BookingReport(Request $request)
    {

        $result = CarRental::with(['renter', 'car', 'car.model', 'car.model.brand', 'payment'])
                        ->whereBetween('created_at', [$request->from, $request->to])
                        ->get();


        return response()->json([
            'result' => $result
        ]);

    }

    public function PaymentTransactionsReport(Request $request)
    {

        $result = CarRental::with(['renter', 'car', 'car.model', 'car.model.brand', 'payment'])
                        ->whereBetween('created_at', [$request->from, $request->to])
                        ->get();


        return response()->json([
            'result' => $result
        ]);

    }

    public function CarUtilizationReport(Request $request)
    {

        $result = DB::table('car_rentals')
            ->select(
                'cars.id as car_id',
                'car_models.id   as car_model',
                'cars.plate_number',
                'users.name as owner',
                DB::raw('COUNT(car_rentals.id) as total_rentals'),
                DB::raw('SUM(car_rentals.number_days) as total_rental_days'), // Use number_days directly
                DB::raw('MAX(car_rentals.pickup_date) as last_rented_date'),
                DB::raw('SUM(car_rentals.total_amount) as revenue_generated'),
                DB::raw("CASE
                            WHEN cars.is_available = 1 THEN 'Rented'
                            ELSE 'Available'
                        END as current_status")
            )
            ->join('cars', 'car_rentals.car_id', '=', 'cars.id')
            ->join('car_models', 'cars.model_id', '=', 'car_models.id')
            ->leftJoin('users', 'car_rentals.user_id', '=', 'users.id')
            ->groupBy('cars.id', 'car_models.id', 'cars.plate_number', 'users.name', 'car_rentals.status_id')
            ->get();

            return response()->json([
                'result' => $result
            ]);


    }
}
