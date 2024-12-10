<?php

namespace Database\Factories;


use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TweetFactory extends Factory
{
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'content' => $this->faker->text(280),
        ];
    }
}
