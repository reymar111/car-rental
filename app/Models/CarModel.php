<?php

namespace App\Models;

use App\Models\CarType;
use Illuminate\Database\Eloquent\Model;

class CarModel extends Model
{
    protected $table = 'car_models';

    public function brand()
    {
        return $this->belongsTo(CarBrand::class);
    }

    public function type() 
    {
        return $this->belongsTo(CarType::class);
    }
}
