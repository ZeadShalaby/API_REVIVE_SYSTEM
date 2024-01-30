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
        $img = array("a (1).jpg","a (2).jpg", "a (3).jpg", "a (4).jpg","a (5).jpg","a (6).jpg","a (7).jpg", "a (8).jpg", "a (9).jpg","a (10).jpg","a (11).jpg","a (12).jpg", "a (13).jpg", "a (14).jpg","a (15).jpg","a (16).jpg","a (17).jpg", "a (18).jpg", "a (19).jpg","a (120).jpg","a (21).jpg","a (22).jpg", "a (23).jpg", "a (24).jpg","a (25).jpg");
        $increment = random_int(0,24);
        $destination_path = env('path_url','/api/rev/images/reviveimageusers/');
        $http_address = env('APP_URL','http://127.0.0.1:8000');
        $path = $http_address.$destination_path.$img[$increment];
        return [
            'name' => fake()->name(),
            'username' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'gmail'=>fake()->unique()->safeEmail(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'phone'=>fake()->numberBetween($min = 123456789, $max = 98561237894),
            'gender' =>fake()->randomElement(['male', 'female']),
            'role' => Role::CUSTOMER,
            'profile_photo'=>$path,
            'Personal_card'=>fake()->numberBetween($min = 10000000000000, $max = 900000000000),
            'birthday' => fake()->dateTimeBetween($startDate = '-30 years', $endDate = 'now', $timezone = null),
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
     * ? Indicate that the model's email address should be unverified.
     */
   
}

