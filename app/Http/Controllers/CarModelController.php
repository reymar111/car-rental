<?php

namespace App\Http\Controllers;

use App\Models\CarModel;
use App\Models\CarBrand;
use App\Models\CarType;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CarModelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $models = CarModel::with(['brand', 'type'])->get();
        $brands = CarBrand::all();
        $types = CarType::all();
        return Inertia::render('Settings/Model', [
            'models' => $models,
            'brands' => $brands,
            'types' => $types,
        ]);
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type_id' => ['required'],
            'brand_id' => ['required'],
            'name' => ['required'],
        ]);

        $model = new CarModel();
        $model->brand_id = $request->brand_id;
        $model->type_id = $request->type_id;
        $model->name = $request->name;
        $model->save();

        return to_route('model.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CarModel $model)
    {
        $request->validate([
            'type_id' => ['required'],
            'brand_id' => ['required'],
            'name' => ['required'],
        ]);

        $model->brand_id = $request->brand_id;
        $model->type_id = $request->type_id;
        $model->name = $request->name;
        $model->update();

        return to_route('model.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CarModel $model)
    {
        $model->delete();

        return to_route('model.index');
    }
}
