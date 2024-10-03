<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Meja;

class MejaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Make sure the correct column name is used (id_meja, not id)
        Meja::create([
            'id_meja' => 1, // Use 'id_meja', not 'id'
            'nomor_meja' => 1,
            'status' => 'available',
        ]);

        Meja::create([
            'id_meja' => 2,
            'nomor_meja' => 2,
            'status' => 'occupied',
        ]);

        // Add more Mejas as needed
    }
}
