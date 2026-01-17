<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusSeat extends Model
{
    protected $table = 'bus_seats';

    protected $fillable = [
        'bus_id',
        'seat_id',
    ];

    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }

    public function seat()
    {
        return $this->belongsTo(Seat::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
