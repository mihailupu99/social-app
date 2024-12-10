<script setup>
import { ref } from "vue";
import axios from "axios";

// Layout
import FrontPageLayout from "../../Layouts/FrontPageLayout.vue";

// Props
const props = defineProps({
    tweet: Object, // Declare the `tweet` prop
});

// Reactive references
const comments = ref(props.tweet.comments || []); // Initialize comments from props
const newComment = ref("");
const loading = ref(false);
const liked = ref(props.tweet.liked);
const likesCount = ref(props.tweet.likes_count);

// Toggle like functionality
const toggleLike = async () => {
    try {
        const response = await axios.post(`/api/tweets/${props.tweet.id}/like`);
        liked.value = response.data.liked;
        likesCount.value = response.data.likes_count;
    } catch (error) {
        console.error(error);
    }
};

// Post a new comment
const postComment = async () => {
    if (!newComment.value.trim()) return;

    loading.value = true;
    try {
        const response = await axios.post(
            `/api/tweets/${props.tweet.id}/comments`,
            {
                content: newComment.value,
            }
        );
        comments.value.push(response.data.comment); // Add the new comment to the list
        newComment.value = ""; // Clear the input
    } catch (error) {
        console.error(error);
    } finally {
        loading.value = false;
    }
};
</script>

<template>
    <FrontPageLayout>
        <div
            class="tweet-detail bg-white shadow-lg rounded-lg p-6 max-w-2xl mx-auto"
        >
            <!-- Tweet Header -->
            <div class="tweet-header flex items-center gap-4 mb-4">
                <img
                    :src="props.tweet.user.profile_picture_url"
                    alt="Profile Picture"
                    class="w-14 h-14 rounded-full border-2 border-blue-500"
                />
                <h1 class="text-lg font-bold text-gray-800">
                    {{ props.tweet.user.username }}
                </h1>
            </div>

            <!-- Tweet Content -->
            <div class="tweet-content mb-4">
                <p class="text-gray-700 leading-relaxed">
                    {{ props.tweet.content }}
                </p>
            </div>

            <!-- Tweet Media -->
            <div v-if="props.tweet.media.length" class="tweet-media my-4">
                <img
                    v-for="media in props.tweet.media"
                    :key="media.id"
                    :src="media.url"
                    alt="Tweet Media"
                    class="w-full rounded-lg mb-2 border"
                />
            </div>

            <!-- Like Button -->
            <div class="tweet-actions flex items-center gap-4 my-4">
                <button
                    @click="toggleLike"
                    class="flex items-center gap-1 text-gray-500 hover:text-red-500 focus:outline-none"
                >
                    <i
                        class="fas fa-heart text-xl"
                        :class="{ 'text-red-500': liked }"
                    ></i>
                    <span class="text-gray-700 font-medium">
                        {{ likesCount }} Likes
                    </span>
                </button>
            </div>

            <!-- Comments Section -->
            <div class="comments my-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">
                    Comments
                </h2>
                <div
                    v-for="comment in comments"
                    :key="comment.id"
                    class="comment bg-gray-50 p-4 rounded-lg shadow-sm mb-4"
                >
                    <div class="flex items-center gap-3 mb-2">
                        <img
                            :src="comment.user.profile_picture_url"
                            alt="Profile Picture"
                            class="w-10 h-10 rounded-full"
                        />
                        <p class="font-bold text-gray-700">
                            {{ comment.user.username }}
                        </p>
                    </div>
                    <p class="text-gray-600 ml-12">{{ comment.content }}</p>
                </div>
            </div>

            <!-- Add Comment Form -->
            <div class="add-comment mt-4">
                <textarea
                    v-model="newComment"
                    class="border border-gray-300 p-3 w-full rounded-lg focus:outline-none focus:ring focus:ring-blue-300"
                    placeholder="Write a comment..."
                    rows="3"
                ></textarea>
                <button
                    @click="postComment"
                    :disabled="loading"
                    class="bg-cyan-500 hover:bg-cyan-600 text-white px-4 py-2 rounded-lg mt-2 disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    {{ loading ? "Posting..." : "Post Comment" }}
                </button>
            </div>
        </div>
    </FrontPageLayout>
</template>

<style scoped>
.tweet-detail {
    max-width: 700px;
    margin: auto;
}
.comment {
    margin-bottom: 1rem;
}
</style>
