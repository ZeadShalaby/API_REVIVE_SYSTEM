<?php

namespace Database\Factories;

use App\Models\Role;
use App\Models\User;
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
        
        $userids = User::where('role','2')->pluck('id')->toArray();
        $type = array("tourism","coastal");
        $increment = random_int(0,1);
      
        return [
            //
            'name' => $this->faker->regexify('[A-Z]{5}[0-4]{3}'),
            'owner_id' => $this->faker->randomElement($userids),
            'location'=>$this->faker->address,
            'co2'=>fake()->numberBetween($min = 20, $max = 30),
            'o2'=>fake()->numberBetween($min = 15, $max = 25),
            'degree'=>fake()->numberBetween($min = 20, $max = 60),
            'type'=>Role::TOURISM,
        ];
     
    }

    public function coastal()
        {
        return $this->state(function (array $attributes) {
            return [
                'type' => Role::TOURISM,
            ];
        });
        }
    
        public function tourism()
            {
            return $this->state(function (array $attributes) {
                return [
                    'type' => Role::COASTAL,
                ];
            });
            }
}
