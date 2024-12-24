<?php

namespace Database\Seeders;

use App\Models\Subscriptions;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Subscriptions::create([
            'name' => 'Standard Plan',
            'max_users' => 5,
            'max_teams' => 1,
            'additional_user_charge' => 100.00,
            'additional_team_charge' => 150.00,
        ]);

        // User::factory(10)->withPersonalTeam()->create();

//        User::factory()->withPersonalTeam()->create([
//            'name' => 'Test User',
//            'email' => 'test@example.com',
//        ]);
    }
}
