<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = ['jadwal_id', 'mahasiswa_id', 'status'];

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class);
    }

    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }

    public function rating()
    {
        return $this->hasOne(Rating::class);
    }
    public function user()
{
    return $this->belongsTo(User::class); // mahasiswa yang booking
}

    
}
