<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\CarRental;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $rentals = CarRental::with([
            'province', 'city', 'car', 'car.model', 'car.model.brand', 'car_type', 'car_color', 'rating', 'renter',
        ])
        ->orderBy('created_at', 'desc')
        ->get();
        return Inertia::render('Transaction/Index', [
            'rentals' => $rentals
        ]);

    }

    public function release(CarRental $rental)
    {

        $rental->status_id = 4;
        $rental->update();

        // return to_route('transaction');

    }
}
