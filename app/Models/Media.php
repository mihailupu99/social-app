<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'tweet_id',
        'media_url',
        'media_type',
    ];

    public function tweet()
    {
        return $this->belongsTo(Tweet::class);
    }
}
