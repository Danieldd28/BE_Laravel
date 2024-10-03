<?php

namespace Database\Factories;

use App\Models\Transaksi;
use App\Models\User;
use App\Models\Meja;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransaksiFactory extends Factory
{
    protected $model = Transaksi::class;

    public function definition()
    {
        return [
            'tgl_transaksi' => $this->faker->dateTimeThisYear(),
            'id_user' => User::factory(), // Assuming you have a User factory
            'id_meja' => Meja::factory(), // Assuming you have a Meja factory
            'nama_pelanggan' => $this->faker->name(),
            'status' => $this->faker->randomElement(['belum_bayar', 'lunas']),
        ];
    }
}
    