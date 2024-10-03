<?php

namespace Database\Factories;

use App\Models\Meja;
use Illuminate\Database\Eloquent\Factories\Factory;

class MejaFactory extends Factory
{
    protected $model = Meja::class;

    public function definition()
    {
        return [
            'nomor_meja' => $this->faker->unique()->randomNumber(),
            'status' => $this->faker->randomElement(['available', 'occupied']),
        ];
    }
}
