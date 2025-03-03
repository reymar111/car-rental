<?php

namespace App\Models;

use App\Models\CarModel;
use Illuminate\Database\Eloquent\Model;

class CarType extends Model
{
    protected $table = 'car_types';
    protected $fillable = ['name'];

    public function models()
    {
        return $this->hasMany(CarModel::class);
    }
}
