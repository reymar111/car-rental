<?php

namespace App\Models;
use App\Models\Car;

use Illuminate\Database\Eloquent\Model;

class CarOwner extends Model
{
    protected $table = 'car_owners';

    protected $appends = ['full_name'];

    public function getFullNameAttribute()
    {
        return " {$this->last_name}, {$this->ext_name} {$this->first_name}";
    }

    public function Cars()
    {
        return $this->hasMany(Car::class);
    }
}
