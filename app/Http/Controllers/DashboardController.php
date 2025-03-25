<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\CarRental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {

        $revenueThisWeek = DB::table('car_rentals')
            ->where('status_id', '5')
            ->whereRaw('YEARWEEK(pickup_date, 1) = YEARWEEK(CURDATE(), 1)')
            ->sum('total_amount');

        $revenueLastWeek = DB::table('car_rentals')
            ->where('status_id', '5')
            ->whereRaw('YEARWEEK(pickup_date, 1) = YEARWEEK(CURDATE() - INTERVAL 1 WEEK, 1)')
            ->sum('total_amount');

        $percentageChange = $revenueLastWeek > 0
            ? round((($revenueThisWeek - $revenueLastWeek) / $revenueLastWeek) * 100, 2)
            : 0;

        $topCategory = DB::table('car_rentals as r')
        ->join('cars as c', 'r.car_id', '=', 'c.id')
        ->join('car_types', 'c.type_id', '=', 'car_types.id')
        ->where('r.status_id', 5) // Ensure status_id is numeric if it is an integer column
        ->whereRaw('YEARWEEK(r.pickup_date, 1) = YEARWEEK(CURDATE(), 1)')
        ->select('car_types.name', DB::raw('SUM(r.total_amount) as revenue'))
        ->groupBy('car_types.name')
        ->orderByDesc('revenue')
        ->first();

        $monthlySummary = DB::table('car_rentals')
        // ->whereRaw('YEAR(pickup_date) = YEAR(CURDATE()) AND MONTH(pickup_date) = MONTH(CURDATE())')
        ->select(
            DB::raw('COUNT(id) as total_bookings'),
            DB::raw('SUM(CASE WHEN status_id = 5 THEN 1 ELSE 0 END) as completed_trips'),
            DB::raw('SUM(CASE WHEN status_id != 5 THEN 1 ELSE 0 END) as ongoing_trips'),
            DB::raw('SUM(CASE WHEN status_id = 8 THEN 1 ELSE 0 END) as canceled_trips')
        )
        ->first();

        $newListings = DB::table('cars')
            ->whereRaw('YEARWEEK(created_at, 1) = YEARWEEK(CURDATE(), 1)')
            ->count();

        $mostPopularCar = DB::table('car_rentals as r')
            ->join('cars as c', 'r.car_id', '=', 'c.id')
            ->join('car_types', 'c.type_id', 'car_types.id')
            ->whereRaw('YEARWEEK(r.pickup_date, 1) = YEARWEEK(CURDATE(), 1)')
            ->select('car_types.name', DB::raw('COUNT(r.id) as rental_count'))
            ->groupBy('c.id', 'c.type_id')
            ->orderByDesc('rental_count')
            ->first();

        $totalUsers = DB::table('users')->count();

        $newSignups = DB::table('users')
            ->whereRaw('YEARWEEK(created_at, 1) = YEARWEEK(CURDATE(), 1)')
            ->count();

        $averageRating = DB::table('car_rental_ratings')
        ->avg('value');

        $mostPraisedFeature = DB::table('car_rental_ratings')
            ->select('notes', DB::raw('COUNT(notes) as count'))
            ->whereNotNull('notes')
            ->groupBy('notes')
            ->orderByDesc('count')
            ->limit(1)
            ->value('notes');




        return Inertia::render('Dashboard', [
            'rev_total_revenue' => $revenueThisWeek,
            'rev_percentage_change' => $percentageChange,
            'rev_top_earning_category' => $topCategory->name ?? 'N/A',
            'monthly_summary' => $monthlySummary,
            'new_listings' => $newListings,
            'most_popular_car' => $mostPopularCar,
            'total_users' => $totalUsers,
            'new_sign_up' => $newSignups,
            'average_rating' => $averageRating,
            'most_praised_feature' => $mostPraisedFeature,


        ]);
    }

}
