<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    protected $table = 'buses';

    protected $fillable = [
        'plate_number',
        'capacity',
        'driver_id',
    ];

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function trips()
    {
        return $this->hasMany(Trip::class);
    }

    public function seats()
    {
        return $this->belongsToMany(Seat::class, 'bus_seats');
    }
}
