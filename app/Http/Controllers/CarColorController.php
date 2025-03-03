<?php

namespace App\Http\Controllers;

use App\Models\CarColor;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CarColorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $colors = CarColor::all();
        return Inertia::render('Settings/Color', [
            'colors' => $colors
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

        $color = new CarColor();
        $color->name = $request->name;
        $color->save();

        return to_route('color.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CarColor $color)
    {
        $request->validate([
            'name' => ['required'],
        ]);

        $color->name = $request->name;
        $color->update();

        return to_route('color.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CarColor $color)
    {
        $color->delete();

        return to_route('color.index');
    }
}
