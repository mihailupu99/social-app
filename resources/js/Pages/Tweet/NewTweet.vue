<template>
    <div class="new-tweet-form bg-white p-4 rounded-lg shadow-md mb-4">
        <textarea
            v-model="content"
            class="w-full p-2 border rounded-md"
            placeholder="What's happening?"
            rows="3"
            :disabled="loading"
        ></textarea>

        <button
            @click="submitTweet"
            :disabled="loading || !content.trim()"
            class="mt-2 w-full bg-blue-500 text-white py-2 rounded-md"
        >
            {{ loading ? "Posting..." : "Tweet" }}
        </button>
    </div>
</template>

<script setup>
import { ref } from "vue";
import axios from "axios";
import { usePage } from "@inertiajs/vue3";

const emit = defineEmits(["tweetCreated"]);

const content = ref("");
const loading = ref(false);

const { props } = usePage();
const userId = props.auth?.user?.id;

const submitTweet = async () => {
    if (!content.value.trim()) return;

    if (!userId) {
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
