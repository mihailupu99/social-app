<?php

namespace Database\Factories;


use App\Models\Tweet;
use Illuminate\Database\Eloquent\Factories\Factory;

class MediaFactory extends Factory
{
    public function definition()
    {
        return [
            'tweet_id' => Tweet::factory(),
            'media_url' => 'https://picsum.photos/640/480?random=' . $this->faker->unique()->numberBetween(1, 1000),
            'media_type' => 'image', // Ensure only images are generated
        ];
    }
}
