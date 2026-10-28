<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
   protected $fillable = [
    'vehicle_id', 'pickup_location_id', 'dropoff_location_id',
    'customer_name', 'customer_email', 'starts_at', 'ends_at',
    'total_price', 'status',
];

public function vehicle()
{
    return $this->belongsTo(Vehicle::class);
}

public function pickupLocation()
{
    return $this->belongsTo(Location::class, 'pickup_location_id');
}

public function dropoffLocation()
{
    return $this->belongsTo(Location::class, 'dropoff_location_id');
}
}
