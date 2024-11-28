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
            ['role' => 'Super Admin',  'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['role' => 'Admin', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['role' => 'Manager', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['role' => 'Staff', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];

        // Insert roles into the database
        DB::table('roles')->insert($roles);
    }
}
