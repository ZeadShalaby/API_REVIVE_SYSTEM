<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => 'password', // password
            'role' => Role::CUSTOMER,
            'email_verified_at' => now(),

          /*
           todo 'gmail'=>fake()->unique()->safeEmail(),
           todo  'phone'=>fake()->numberBetween($min = 123456789, $max = 98561237894),
           todo 'profile_photo'=>fake()->imageUrl($width=400, $height=400),
          */
        ];
    }

    public function admin()
        {
        return $this->state(function (array $attributes) {
            return [
                
                'role' => Role::ADMIN,
            ];
        });
        }

        
    public function OWNER()
    {
    return $this->state(function (array $attributes) {
        return [
            'role' => Role::OWNER,
        ];
    });
    }

    public function CUSTOMER()
        {
        return $this->state(function (array $attributes) {
            return [
                'role' => Role::CUSTOMER,
            ];
        });
        }

    /**
     * Indicate that the model's email address should be unverified.
     */
   
}

