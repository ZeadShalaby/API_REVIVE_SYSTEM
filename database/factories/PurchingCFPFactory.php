<?php

namespace Database\Factories;

use App\Models\Machine;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PurchingCFP>
 */
class PurchingCFPFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $machineid = Machine::pluck('id')->toArray();
        $text = array("month","week", "day");
        $increment = random_int(0,2);
        $time = $text[$increment];
        return [
            'machine_seller_id' => $this->faker->randomElement($machineid),          
            'machine_buyer_id' => $this->faker->randomElement($machineid),
            'carbon_footprint' => fake()->numberBetween($min = 20, $max = 100),
            'expire' => fake()->numberBetween($min = 1, $max = 12),
            'time' => $time,

        ];
    }
}
