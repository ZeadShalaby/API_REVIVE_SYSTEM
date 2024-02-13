<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userids = User::where('role', '2')->pluck('id')->toArray();
        $img = array("a (1).jfif","a (1).gif","a (1).png","a (4).png","a (5).png","a (16).jpg","a (17).jpg","a (18).jpg","a (19).jpg","a (20).jpg","a (21).jpg","a (22).jpg","a (23).jpg","a (24).jpg","a (25).jpg","a (26).jpg","a (27).jpg","a (28).jpg","a (29).jpg","a (30).jpg","a (31).jpg","a (32).jpg","a (33).jpg","a (34).jpg","a (35).jpg");
        $increment = random_int(0,24);
        $destination_path = '/api/rev/images/reviveimageposts/';
        $http_address = env('APP_URL','http://127.0.0.1:8000');
        $path = $destination_path.$img[$increment];
        return [
            'description'=>fake()->text(),
            'user_id' => $this->faker->randomElement($userids),
            'path'=>$path,
            'view'=>null,
        ];
    }
}
