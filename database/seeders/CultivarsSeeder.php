<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CultivarsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create();
        $growthSeasons = ['spring', 'summer', 'autumn', 'winter'];
        $soilTypes = ['sandy', 'clay', 'loamy', 'peaty', 'chalky', 'silty'];

        $cultivars = [];
        for ($i = 0; $i < 20000; $i++) {
            $cultivars[] = [
                'code' => $faker->unique()->regexify('[A-Z]{2}[0-9]{4}'),
                'name' => $faker->words(2, true),
                'growth_season' => $faker->randomElement($growthSeasons),
                'maturity_days' => $faker->optional()->numberBetween(60, 200),
                'yield_potential' => $faker->optional()->randomFloat(2, 1.0, 10.0),
                'water_requirements' => $faker->optional()->numberBetween(200, 1000),
                'soil_type' => $faker->optional()->randomElement($soilTypes),
                'plant_spacing' => $faker->optional()->randomFloat(2, 0.1, 2.0),
                'root_depth' => $faker->optional()->numberBetween(10, 200),
                'notes' => $faker->optional()->sentence(10),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert in chunks to handle large data efficiently
        $chunks = array_chunk($cultivars, 1000);
        foreach ($chunks as $chunk) {
            DB::table('cultivars')->insert($chunk);
        }
    }
}
