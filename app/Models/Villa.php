<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Villa extends Model
{
    use HasFactory;
    protected $fillable = [
        'uuid',
        'nama_villa',
        'alamat',
        'deskripsi',
        'foto',
        'harga_sewa',
    ];

    public static $searchable = [
        'nama_villa',
        'alamat',
        'deskripsi',
        'harga_sewa',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'villa_id', 'id');
    }
}
