<template>
    <FrontPageLayout>
        <div
            class="settings-page max-w-7xl mx-auto p-6 bg-white shadow-md rounded-lg"
        >
            <!-- Header -->
            <h1 class="text-3xl font-semibold mb-4 text-gray-800">
                Profile Settings
            </h1>

            <!-- Main Content Section with Two-Column Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Left Section: User Information & Profile -->
                <div
                    class="profile-card bg-gray-50 border border-gray-200 rounded-lg p-4 flex items-center"
                >
                    <!-- Avatar -->
                    <div
                        class="avatar-container flex justify-center items-center w-1/3"
                    >
                        <div
                            class="rounded-full bg-gray-200 w-24 h-24 flex items-center justify-center"
                        >
                            <img
                                :src="user.profile_picture_url"
                                alt=""
                                class="rounded-full bg-gray-200 w-24 h-24 flex items-center justify-center"
                            />
                        </div>
                    </div>
                    <!-- User Info -->
                    <div class="user-info ml-4 w-2/3">
                        <h2 class="text-lg font-semibold text-gray-800">
                            {{ form.email }}
                        </h2>
                        <p class="text-sm text-gray-600">User Email</p>
                    </div>
                </div>

                <!-- Right Section: Forms -->
                <div class="forms-container space-y-6">
                    <!-- Password Update Form -->
                    <div
                        class="password-update bg-gray-50 border border-gray-200 rounded-lg p-4 shadow-sm"
                    >
                        <h2 class="text-lg font-semibold text-gray-700 mb-2">
                            Change Password
                        </h2>
                        <form
                            @submit.prevent="updateSettings"
                            class="space-y-4"
                        >
                            <div>
                                <label
                                    for="password"
                                    class="block text-sm text-gray-600"
                                    >New Password</label
                                >
                                <input
                                    id="password"
                                    v-model="form.password"
                                    type="password"
                                    class="w-full mt-1 border border-gray-300 rounded-md px-3 py-2"
                                    placeholder="Enter new password"
                                />
                            </div>
                            <div>
                                <label
                                    for="password_confirmation"
                                    class="block text-sm text-gray-600"
                                    >Confirm Password</label
                                >
                                <input
                                    id="password_confirmation"
                                    v-model="form.password_confirmation"
                                    type="password"
                                    class="w-full mt-1 border border-gray-300 rounded-md px-3 py-2"
                                    placeholder="Confirm password"
                                />
                            </div>
                            <button
                                type="submit"
                                class="w-full bg-cyan-500 hover:bg-cyan-600 text-white py-2 px-4 rounded-lg transition duration-200"
                            >
                                Save Password
                            </button>
                        </form>
                    </div>

                    <!-- Email Update Section -->
                    <div
                        class="email-update bg-gray-50 border border-gray-200 rounded-lg p-4 shadow-sm"
                    >
                        <h2 class="text-lg font-semibold text-gray-700 mb-2">
                            Update Email
                        </h2>
                        <form
                            @submit.prevent="updateSettings"
                            class="space-y-4"
                        >
                            <div>
                                <label
                                    for="email"
                                    class="block text-sm text-gray-600"
                                    >New Email Address</label
                                >
                                <input
                                    id="email"
                                    v-model="form.email"
                                    type="email"
                                    class="w-full mt-1 border border-gray-300 rounded-md px-3 py-2"
                                    placeholder="Enter your email"
                                />
                            </div>
                            <button
                                type="submit"
                                class="w-full bg-teal-500 hover:bg-teal-600 text-white py-2 px-4 rounded-lg transition duration-200"
                            >
                                Update Email
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </FrontPageLayout>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3"; // Inertia's form helper
import { defineProps } from "vue";
import { useToast } from "vue-toastification";

import FrontPageLayout from "../../Layouts/FrontPageLayout.vue";

const toast = useToast();

// Define props for user data passed from Laravel
const props = defineProps({
    user: Object,
});

// Initialize form with user data
const form = useForm({
    email: props.user.email,
    password: "",
    password_confirmation: "",
});

// Function to handle form submission for both email and password updates
const updateSettings = () => {
    form.post(route("settings.update"), {
        preserveScroll: true,
        onSuccess: () => {
            toast.success("Changes saved successfully!");
        },
        onError: () => {
            alert("Error saving changes.");
        },
    });
};
</script>
