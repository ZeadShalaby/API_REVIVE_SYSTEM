<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $postsid = Post::pluck('id')->toArray();
        $userids = User::where('role','>','1')->pluck('id')->toArray();

        return [
            'posts_id' => $this->faker->randomElement($postsid),          
            'user_id' => $this->faker->randomElement($userids),
            'comment' =>fake()->text(),
        ];
    }
}
