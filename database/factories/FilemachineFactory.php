<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Filemachine>
 */
class FilemachineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $img = array("o (1).jfif","o (1).gif","o (1).png","o (4).png","o (5).png","o (16).jpg","o (17).jpg","o (18).jpg","o (19).jpg","o (20).jpg","o (21).jpg","o (22).jpg","o (23).jpg","o (24).jpg","o (25).jpg","o (26).jpg","o (27).jpg","o (28).jpg","o (29).jpg","o (30).jpg","o (31).jpg","o (32).jpg","o (33).jpg","o (34).jpg","o (35).jpg");
        $increment = random_int(0,24);
        $destination_path = '/api/rev/images/reviveimagemachine/';
        $http_address = env('APP_URL','http://127.0.0.1:8000');
        $path = $destination_path.$img[$increment];
        $userids = User::where('role', '>','1')->pluck('id')->toArray();
        return [
            //
            'user_id' => $this->faker->randomElement($userids),
            'file'=>$path,
        ];
    }
}
