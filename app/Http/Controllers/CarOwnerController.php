<?php

namespace App\Http\Controllers;

use App\Models\CarOwner;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CarOwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $owners = CarOwner::all();
        return Inertia::render('Settings/CarOwner', [
            'owners' => $owners
        ]);
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => ['required'],
            'last_name' => ['required'],
            'contact_number' => ['required'],
            'address' => ['required'],
        ]);

        $owner = new CarOwner();
        $owner->first_name = $request->first_name;
        $owner->middle_name = $request->middle_name;
        $owner->last_name = $request->last_name;
        $owner->ext_name = $request->ext_name;
        $owner->contact_number = $request->contact_number;
        $owner->address = $request->address;
        $owner->save();

        return to_route('owner.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CarOwner $owner)
    {
        $request->validate([
            'first_name' => ['required'],
            'last_name' => ['required'],
            'contact_number' => ['required'],
            'address' => ['required'],
        ]);

        $owner->first_name = $request->first_name;
        $owner->middle_name = $request->middle_name;
        $owner->last_name = $request->last_name;
        $owner->ext_name = $request->ext_name;
        $owner->contact_number = $request->contact_number;
        $owner->address = $request->address;
        $owner->update();

        return to_route('owner.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CarOwner $owner)
    {
        $owner->delete();

        return to_route('owner.index');
    }
}
