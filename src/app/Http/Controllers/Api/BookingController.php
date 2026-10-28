<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'pickup_location_id' => 'required|exists:locations,id',
            'dropoff_location_id' => 'required|exists:locations,id',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'starts_at' => 'required|date|after:now',
            'ends_at' => 'required|date|after:starts_at',
        ]);

        return DB::transaction(function () use ($data) {
            // Aracın satırını kilitle: aynı araç için diğer istekler bu işlem bitene kadar bekler.
            $vehicle = Vehicle::lockForUpdate()->findOrFail($data['vehicle_id']);

            $conflict = Booking::where('vehicle_id', $vehicle->id)
                ->whereIn('status', ['pending', 'confirmed'])
                ->where('starts_at', '<', $data['ends_at'])
                ->where('ends_at', '>', $data['starts_at'])
                ->exists();

            if ($conflict) {
                return response()->json(['message' => 'Bu araç seçilen tarihlerde müsait değil.'], 409);
            }

            $hours = Carbon::parse($data['starts_at'])->diffInHours(Carbon::parse($data['ends_at']));
            $days = max(1, (int) ceil($hours / 24));

            $booking = Booking::create([
                ...$data,
                'total_price' => $vehicle->daily_price * $days,
                'status' => 'pending',
            ]);

            return response()->json($booking, 201);
        });
    }
}
