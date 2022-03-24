<?php

namespace Database\Seeders;

use App\Models\Booking;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bookings = [
            [
                'uuid' => Str::uuid(),
                'user_id' => 2,
                'villa_id' => 5,
                'nama_pemesan' => 'Rizky',
                'no_hp' => '081212121212',
                'tanggal_checkin' => '2022-03-01',
                'tanggal_checkout' => '2022-03-03',
                'status_pembayaran' => 'sudah bayar',
                'total_bayar' => 6000000,
            ],
            [
                'uuid' => Str::uuid(),
                'user_id' => 3,
                'villa_id' => 5,
                'nama_pemesan' => 'Zar',
                'no_hp' => '081212121212',
                'tanggal_checkin' => '2022-03-04',
                'tanggal_checkout' => '2022-03-06',
                'status_pembayaran' => 'sudah bayar',
                'total_bayar' => 6000000,
            ],
        ];

        Booking::insert($bookings);
    }
}
