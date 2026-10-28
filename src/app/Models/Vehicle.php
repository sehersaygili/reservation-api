<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
   protected $fillable = [
    'location_id', 'brand', 'model', 'plate', 'category', 'daily_price', 'status',
];
    public function location(){
	return $this->belongsTo(Location::class);
    }

    public function bookings(){
	return $this->hasMany(Booking::class);
    }
}
