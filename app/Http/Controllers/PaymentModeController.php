<?php

namespace App\Http\Controllers;

use App\Models\PaymentMode;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PaymentModeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payment_modes = PaymentMode::all();
        return Inertia::render('Settings/PaymentMode', [
            'payment_modes' => $payment_modes
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

        $p_mode = new PaymentMode();
        $p_mode->name = $request->name;
        $p_mode->description = $request->description;
        $p_mode->account_number = $request->account_number;
        $p_mode->account_name = $request->account_name;
        $p_mode->notes = $request->notes;
        $p_mode->save();

        return to_route('payment_mode.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PaymentMode $p_mode)
    {
        $request->validate([
            'name' => ['required'],
        ]);

        $p_mode->name = $request->name;
        $p_mode->description = $request->description;
        $p_mode->account_number = $request->account_number;
        $p_mode->account_name = $request->account_name;
        $p_mode->notes = $request->notes;
        $p_mode->update();

        return to_route('payment_mode.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentMode $p_mode)
    {
        $p_mode->delete();

        return to_route('payment_mode.index');
    }
}
