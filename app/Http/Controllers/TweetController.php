<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Tweet;
use Illuminate\Http\Request;

class TweetController extends Controller
{
    //
    public function index(Request $request)
    {

        $tweets = Tweet::with(['user:id,username,profile_picture_url', 'media', 'likes'])
            ->withCount('likes')
            ->latest()
            ->paginate(10);

        // Map the liked status for each tweet
        $tweets->through(function ($tweet) use ($request) {
            $tweet->liked = $tweet->likes->contains($request->user()->id);
            return $tweet;
        });

        if ($request->expectsJson()) {
            return response()->json([
                'tweets' => $tweets
            ]);
        }
        return Inertia::render('SocialFeed', [
            'tweets' => $tweets,
        ]);
    }
    public function like(Request $request, Tweet $tweet)
    {
        $user = $request->user();
        $liked = $tweet->likes()->toggle($user->id);
        $likesCount = $tweet->likes()->count();

        return response()->json([
            'liked' => count($liked['attached']) > 0, // True if the like was added
            'likes_count' => $likesCount,
        ]);
    }

    public function show(Request $request, $id)
    {
        $tweet = Tweet::with([
            'user:id,username,profile_picture_url',
            'comments.user:id,username,profile_picture_url',
            'media',
            'likes'
        ])->withCount('likes')
            ->findOrFail($id);

        // Check if the authenticated user has liked the tweet
        $tweet->liked = $tweet->likes->contains($request->user()->id);

        return Inertia::render('Tweet/TweetDetail', [
            'tweet' => $tweet,
        ]);
    }


    public function storeComment(Request $request, $tweetId)
    {
        $request->validate([
            'content' => 'required|string|max:500', // Validate the comment input
        ]);

        $tweet = Tweet::findOrFail($tweetId); // Ensure the tweet exists

        $comment = $tweet->comments()->create([
            'user_id' => $request->user()->id, // Authenticated user
            'content' => $request->input('content'),
        ]);

        $comment->load('user:id,username,profile_picture_url'); // Load user info for frontend

        return response()->json([
            'message' => 'Comment added successfully!',
            'comment' => $comment,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:280',
        ]);

        $tweet = Tweet::create([
            'user_id' => $request->user()->id,
            'content' => $request->input('content'),
        ]);

        // Explicitly load the user with specific fields
        $tweet->setRelation('user', $request->user()->only([
            'id',
            'username',
            'profile_picture_url'
        ]));

        // Return the full tweet data with user information
        return response()->json([
            'tweet' => $tweet,
        ]);
    }
}
