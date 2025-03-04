<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Routes extends Model
{
    protected $table = 'routes';

    protected $casts = [
        'is_within' => 'boolean'
    ];

    public function cities()
    {

        return $this->hasMany(RouteCities::class, 'route_id', 'id');

    }
}
