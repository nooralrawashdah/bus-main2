<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;    // مشان يعمل تأكد لايميل يوزر هو عندي
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Contracts\LaratrustUser;
use Laratrust\Traits\HasRolesAndPermissions;

class User extends Authenticatable implements MustVerifyEmail, LaratrustUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRolesAndPermissions;   // هون  استدعيت تبع انو يتحقق من  ايميل المستخدم

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'region_id',
        'phone_number',
    ];

    // Relationships
    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function driver()
    {
        return $this->hasOne(Driver::class);
    }

    public function manager()
    {
        return $this->hasOne(Manager::class);
    }

    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
