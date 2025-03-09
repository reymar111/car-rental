<?php

namespace App\Http\Controllers;

use App\Models\CarRental;
use App\Models\CarRentalRating;
use Illuminate\Http\Request;

class CarRentalRatingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, CarRental $rental)
    {
        $rate = new CarRentalRating();
        $rate->car_rental_id = $rental->id;
        $rate->value = $request->value;
        $rate->notes = $request->notes;
        $rate->save();

    }

    /**
     * Display the specified resource.
     */
    public function show(CarRentalRating $carRentalRating)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CarRentalRating $carRentalRating)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CarRentalRating $carRentalRating)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CarRentalRating $carRentalRating)
    {
        //
    }
}
