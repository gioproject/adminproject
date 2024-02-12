<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [

        'vehicle_name',
        'vehicle_registration_number',
        'vehicle_number_of_seats',
        'driver_name',
        'vehicle_category',
        'status',
        'photo',
    ];
}
