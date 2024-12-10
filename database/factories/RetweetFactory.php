<?php

namespace Database\Factories;


use App\Models\User;
use App\Models\Tweet;
use Illuminate\Database\Eloquent\Factories\Factory;

class RetweetFactory extends Factory
{
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'tweet_id' => Tweet::factory(),
        ];
    }
}
