<?php

namespace Database\Seeders;

use App\Models\Villa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class VillaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $villas = [
            [
                'uuid' => Str::uuid(),
                'nama_villa' => 'Villa 1',
                'alamat' => 'Jl. Raya',
                'deskripsi' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'foto' => 'villa1.jpg',
                'harga_sewa' => 50000,
            ],
        ];

        Villa::insert($villas);
    }
}
