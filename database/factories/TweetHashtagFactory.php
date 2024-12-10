<?php

namespace Database\Factories;


use App\Models\Tweet;
use App\Models\Hashtag;
use Illuminate\Database\Eloquent\Factories\Factory;

class TweetHashtagFactory extends Factory
{
    public function definition()
    {
        return [
            'tweet_id' => Tweet::factory(),
            'hashtag_id' => Hashtag::factory(),
        ];
    }
}
