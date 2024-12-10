<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Tweet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    //
    public function toggle(Tweet $tweet)
    {
        // Use Auth::user() or request()->user()
        $user = Auth::user(); // or $user = request()->user();

        if ($user === null) {
            return back()->withErrors('You must be logged in to like a tweet');
        }

        $existingLike = $tweet->likes()->where('user_id', $user->id)->first();

        if ($existingLike) {
            // Unlike
            $existingLike->delete();
        } else {
            // Like
            $tweet->likes()->create([
                'user_id' => $user->id
            ]);
        }

        return back();
    }
}
