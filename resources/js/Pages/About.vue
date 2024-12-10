<template>
    <app-layout>
        <Head :title="` | ${$page.component}`" />

        <div class="faq-container max-w-4xl mx-auto py-8 px-4">
            <h3 class="text-3xl font-extrabold text-center text-gray-800 mb-6">
                Frequently Asked Questions
            </h3>
            <div class="space-y-4">
                <div
                    v-for="item in faqs"
                    :key="item.id"
                    class="faq-item bg-white shadow-md rounded-lg overflow-hidden"
                >
                    <button
                        @click="toggleFaq(item.id)"
                        class="flex justify-between items-center w-full p-4 bg-teal-500 text-white font-semibold focus:outline-none"
                    >
                        <span>{{ item.question }}</span>
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6 transition-transform duration-300"
                            :class="{ 'rotate-180': item.open }"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M19 9l-7 7-7-7"
                            />
                        </svg>
                    </button>
                    <p
                        v-if="item.open"
                        class="p-4 text-gray-700 bg-gray-100 border-t border-gray-200"
                    >
                        {{ item.answer }}
                    </p>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script setup>
import { reactive } from "vue";
import FrontPageLayout from "../Layouts/FrontPageLayout.vue";

defineOptions({
    layout: FrontPageLayout,
});

const faqs = reactive([
    {
        id: 1,
        question: "What is your mission?",
        answer: "To make the world a better place.",
        open: false,
    },
    {
        id: 2,
        question: "Where are you located?",
        answer: "San Francisco, USA.",
        open: false,
    },
    {
        id: 3,
        question: "How can I contact support?",
        answer: "You can contact us via email at support@example.com.",
        open: false,
    },
    {
        id: 4,
        question: "What services do you offer?",
        answer: "We offer web development, app development, and design services.",
        open: false,
    },
]);

const toggleFaq = (id) => {
    const faq = faqs.find((item) => item.id === id);
    faq.open = !faq.open;
};
</script>
