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
        <div class="tweet-detail">
            <!-- Tweet Header -->
            <div class="tweet-header flex items-center gap-4">
                <img
                    :src="props.tweet.user.profile_picture_url"
                    alt="Profile Picture"
                    class="w-12 h-12 rounded-full"
                />
                <h1 class="text-lg font-bold">
                    {{ props.tweet.user.username }}
                </h1>
            </div>

            <!-- Tweet Content -->
            <div class="tweet-content my-4">
                <p>{{ props.tweet.content }}</p>
            </div>

            <!-- Tweet Media -->
            <div v-if="props.tweet.media.length" class="tweet-media my-4">
                <img
                    v-for="media in props.tweet.media"
                    :key="media.id"
                    :src="media.url"
                    alt="Tweet Media"
                    class="w-full rounded"
                />
            </div>

            <!-- Like Button -->
            <div class="tweet-actions flex items-center gap-4">
                <button @click="toggleLike">
                    <i :class="liked ? 'text-red-500' : 'text-gray-500'">♥</i>
                </button>
                <span>{{ likesCount }} Likes</span>
            </div>

            <!-- Comments Section -->
            <div class="comments my-6">
                <h2 class="text-xl font-semibold mb-4">Comments</h2>
                <div
                    v-for="comment in comments"
                    :key="comment.id"
                    class="comment"
                >
                    <div class="flex items-center gap-2">
                        <img
                            :src="comment.user.profile_picture_url"
                            alt="Profile Picture"
                            class="w-8 h-8 rounded-full"
                        />
                        <p class="font-bold">{{ comment.user.username }}</p>
                    </div>
                    <p class="ml-10">{{ comment.content }}</p>
                </div>
            </div>

            <!-- Add Comment Form -->
            <div class="mt-4">
                <textarea
                    v-model="newComment"
                    class="border p-2 w-full rounded-md"
                    placeholder="Write a comment..."
                    rows="3"
                ></textarea>
                <button
                    @click="postComment"
                    :disabled="loading"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md mt-2"
                >
                    {{ loading ? "Posting..." : "Post Comment" }}
                </button>
            </div>
        </div>
    </FrontPageLayout>
</template>

<style scoped>
.tweet-detail {
    max-width: 600px;
    margin: auto;
}
.comment {
    margin-bottom: 1rem;
}
</style>
