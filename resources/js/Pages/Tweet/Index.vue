<template>
    <div>
        <h1>Latest Tweets</h1>
        <div v-if="!tweets.length">No tweets available</div>
        <div v-else>
            <div v-for="tweet in tweets" :key="tweet.id" class="tweet">
                <h3>{{ tweet.user.username }}</h3>
                <p>{{ tweet.content }}</p>
                <small>{{ new Date(tweet.created_at).toLocaleString() }}</small>
            </div>
        </div>
    </div>
</template>

<script setup>
import { defineProps } from "vue";

const props = defineProps({
    tweets: {
        type: Array,
        required: true,
        default: () => [],
    },
});
</script>

<style scoped>
.tweet {
    border: 1px solid #e2e2e2;
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 5px;
}
</style>
