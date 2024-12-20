<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hashtag extends Model
{
    use HasFactory;

    protected $fillable = [
        'hashtag',
    ];

    public function tweets()
    {
        return $this->belongsToMany(Tweet::class, 'tweet_hashtags');
    }
}
