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
            ['roles' => 'Admin',  'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['roles' => 'Editor', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['roles' => 'Viewer', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['roles' => 'User',   'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];

        // Insert roles into the database
        DB::table('roles')->insert($roles);
    }
}
