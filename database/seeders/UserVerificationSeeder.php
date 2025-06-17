<?php

namespace Database\Seeders;

use App\Models\UserVerification;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserVerificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // how many data to generate
        UserVerification::factory()->count(10)->create();
    }
}
