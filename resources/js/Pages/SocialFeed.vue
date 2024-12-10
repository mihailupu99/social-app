<template>
    <FrontPageLayout>
        <div class="max-w-xl mx-auto">
            <!-- New Tweet Component -->
            <NewTweet @tweet-created="prependTweet" />

            <!-- Feed Component -->
            <Feed
                :tweets="allTweets"
                @delete-tweet="removeTweet"
                @update-tweet="updateTweet"
            />

            <!-- Infinite Loading Component -->
            <InfiniteLoading
                v-if="allTweets.length > 0"
                @infinite="loadMoreTweets"
                spinner="waveDots"
                :identifier="'tweets-feed'"
            >
                <template #no-more>
                    <p class="text-gray-500 text-center mt-4">
                        No more tweets to load.
                    </p>
                </template>
                <template #error="{ retry }">
                    <div class="text-center mt-4">
                        <p class="text-red-500 mb-2">Failed to load tweets.</p>
                        <button
                            @click="retry"
                            class="bg-blue-500 text-white px-4 py-2 rounded"
                        >
                            Retry
                        </button>
                    </div>
                </template>
            </InfiniteLoading>

            <!-- No Tweets Message -->
            <div
                v-if="allTweets.length === 0 && !loading"
                class="text-center text-gray-500 mt-10"
            >
                <p>No tweets found. Be the first to tweet!</p>
            </div>

            <!-- Loading Indicator -->
            <div v-if="loading" class="flex justify-center items-center mt-10">
                <div
                    class="animate-spin rounded-full h-8 w-8 border-t-2 border-blue-500"
                ></div>
            </div>
        </div>
    </FrontPageLayout>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { usePage } from "@inertiajs/vue3";
import axios from "axios";
import InfiniteLoading from "v3-infinite-loading";
import "v3-infinite-loading/lib/style.css";

// Import components
import FrontPageLayout from "../Layouts/FrontPageLayout.vue";
import NewTweet from "./Tweet/NewTweet.vue";
import Feed from "./Components/TweetComponents/Feed.vue";

// Reactive state
const allTweets = ref([]);
const currentPage = ref(1);
const hasMorePages = ref(true);
const loading = ref(true);

// Get initial tweets from Inertia props
const initialTweets = usePage().props.tweets;

// Lifecycle hook to initialize tweets
onMounted(() => {
    if (initialTweets && initialTweets.data) {
        allTweets.value = initialTweets.data;
        currentPage.value = initialTweets.current_page;
        hasMorePages.value =
            initialTweets.current_page < initialTweets.last_page;
        loading.value = false;
    }
});

// Add a new tweet to the top of the list
const prependTweet = (newTweet) => {
    // Get the current authenticated user
    const currentUser = usePage().props.auth.user;

    // Ensure the new tweet has all necessary data
    const completeNewTweet = {
        ...newTweet,
        user: {
            id: currentUser.id,
            username: currentUser.username,
            profile_picture_url: currentUser.profile_picture_url,
        },
        liked: false,
        likes_count: 0,
        created_at: new Date().toISOString(),
    };

    allTweets.value.unshift(completeNewTweet);
};

// Remove a tweet from the list
const removeTweet = (tweetId) => {
    allTweets.value = allTweets.value.filter((tweet) => tweet.id !== tweetId);
};

// Update an existing tweet
const updateTweet = (updatedTweet) => {
    const index = allTweets.value.findIndex(
        (tweet) => tweet.id === updatedTweet.id
    );
    if (index !== -1) {
        allTweets.value[index] = {
            ...allTweets.value[index],
            ...updatedTweet,
        };
    }
};

// Load more tweets on scroll
const loadMoreTweets = async ($state) => {
    // If no more pages, complete the state
    if (!hasMorePages.value) {
        $state.complete();
        return;
    }

    try {
        loading.value = true;
        const nextPage = currentPage.value + 1;

        // Fetch next page of tweets
        const response = await axios.get(`/feed?page=${nextPage}`);
        const newTweets = response.data.tweets.data || [];

        // Add new tweets to existing list
        allTweets.value.push(...newTweets);

        // Update pagination state
        currentPage.value = response.data.tweets.current_page;
        hasMorePages.value =
            response.data.tweets.current_page < response.data.tweets.last_page;

        // Inform infinite loading
        $state.loaded();
    } catch (error) {
        console.error("Error loading tweets:", error);
        $state.error();
    } finally {
        loading.value = false;
    }
};
</script>
