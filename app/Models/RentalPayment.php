<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class RentalPayment extends Model
{
    protected $table = 'car_rental_payments';

    protected $appends = ['proof_payment_link'];



    public function getProofPaymentLinkAttribute()
    {
        if (!$this->proof_payment) {
            return null; // Return null if no file is uploaded
        }

        return Storage::url($this->proof_payment); // Generates a public URL if using 'public' disk
    }


    public function car_rental()
    {

        return $this->hasOne(CarRental::class, 'car_rental_id', 'id');

    }
}
