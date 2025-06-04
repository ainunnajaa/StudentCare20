<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $fillable = ['konselor_id', 'waktu', 'status'];

    public function konselor()
    {
        return $this->belongsTo(User::class, 'konselor_id');
    }
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
    // Jadwal.php
public function ratings()
{
    return $this->hasManyThrough(
        Rating::class,
        Booking::class,
        'jadwal_id',   // Foreign key di bookings ke jadwals
        'booking_id',  // Foreign key di ratings ke bookings
        'id',          // Local key di jadwals
        'id'           // Local key di bookings
    );
}


}
