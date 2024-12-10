<template>
    <div>
        <h1 class="text-2xl font-bold mb-4">Latest Tweets</h1>
        <!-- No tweets available -->
        <div v-if="!tweets.length" class="text-gray-500">
            No tweets available
        </div>
        <div v-else>
            <!-- Render each tweet -->
            <div
                v-for="tweet in tweets"
                :key="tweet.id"
                class="tweet p-4 mb-4 border rounded shadow"
            >
                <div class="flex items-center mb-2">
                    <!-- Defensive check for user data -->
                    <img
                        :src="
                            tweet.user?.profile_picture_url ||
                            '/default-profile-picture.png'
                        "
                        alt="User profile picture"
                        class="w-10 h-10 rounded-full mr-3"
                    />
                    <h3 class="text-xl font-semibold">
                        {{ tweet.user.username || "Anonymous" }}
                    </h3>
                </div>

                <!-- Tweet content -->
                <Link :href="`/tweets/${tweet.id}`">
                    <p class="mt-2 text-gray-700">
                        {{ tweet.content || "No content available" }}
                    </p>
                </Link>

                <!-- Tweet media (if any) -->
                <div v-if="tweet.media?.length">
                    <img
                        v-for="media in tweet.media"
                        :key="media.id"
                        :src="media.media_url"
                        class="mt-2 w-full rounded"
                        alt="Tweet media"
                    />
                </div>

                <!-- Like button -->
                <button @click="likeTweet(tweet)">
                    {{ tweet.liked ? "Unlike" : "Like" }}
                </button>
                <p>Likes: {{ tweet.likes_count || 0 }}</p>

                <!-- Created at -->
                <small class="text-gray-500">{{
                    tweet.created_at
                        ? new Date(tweet.created_at).toLocaleString()
                        : "Unknown date"
                }}</small>
            </div>
        </div>
    </div>
</template>

<script setup>
import { defineProps } from "vue";
import axios from "axios";

defineProps({
    tweets: {
        type: Array,
        required: true,
        default: () => [], // Ensure default is an empty array
    },
});

// Function to like a tweet
function likeTweet(tweet) {
    axios
        .post(`/api/tweets/${tweet.id}/like`)
        .then((response) => {
            tweet.liked = response.data.liked; // Update "liked" state
            tweet.likes_count = response.data.likes_count; // Update likes count
        })
        .catch((error) => {
            console.error("Error liking tweet:", error);
        });
}
</script>
