<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\UserBuild;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderedBuild>
 */
class OrderedBuildFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'user_build_id' => UserBuild::inRandomOrder()->first()->id,
            'status' => fake()->randomElement(['Pending','Approved']),
            'user_id' => User::whereIn('role', ['Admin', 'Staff'])->inRandomOrder()->first()->id,
            'payment_status' => fake()->randomElement(['Unpaid','Paid']),
            'payment_method' => fake()->randomElement(['Paypal', 'Cash']),
            'pickup_status' => fake()->randomElement(['Pending', 'Picked up']),
        ];
    }
}
