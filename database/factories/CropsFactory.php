<?php

namespace Database\Factories;

use App\Models\Crops;
use App\Models\Cultivars;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Crops>
 */
class CropsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Crops::class;

    public function definition(): array
    {
        return [
            'cultivar_id' => Cultivars::inRandomOrder()->first()->id,
            'block_number' => 'Block ' . $this->faker->randomLetter(),
            'planting_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'harvest_date' => $this->faker->optional()->dateTimeBetween('now', '+1 year'),
            'location' => 'Field ' . $this->faker->numberBetween(1, 10),
            'status' => $this->faker->randomElement(['planted', 'growing', 'harvested', 'failed']),
            'size' => $this->faker->numberBetween(100, 500),
        ];
    }
}
