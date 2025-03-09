<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\CarRental;
use Illuminate\Http\Request;
use App\Models\RentalPayment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;


class RentalPaymentController extends Controller
{

    public function create(CarRental $rental)
    {

        return Inertia::render('Payment/Create', [
            'rent' => $rental
        ]);

    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'reference_number' => 'required',
            'proof_payment' => 'required|file|mimes:png,jpg,jpeg,pdf|max:2048',
        ]);

        // Find the rental record
        $rental = CarRental::findOrFail($request->car_rental_id);
        $rental->status_id = 3;
        $rental->update();

        // Store the file
        if ($request->hasFile('proof_payment')) {
            $filePath = $request->file('proof_payment')->store('payments', 'public');
            $fileUrl = Storage::url($filePath);
            $fileName = $request->file('proof_payment')->getClientOriginalName();

            // Save to database
            $payment = new RentalPayment();
            $payment->car_rental_id = $request->car_rental_id;
            $payment->reference_number = $request->reference_number;
            $payment->proof_payment = $filePath; // Stored file path
            $payment->save();

            return response()->json([
                'message' => 'Payment saved successfully',
                'file_url' => $fileUrl,
                'file_name' => $fileName,
                'payment' => $payment
            ], Response::HTTP_OK);
        }

        return response()->json(['error' => 'File upload failed'], Response::HTTP_BAD_REQUEST);

    }

    /**
     * Display the specified resource.
     */
    public function show(RentalPayment $rentalPayment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RentalPayment $rentalPayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RentalPayment $rentalPayment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RentalPayment $rentalPayment)
    {
        //
    }
}
