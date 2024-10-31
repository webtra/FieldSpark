<?php

namespace Database\Seeders;

use App\Models\Crops;
use App\Models\Cultivars;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CropsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure there are cultivars to associate with crops
        if (Cultivars::count() === 0) {
            $this->command->info('No cultivars found, seeding aborted.');
            return;
        }

        // Get all cultivar IDs
        $cultivarIds = Cultivars::pluck('id')->toArray();

        // Seed 20 fake crops
        Crops::factory()->count(20)->create([
            'cultivar_id' => function() use ($cultivarIds) {
                return $cultivarIds[array_rand($cultivarIds)];
            },
            'block_number' => fn () => 'Block ' . chr(rand(65, 90)), // Example: Block A, Block B, etc.
            'planting_date' => fn () => Carbon::now()->subDays(rand(30, 365)),
            'harvest_date' => fn () => rand(0, 1) ? Carbon::now()->addDays(rand(30, 365)) : null,
            'location' => fn () => 'Field ' . rand(1, 10),
            'status' => fn () => ['planted', 'growing', 'harvested', 'failed'][array_rand(['planted', 'growing', 'harvested', 'failed'])],
            'size' => fn () => rand(100, 500),
        ]);
    }
}
