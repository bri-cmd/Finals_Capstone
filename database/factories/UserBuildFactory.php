<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserBuild>
 */
class UserBuildFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'build_name' => fake()->word(),
            'case_id' => fake()->word(),
            'mobo_id' => fake()->word(),
            'cpu_id' => fake()->word(),
            'gpu_id' => fake()->word(),
            'storage_id' => fake()->word(),
            'ram_id' => fake()->word(),
            'psu_id' => fake()->word(),
            'total_price' => fake()->randomFloat(2,1000,50000),
            'status' => 'Saved',
        ];
    }
}
