<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $table = 'bookings';
    protected $fillable = ['uuid', 'user_id', 'villa_id', 'nama_pemesan', 'no_hp', 'tanggal_checkin', 'tanggal_checkout', 'status_pembayaran', 'total_bayar'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function villa()
    {
        return $this->belongsTo(Villa::class, 'villa_id', 'id');
    }
}
