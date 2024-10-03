<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'nama_user' => $this->faker->name,
            'username' => $this->faker->unique()->userName,
            'password' => Hash::make('password'), // Default password for testing
            'role' => $this->faker->randomElement(['admin', 'kasir', 'manajer']),
        ];
    }
}
