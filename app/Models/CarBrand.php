<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarBrand extends Model
{
    protected $table = 'car_brands';

    public function cars()
    {
        return $this->hasMany(Car::class);
    }

    public function models()
    {
        return $this->hasMany(CarModel::class);
    }
}
