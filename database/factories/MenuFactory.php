<?php

namespace Database\Factories;

use App\Models\Menu;
use Illuminate\Database\Eloquent\Factories\Factory;

class MenuFactory extends Factory
{
    protected $model = Menu::class;

    public function definition()
    {
        return [
            'nama_menu' => $this->faker->word,
            'jenis' => $this->faker->randomElement(['makanan', 'minuman']),
            'harga' => $this->faker->numberBetween(5000, 50000),
        ];
    }
}
