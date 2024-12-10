<?php

namespace Database\Factories;


use App\Models\User;
use App\Models\Tweet;
use Illuminate\Database\Eloquent\Factories\Factory;

class LikeFactory extends Factory
{
    public function definition()
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,  // Use an existing user randomly
            'tweet_id' => Tweet::inRandomOrder()->first()->id,  // Use an existing tweet randomly
        ];
    }
}
