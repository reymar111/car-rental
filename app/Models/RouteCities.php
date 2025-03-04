<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RouteCities extends Model
{
    protected $table = 'route_cities';

    public function region()
    {

        return $this->belongsTo(Routes::class, 'route_id', 'id');

    }
}
