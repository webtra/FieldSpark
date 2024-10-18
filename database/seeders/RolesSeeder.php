<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define the roles
        $roles = [
            ['role' => 'Administrator',  'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['role' => 'Staff', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['role' => 'Viewer', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];

        // Insert roles into the database
        DB::table('roles')->insert($roles);
    }
}
