<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    protected $fillable = [
        'seat_number',
    ];

    public function buses()
    {
        return $this->belongsToMany(Bus::class, 'bus_seats');
    }
}
