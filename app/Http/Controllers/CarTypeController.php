<?php

namespace App\Http\Controllers;

use App\Models\CarType;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CarTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $types = CarType::all();
        return Inertia::render('Settings/Type', [
            'types' => $types
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'rental_within' => ['required'],
            'rental_without' => ['required'],
        ]);

        $type = new CarType();
        $type->name = $request->name;
        $type->rental_within = $request->rental_within;
        $type->rental_without = $request->rental_without;
        $type->save();

        return to_route('type.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CarType $type)
    {
        $request->validate([
            'name' => ['required'],
            'rental_within' => ['required'],
            'rental_without' => ['required'],
        ]);

        $type->name = $request->name;
        $type->rental_within = $request->rental_within;
        $type->rental_without = $request->rental_without;
        $type->update();

        return to_route('type.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CarType $type)
    {
        $type->delete();

        return to_route('type.index');
    }
}
