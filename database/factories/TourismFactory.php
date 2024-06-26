<?php

namespace Database\Factories;

use App\Models\Role;
use App\Models\User;
use App\Models\Machine;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tourism>
 */
class TourismFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        
        $machineids = Machine::where('type','!=','6')->pluck('id')->toArray();

        return [
            //
            'machine_id' => $this->faker->randomElement($machineids),
            'co2'=>fake()->numberBetween($min = 0.0001, $max = 0.9),
            'co'=>fake()->numberBetween($min = 0.0001, $max = 0.9),
            'o2'=>fake()->numberBetween($min = 15, $max = 25),
            'degree'=>fake()->numberBetween($min = 20, $max = 60),
            'humidity'=>fake()->numberBetween($min = 20, $max = 60),
        ];
     
    }

    
}
