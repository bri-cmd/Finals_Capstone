<?php

namespace Database\Seeders;

use App\Models\UserBuild;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserBuildSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserBuild::factory()->count(10)->create();
    }
}
