<?php

namespace App\Http\Controllers;

use App\Models\CarBrand;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CarBrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = CarBrand::all();
        return Inertia::render('Settings/Brand', [
            'brands' => $brands
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

        $brand = new CarBrand();
        $brand->name = $request->name;
        $brand->save();

        return to_route('brand.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CarBrand $brand)
    {
        $request->validate([
            'name' => ['required'],
        ]);

        $brand->name = $request->name;
        $brand->update();

        return to_route('brand.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CarBrand $brand)
    {
        $brand->delete();

        return to_route('brand.index');
    }
}
