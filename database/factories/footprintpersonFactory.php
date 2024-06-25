<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class footprintpersonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userids = User::pluck('id')->toArray();

        return [
            'user_id' => $this->faker->randomElement($userids),
            'carbon_footprint'=>fake()->numberBetween($min = 9, $max = 100),
        ];
    }
}
