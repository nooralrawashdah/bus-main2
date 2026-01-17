<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $table = 'regions';
    protected $fillable =
    [
        'region_name'
    ];
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function routes()
    {
        return $this->hasMany(Route::class);
    }
}
