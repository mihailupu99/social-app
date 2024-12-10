<template>
    <div class="new-tweet-form bg-white p-4 rounded-lg shadow-md mb-4">
        <!-- User Info -->
        <div class="flex items-center mb-4">
            <img
                :src="user.profile_picture_url || '/default-profile.png'"
                alt="User Profile"
                class="w-12 h-12 rounded-full mr-4"
            />
            <div>
                <h3 class="text-lg font-bold">{{ user.username }}</h3>
                <p class="text-gray-500">{{ user.email }}</p>
            </div>
        </div>

        <!-- Tweet Content -->
        <textarea
            v-model="content"
            class="w-full p-2 border rounded-md"
            placeholder="What's happening?"
            rows="3"
            :disabled="loading"
        ></textarea>

        <!-- Tweet Button -->
        <button
            @click="submitTweet"
            :disabled="loading || !content.trim()"
            class="mt-2 w-full bg-cyan-500 text-white py-2 rounded-md"
        >
            {{ loading ? "Posting..." : "Tweet" }}
        </button>
    </div>
</template>

<script setup>
import { ref } from "vue";
import axios from "axios";
import { usePage } from "@inertiajs/vue3";

// Emit event to notify parent component about the new tweet
const emit = defineEmits(["tweetCreated"]);

// Tweet content and loading state
const content = ref("");
const loading = ref(false);

// User data from the Inertia.js page props
const { props } = usePage();
const user = props.auth?.user;

// Submit tweet function
const submitTweet = async () => {
    if (!content.value.trim()) return;

    if (!user) {
        console.error("Error: User is not authenticated.");
        return;
    }

    loading.value = true;

    try {
        const response = await axios.post("/tweets", {
            content: content.value,
        });

        // Emit the new tweet to the parent component
        emit("tweetCreated", response.data.tweet);

        // Clear content
        content.value = "";
    } catch (error) {
        console.error("Error creating tweet:", error);
    } finally {
        loading.value = false;
    }
};
</script>
