<?php

namespace App\Http\Controllers;

use App\Models\Cars;
use Inertia\Inertia;
use App\Models\Routes;
use App\Models\CarType;
use App\Models\CarColor;
use App\Models\CarRental;
use App\Models\PaymentMode;
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

        $types = CarType::all();
        $car_colors = CarColor::all();
        $payments = PaymentMode::all();

        return Inertia::render('Rental/Create', [
            'provinces' => $provinces,
            'car_types' => $types,
            'car_colors' => $car_colors,
            'payments' => $payments,
        ]);

    }

    public function searchAvailableCar(Request $request)
    {

        $cars = Cars::with(['model.brand', 'model.type', 'owner', 'color'])
        ->whereHas('model.type', function($query) use($request) {
            $query->where('id', $request->car_type_id);
        })
        ->when($request->car_color_id, function($query) use($request) {
            $query->where('color_id', $request->car_color_id);
        })
        ->when($request->number_passenger, function($query) use($request) {
            $query->where('max_capacity', '>=', $request->number_passenger);
        })
        ->get();

        return response()->json([
            'available_cars' => $cars
        ]);

        // return redirect()->back()->with('available_cars', $cars);

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
