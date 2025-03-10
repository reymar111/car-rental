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
    public function index(Request $request)
    {
        $rentals = CarRental::with([
            'province', 'city', 'car', 'car.model', 'car.model.brand', 'car_type', 'car_color', 'rating'
        ])
        ->where('user_id', $request->user()->id)
        ->orderBy('created_at', 'desc')
        ->get();
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
                ->when($request->for_edit === true, function($query) {
                    $query->whereIn('is_available', [1, 0]);
                })
                ->when($request->for_edit === false, function($query) {
                    $query->where('is_available', 1);
                })
                ->get();

        return response()->json([
            'available_cars' => $cars
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'car_id' => ['required'],
            'route_id' => ['required'],
            'route_city_id' => ['required'],
            'number_passenger' => ['required'],
            'number_days' => ['required'],
            'total_amount' => ['required'],
        ],
        [
            'car_id.required' => 'Car is required',
            'route_id.required' => 'Province is required',
            'route_city_id.required' => 'City is required',
            'number_passenger.required' => 'Number of Passenger is required',
            'number_days.required' => 'Number of Day is required',
            'sum_total.required' => 'Sum Total is required',
        ]
        );

        // update car status
        $car = Cars::find($request->car_id);
        $car->is_available = false;
        $car->update();

        $rental = new CarRental();
        $rental->transaction_number = 'TXN-' . strtoupper(uniqid());
        $rental->user_id = $request->user()->id;
        $rental->route_id = $request->route_id;
        $rental->route_city_id = $request->route_city_id;
        $rental->car_id = $request->car_id;
        $rental->number_passenger = $request->number_passenger;
        $rental->number_days = $request->number_days;
        $rental->car_type_id = $request->car_type_id;
        $rental->with_driver = $request->with_driver;
        $rental->car_color_id = $request->car_color_id;
        $rental->total_amount = $request->total_amount;
        $rental->payment_id = $request->payment_id;
        $rental->pickup_date = $request->pickup_date;
        $rental->return_date = $request->return_date;
        $rental->status_id = 2;
        $rental->save();

        /*
        STATUS

        1 - AVAILABLE
        2 - FOR PAYMENT
        3 - PAID
        4 - TAKEN
        5 - RETURNED
        */

    }

    public function show(CarRental $rental, Request $request)
    {
        if($request->user()->is_admin != 1 && $rental->user_id != $request->user()->id) {
            return redirect()->back();
        }


        $provinces = Routes::with(['cities' => function ($query) {
            $query->orderBy('name'); // Remove 'return' and just call the method
        }])->orderBy('name')->get();

        $types = CarType::all();
        $car_colors = CarColor::all();
        $payments = PaymentMode::all();

        // Ensure $rental is retrieved before loading relations
        $rental->load([
            'province',
            'city',
            'car',
            'car.owner',
            'car.model',
            'car.model.brand',
            'car.model.type',
            'car_type',
            'car_color',
            'payment',
            'proof_payment',
        ]);

        return Inertia::render('Rental/Show', [
            'provinces' => $provinces,
            'car_types' => $types,
            'car_colors' => $car_colors,
            'payments' => $payments,
            'rent' => $rental,
        ]);

    }

    public function edit(CarRental $rental, Request $request)
    {

        if(($request->user()->is_admin != 1 && $rental->user_id != $request->user()->id) || $rental->status_id != 2) {
            return redirect()->back();
        }


        $provinces = Routes::with(['cities' => function ($query) {
            $query->orderBy('name'); // Remove 'return' and just call the method
        }])->orderBy('name')->get();

        $types = CarType::all();
        $car_colors = CarColor::all();
        $payments = PaymentMode::all();

        return Inertia::render('Rental/Edit', [
            'provinces' => $provinces,
            'car_types' => $types,
            'car_colors' => $car_colors,
            'payments' => $payments,
            'rent' => $rental,
        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CarRental $rental)
    {
        if($request->user()->is_admin != 1 && $rental->user_id != $request->user()->id) {
            return redirect()->back();
        }



        $request->validate([
            'car_id' => ['required'],
            'route_id' => ['required'],
            'route_city_id' => ['required'],
            'number_passenger' => ['required'],
            'number_days' => ['required'],
            'total_amount' => ['required'],
        ],
        [
            'car_id.required' => 'Car is required',
            'route_id.required' => 'Province is required',
            'route_city_id.required' => 'City is required',
            'number_passenger.required' => 'Number of Passenger is required',
            'number_days.required' => 'Number of Day is required',
            'sum_total.required' => 'Sum Total is required',
        ]
        );

        // search and update car
        if($rental->car_id != $request->car_id) {
            // set the previous car as available
            $prev = Cars::find($rental->car_id);
            $prev->is_available = 1;
            $prev->update();

            $new_car = Cars::find($request->car_id);
            $new_car->is_available = 0;
            $new_car->update();
        }

        $rental->route_id = $request->route_id;
        $rental->route_city_id = $request->route_city_id;
        $rental->car_id = $request->car_id;
        $rental->number_passenger = $request->number_passenger;
        $rental->number_days = $request->number_days;
        $rental->car_type_id = $request->car_type_id;
        $rental->with_driver = $request->with_driver;
        $rental->car_color_id = $request->car_color_id;
        $rental->total_amount = $request->total_amount;
        $rental->payment_id = $request->payment_id;
        $rental->pickup_date = $request->pickup_date;
        $rental->return_date = $request->return_date;
        $rental->status_id = 2;
        $rental->update();

        /*
        STATUS

        1 - AVAILABLE
        2 - FOR PAYMENT
        3 - PAID
        4 - TAKEN
        5 - RETURNED
        */
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CarRental $rental, Request $request)
    {
        if($request->user()->is_admin != 1 && $rental->user_id != $request->user()->id) {
            return redirect()->back();
        }


        $rental->delete();

        return to_route('rental.index');
    }
}
