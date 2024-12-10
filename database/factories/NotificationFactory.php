<?php

namespace Database\Factories;


use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotificationFactory extends Factory
{
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'type' => $this->faker->randomElement(['follow', 'like', 'comment', 'retweet']),
            'message' => $this->faker->sentence,
            'read' => $this->faker->boolean,
        ];
    }
}
