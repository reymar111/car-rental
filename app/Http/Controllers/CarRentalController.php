<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Routes;
use App\Models\CarRental;
use Illuminate\Http\Request;

class CarRentalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rentals = CarRental::all();
        return Inertia::render('Rental/Index', [
            'rentals' => $rentals
        ]);
    }

    public function create()
    {

        $provinces = Routes::with(['cities' => function ($query) {
            $query->orderBy('name'); // Remove 'return' and just call the method
        }])->orderBy('name')->get();

        return Inertia::render('Rental/Create', [
            'provinces' => $provinces,
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
        ]);

        $rental = new CarRental();
        $rental->name = $request->name;
        $rental->save();

        return to_route('rental.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CarRental $rental)
    {
        $request->validate([
            'name' => ['required'],
        ]);

        $rental->name = $request->name;
        $rental->update();

        return to_route('rental.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CarRental $rental)
    {
        $rental->delete();

        return to_route('rental.index');
    }
}
