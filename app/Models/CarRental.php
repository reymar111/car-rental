<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class CarRental extends Model
{
    /*
    STATUS

    1 - AVAILABLE
    2 - FOR PAYMENT
    3 - PAID
    4 - TAKEN
    5 - RETURNED
    */

    protected $casts = [
        'with_driver' => 'boolean'
    ];

    protected $appends = ['status'];


    public function getStatusAttribute()
    {
        /*
        STATUS

        1 - AVAILABLE
        2 - FOR PAYMENT
        3 - PAID
        4 - TAKEN
        5 - RETURNED
        */

        switch ($this->status_id) {
            case 1:
                return 'AVAILABLE';
            case 2:
                return 'FOR PAYMENT';
            case 3:
                return 'PAID, WAITING FOR RELEASE';
            case 4:
                return 'TAKEN';
            case 5:
                return 'RETURNED';
            default:
                return 'UNKNOWN';
        }
    }


    public function user()
    {

        return $this->belongsTo(User::class, 'user_id', 'id');

    }

    public function province()
    {

        return $this->belongsTo(Routes::class, 'route_id', 'id');

    }

    public function city()
    {

        return $this->belongsTo(RouteCities::class, 'route_city_id', 'id');

    }

    public function car()
    {

        return $this->belongsTo(Cars::class, 'car_id', 'id');

    }

    public function car_type()
    {

        return $this->belongsTo(CarType::class, 'car_type_id', 'id');

    }

    public function car_color()
    {

        return $this->belongsTo(CarColor::class, 'car_color_id', 'id');

    }

    public function payment()
    {

        return $this->belongsTo(PaymentMode::class, 'payment_id', 'id');

    }

    public function proof_payment()
    {

        return $this->hasOne(RentalPayment::class, 'car_rental_id', 'id');

    }

}
