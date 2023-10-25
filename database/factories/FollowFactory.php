<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Follow>
 */
class FollowFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $followers = User::where('role', '>','1')->pluck('id')->toArray();
        $following = User::where('role', '>','1')->pluck('id')->toArray();

        return [
            'following_id' => $this->faker->randomElement($followers),          
            'followers_id' => $this->faker->randomElement($following),
        ];
    }
}
