<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class CarRental extends Model
{
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
        3 - PAID, WAITING FOR RELEASE
        4 - RELEASED
        5 - COMPLETED
        6 - FOR CONFIRMATION
        8 - CANCELED
        */

        switch ($this->status_id) {
            case 1:
                return 'AVAILABLE';
            case 2:
                return 'CONFIRMED, FOR PAYMENT';
            case 3:
                return 'PAID, WAITING FOR RELEASE';
            case 4:
                return 'RELEASED';
            case 5:
                return 'COMPLETED';
            case 6:
                return 'FOR CONFIRMATION';
            case 8:
                return 'CANCELED';
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

    public function rating()
    {

        return $this->hasOne(CarRentalRating::class, 'car_rental_id', 'id');

    }

    public function renter()
    {

        return $this->belongsTo(User::class, 'user_id', 'id');

    }

}
