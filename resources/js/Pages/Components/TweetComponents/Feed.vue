<template>
    <div class="max-w-3xl mx-auto py-6 px-4">
        <h1 class="text-3xl font-extrabold text-gray-800 mb-6">
            Latest Tweets
        </h1>

        <!-- No tweets available -->
        <div v-if="!tweets.length" class="text-gray-500 text-center">
            No tweets available
        </div>
        <div v-else>
            <!-- Render each tweet -->
            <div
                v-for="tweet in tweets"
                :key="tweet.id"
                class="tweet bg-white p-5 mb-6 border border-gray-200 rounded-lg shadow hover:shadow-lg transition-shadow duration-300"
            >
                <!-- User Info -->
                <div class="flex items-center mb-4">
                    <img
                        :src="tweet.user.profile_picture_url"
                        alt="User profile picture"
                        class="w-12 h-12 rounded-full border-2 border-blue-500 mr-4"
                    />
                    <h3 class="text-lg font-semibold text-gray-800">
                        {{ tweet.user.username || "Anonymous" }}
                    </h3>
                </div>

                <!-- Tweet content -->
                <Link
                    :href="`/tweets/${tweet.id}`"
                    class="block text-gray-700 text-lg leading-relaxed"
                >
                    {{ tweet.content || "No content available" }}
                </Link>

                <!-- Tweet media (if any) -->
                <div v-if="tweet.media?.length" class="mt-4 space-y-2">
                    <img
                        v-for="media in tweet.media"
                        :key="media.id"
                        :src="media.media_url"
                        class="w-full rounded-lg border"
                        alt="Tweet media"
                    />
                </div>

                <!-- Actions -->
                <div
                    class="flex items-center justify-between mt-4 text-sm text-gray-600"
                >
                    <!-- Like button -->
                    <div class="flex items-center">
                        <button
                            @click="likeTweet(tweet)"
                            class="flex items-center space-x-1 text-cyan-500 hover:text-cyan-600 focus:outline-none"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                fill="currentColor"
                                viewBox="0 0 24 24"
                                :class="tweet.liked ? 'text-red-500' : ''"
                            >
                                <path
                                    d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"
                                />
                            </svg>
                            <span>{{ tweet.likes_count || 0 }}</span>
                        </button>
                    </div>

                    <!-- Created at -->
                    <small>
                        {{
                            tweet.created_at
                                ? new Date(tweet.created_at).toLocaleString()
                                : "Unknown date"
                        }}
                    </small>
                </div>
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
        default: () => [],
    },
});

function likeTweet(tweet) {
    tweet.liked = !tweet.liked;
    tweet.likes_count += tweet.liked ? 1 : -1;

    axios
        .post(`/api/tweets/${tweet.id}/like`)
        .then((response) => {
            tweet.liked = response.data.liked;
            tweet.likes_count = response.data.likes_count;
        })
        .catch((error) => {
            console.error("Error liking tweet:", error);
            tweet.liked = !tweet.liked;
            tweet.likes_count += tweet.liked ? 1 : -1;
        });
}
</script>
