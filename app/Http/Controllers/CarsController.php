<?php

namespace App\Http\Controllers;

use App\Models\Cars;
use App\Models\CarModel;
use App\Models\CarColor;
use App\Models\CarOwner;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CarsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cars = Cars::with(['model.brand', 'model.type', 'owner', 'color'])->get();
        $models = CarModel::with('brand')->get();
        $colors = CarColor::all();
        $owners = CarOwner::all();
        
        return Inertia::render('Settings/Cars', [
            'cars' => $cars,
            'models' => $models,
            'colors' => $colors,
            'owners' => $owners
        ]);
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'owner_id' => ['required'],
            'model_id' => ['required'],
            'color_id' => ['required'],
            'year' => ['required'],
            'plate_number' => ['required'],
            'rental_price' => ['required'],
            'max_capacity' => ['required'],
        ], [
            'owner_id.required' => 'The owner field is required.',
            'model_id.required' => 'The model field is required.',
            'color_id.required' => 'The color field is required.',
            'year.required' => 'The year field is required.',
            'plate_number.required' => 'The plate number field is required.',
            'rental_price.required' => 'The rental price field is required.',
        ]);
        

        $car = new Cars();
        $car->owner_id = $request->owner_id;
        $car->model_id = $request->model_id;
        $car->year = $request->year;
        $car->color_id = $request->color_id;
        $car->plate_number = $request->plate_number;
        $car->rental_price = $request->rental_price;
        $car->max_capacity = $request->max_capacity;
        $car->features = $request->features;
        $car->save();

        return to_route('car.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cars $car)
    {
        $request->validate([
            'owner_id' => ['required'],
            'model_id' => ['required'],
            'color_id' => ['required'],
            'year' => ['required'],
            'plate_number' => ['required'],
            'rental_price' => ['required'],
            'max_capacity' => ['required'],
        ], [
            'owner_id.required' => 'The owner field is required.',
            'model_id.required' => 'The model field is required.',
            'color_id.required' => 'The color field is required.',
            'year.required' => 'The year field is required.',
            'plate_number.required' => 'The plate number field is required.',
            'rental_price.required' => 'The rental price field is required.',
        ]);
        
        $car->owner_id = $request->owner_id;
        $car->model_id = $request->model_id;
        $car->color_id = $request->color_id;
        $car->year = $request->year;
        $car->plate_number = $request->plate_number;
        $car->rental_price = $request->rental_price;
        $car->max_capacity = $request->max_capacity;
        $car->features = $request->features;
        $car->update();

        return to_route('car.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cars $car)
    {
        $car->delete();

        return to_route('car.index');
    }
}
