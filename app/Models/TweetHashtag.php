<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TweetHashtag extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'tweet_id',
        'hashtag_id',
    ];

    public function tweet()
    {
        return $this->belongsTo(Tweet::class);
    }

    public function hashtag()
    {
        return $this->belongsTo(Hashtag::class);
    }
}
