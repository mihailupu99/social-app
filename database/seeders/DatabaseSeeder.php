<?php

namespace Database\Seeders;

use App\Models\Like;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Media;
use App\Models\Tweet;
use App\Models\Comment;
use App\Models\Hashtag;
use App\Models\Retweet;
use App\Models\Follower;
use App\Models\Notification;
use App\Models\TweetHashtag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Truncate tables
        User::truncate();
        Tweet::truncate();
        Follower::truncate();
        Like::truncate();
        Retweet::truncate();
        Comment::truncate();
        Media::truncate();
        Notification::truncate();
        Hashtag::truncate();
        TweetHashtag::truncate();

        // Enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Seed the data
        User::factory(10)->create();
        Tweet::factory(20)->create();
        Follower::factory(10)->create();
        Like::factory(200)->create();
        Retweet::factory(20)->create();
        Comment::factory(30)->create();
        Media::factory(10)->create();
        Notification::factory(20)->create();
        Hashtag::factory(8)->create();
        TweetHashtag::factory(20)->create();
    }
}
