<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
  protected $fillable = [
    'driver_license_number',
    'user_id',
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function bus()
  {
    return $this->hasOne(Bus::class);
  }
}
