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

    public function CarOwnerEarningReport(Request $request)
    {

        $result = DB::table('car_rentals')
            ->join('cars', 'car_rentals.car_id', '=', 'cars.id')
            ->join('users as owners', 'cars.owner_id', '=', 'owners.id') // Assuming 'users' table stores car owners
            ->select(
                'owners.id as owner_id',
                'owners.name as owner_name',
                DB::raw('COUNT(DISTINCT cars.id) as total_cars_listed'),
                DB::raw('COUNT(car_rentals.id) as total_rentals'),
                DB::raw('SUM(car_rentals.number_days) as total_rental_days'),
                DB::raw('SUM(car_rentals.total_amount) as total_earnings'),
                DB::raw('AVG(car_rentals.total_amount) as average_earnings_per_rental'),
                DB::raw('AVG(car_rentals.total_amount / car_rentals.number_days) as average_earnings_per_day'),
                DB::raw('MAX(car_rentals.pickup_date) as last_rental_date')
            )
            ->groupBy('owners.id', 'owners.name')
            ->get();

        return response()->json([
            'result' => $result
        ]);


    }

    public function CarStatusReport(Request $request)
    {

                /*
        STATUS

        1 - AVAILABLE
        2 - FOR PAYMENT
        3 - PAID, WAITING FOR RELEASE
        4 - RELEASED
        5 - COMPLETED
        */


        $result = DB::table('cars')
        ->leftJoin('car_rentals', 'cars.id', '=', 'car_rentals.car_id')
        ->leftJoin('users as owners', 'cars.owner_id', '=', 'owners.id')
        ->leftJoin('users as renters', 'car_rentals.user_id', '=', 'renters.id')
        ->leftJoin('car_models', 'cars.model_id', 'car_models.id')
        ->leftJoin('car_brands', 'car_models.brand_id', 'car_brands.id')
        ->select(
            'cars.id as car_id',
            'car_rentals.status_id',
            'cars.is_available',
            'car_models.name as car_model_name',
            'car_brands.name as car_brand_name',
            'cars.model_id',
            'owners.name as owner_name',
            'renters.name',
            DB::raw('
                CASE
                    WHEN car_rentals.status_id = 1 THEN "AVAILABLE"
                    WHEN car_rentals.status_id = 2 THEN "FOR PAYMENT"
                    WHEN car_rentals.status_id = 3 THEN "PAID, WAITING FOR RELEASE"
                    WHEN car_rentals.status_id = 4 THEN "RELEASED"
                    WHEN car_rentals.status_id = 5 THEN "COMPLETED"
                    WHEN cars.is_available = 1 THEN "AVAILABLE"
                    ELSE "UNAVAILABLE"
                END as status
            '),
            DB::raw('COUNT(car_rentals.id) as total_rentals'),
            DB::raw('COALESCE(SUM(car_rentals.number_days), 0) as total_rental_days'),
            DB::raw('COALESCE(SUM(car_rentals.total_amount), 0) as total_earnings'),
            DB::raw('MAX(car_rentals.pickup_date) as last_rental_date'),
            // DB::raw('MAX(renters.name) as current_renter'),
            'renters.name as current_renter',
            'car_rentals.pickup_date as current_rental_start',
            DB::raw('
                CASE
                    WHEN car_rentals.status_id = 4 THEN DATE_ADD(car_rentals.pickup_date, INTERVAL car_rentals.number_days DAY)
                    ELSE NULL
                END as next_available_date
            ')
        )
        ->groupBy('cars.id', 'cars.model_id', 'owners.name', 'cars.is_available', 'car_rentals.status_id', 'renters.name', 'car_rentals.pickup_date', 'car_rentals.number_days')
        ->get();

        return response()->json([
            'result' => $result
        ]);

    }

    public function CustomerFeedbackReport(Request $request)
    {

        $result = DB::table('car_rental_ratings')
                ->join('car_rentals', 'car_rental_ratings.car_rental_id', '=', 'car_rentals.id')
                ->join('cars', 'car_rentals.car_id', '=', 'cars.id')
                ->leftJoin('car_models', 'cars.model_id', 'car_models.id')
                ->leftJoin('car_brands', 'car_models.brand_id', 'car_brands.id')
                ->join('users as renters', 'car_rentals.user_id', '=', 'renters.id')
                ->join('users as owners', 'cars.owner_id', '=', 'owners.id')
                ->select(
                    'car_rentals.transaction_number',
                    'car_models.name as car_model_name',
                    'car_brands.name as car_brand_name',
                    'owners.name as owner_name',
                    'renters.name as customer_name',
                    'car_rental_ratings.value as rating',
                    'car_rental_ratings.notes as feedback',
                    'car_rentals.pickup_date',
                    DB::raw('DATE_ADD(car_rentals.pickup_date, INTERVAL car_rentals.number_days DAY) as return_date')
                )
                ->orderByDesc('car_rentals.pickup_date')
                ->get();

        return response()->json([
            'result' => $result
        ]);

    }
}
