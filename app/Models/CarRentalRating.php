<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarRentalRating extends Model
{
    protected $table = 'car_rental_ratings';

    public function car_rental()
    {

        return $this->belongsTo(CarRental::class, 'car_rental_id', 'id');

    }
}
