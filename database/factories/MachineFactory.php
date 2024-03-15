<?php

namespace Database\Factories;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Machine>
 */
class MachineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userids = User::where('role','2')->pluck('id')->toArray();

        return [
            //
            'name' => strtolower($this->faker->regexify('[A-Z]{5}[0-4]{3}')),
            'owner_id' => $this->faker->randomElement($userids),
            'location'=>$this->faker->address,
            'type'=>Role::REVIVE,
        ];
    }

    public function revive()
    {
    return $this->state(function (array $attributes) {
        return [
            
            'type' => Role::REVIVE,
        ];
    });
    }

        
    public function coastal()
    {
    return $this->state(function (array $attributes) {
        return [
            'type' => Role::COASTAL,
        ];
    });
    }

    public function tourism()
        {
        return $this->state(function (array $attributes) {
            return [
                'type' => Role::TOURISM,
            ];
        });
    }

}
