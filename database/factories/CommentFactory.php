<?php

namespace Database\Factories;


use App\Models\User;
use App\Models\Tweet;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    public function definition()
    {
        return [
            'tweet_id' => Tweet::factory(),
            'user_id' => User::factory(),
            'content' => $this->faker->sentence,
        ];
    }
}
