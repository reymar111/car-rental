<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Routes;
use Illuminate\Http\Request;

class RoutesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $routes = Routes::with('cities')->get();
        return Inertia::render('Settings/Routes', [
            'routes' => $routes
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

        $route = new Routes();
        $route->name = $request->name;
        $route->is_within = $request->is_within;
        $route->save();

        return to_route('route.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Routes $route)
    {
        $request->validate([
            'name' => ['required'],
        ]);

        $route->name = $request->name;
        $route->is_within = $request->is_within;
        $route->update();

        return to_route('route.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Routes $route)
    {
        $route->cities()->delete();

        $route->delete();

        return to_route('route.index');
    }
}
