<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'content',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function likes()
    // {
    //     return $this->hasMany(Like::class, 'tweet_id');
    // }

    ///////////////////////
    public function likes()
    {
        return $this->belongsToMany(User::class, 'likes')->withTimestamps();
    }
    ///////////////////////

    public function retweets()
    {
        return $this->hasMany(Retweet::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function media()
    {
        return $this->hasMany(Media::class);
    }

    public function hashtags()
    {
        return $this->belongsToMany(Hashtag::class, 'tweet_hashtags');
    }
}
