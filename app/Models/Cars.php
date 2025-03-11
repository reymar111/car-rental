<?php

namespace App\Models;
use App\Models\CarOwner;
use App\Models\CarModel;
use App\Models\CarColor;

use Illuminate\Database\Eloquent\Model;

class Cars extends Model
{
    protected $table = 'cars';

    protected $fillable = ['is_available'];


    public function owner()
    {
        return $this->belongsTo(CarOwner::class);
    }

    public function model()
    {
        return $this->belongsTo(CarModel::class);
    }

    public function color()
    {
        return $this->belongsTo(CarColor::class);
    }
}
