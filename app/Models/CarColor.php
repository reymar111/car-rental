<?php

namespace App\Models;
use App\Models\Cars;

use Illuminate\Database\Eloquent\Model;

class CarColor extends Model
{
    protected $table = 'car_colors';
    

    public function cars()
    {
        return $this->hasMany(Cars::class, 'color_id');
    }
}
