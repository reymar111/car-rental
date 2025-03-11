<?php

namespace App\Http\Controllers;

use App\Models\CarRental;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function RevenueReport(Request $request)
    {

        $result = CarRental::with(['renter', 'car', 'car.model', 'car.model.brand'])
                        ->whereBetween('created_at', [$request->from, $request->to])
                        ->get();


        return response()->json([
            'result' => $result
        ]);

    }
}
