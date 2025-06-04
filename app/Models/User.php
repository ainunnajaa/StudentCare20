<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'jenis_kelamin',
        'role',
        'nim',
        'jurusan',
        'tanggal_lahir',
        'nip',
        'whatsapp',
        'profile_photo'

    ];

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

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isKonselor(): bool
    {
        return $this->role === 'konselor';
    }

    public function isMahasiswa(): bool
    {
        return $this->role === 'mahasiswa';
    }

    public function bookings()
    {
    return $this->hasMany(\App\Models\Booking::class, 'mahasiswa_id');
    }
    
    public function jadwals()
    {
        return $this->hasMany(Jadwal::class, 'konselor_id');
    }
    
    public function ratings()
    {
        return $this->hasManyThrough(
            \App\Models\Rating::class,
            \App\Models\Jadwal::class,
            'konselor_id',   // Foreign key di Jadwal yang menunjuk ke User (konselor)
            'jadwal_id',     // Foreign key di Rating yang menunjuk ke Jadwal
            'id',            // Local key di User (id konselor)
            'id'             // Local key di Jadwal
        );
    }




}

