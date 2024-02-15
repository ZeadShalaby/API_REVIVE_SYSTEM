<?php

namespace Database\Factories;

use App\Models\Machine;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class footprintfactoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $machinesid = Machine::pluck('id')->toArray();
        return [
            'machine_id' => $this->faker->randomElement($machinesid),
            'carbon_footprint'=>fake()->numberBetween($min = 20, $max = 100),
        ];
    }
}
