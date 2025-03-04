<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Routes;
use App\Models\RouteCities;
use Illuminate\Http\Request;

class RouteCitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $route_cities = RouteCities::with('region')->get();
        $regions = Routes::all();
        return Inertia::render('Settings/City', [
            'route_cities' => $route_cities,
            'regions' => $regions,
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

        $routeCity = new RouteCities();
        $routeCity->route_id = $request->route_id;
        $routeCity->name = $request->name;
        $routeCity->order = RouteCities::all()->count() + 1;
        $routeCity->save();

        return to_route('route_city.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RouteCities $route)
    {
        $request->validate([
            'name' => ['required'],
        ]);
        $route->name = $request->name;
        $route->route_id = $request->route_id;
        $route->update();

        return to_route('route_city.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RouteCities $route)
    {
        $route->delete();

        return to_route('route_city.index');
    }
}
