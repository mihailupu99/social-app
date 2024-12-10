<template>
    <div
        class="settings-page max-w-3xl mx-auto p-6 bg-white shadow-lg rounded-lg"
    >
        <h1 class="text-3xl font-semibold mb-6 text-gray-800">
            Account Settings
        </h1>

        <!-- User Information Section -->
        <div
            class="user-info mb-8 p-6 bg-gray-50 border border-gray-200 rounded-lg"
        >
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">
                User Information
            </h2>
            <div class="space-y-4">
                <!-- Email field -->
                <div>
                    <label
                        for="email"
                        class="block text-sm font-medium text-gray-600"
                        >Email</label
                    >
                    <p class="mt-1 text-lg text-gray-800">{{ form.email }}</p>
                </div>

                <!-- Password field (placeholder) -->
                <div>
                    <label
                        for="password"
                        class="block text-sm font-medium text-gray-600"
                        >Password</label
                    >
                    <p class="mt-1 text-lg text-gray-800">••••••••</p>
                </div>
            </div>
        </div>

        <!-- Password Update Section -->
        <div
            class="password-update mb-8 p-6 bg-gray-50 border border-gray-200 rounded-lg"
        >
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">
                Update Password
            </h2>
            <form @submit.prevent="updateSettings" class="space-y-6">
                <!-- New Password field -->
                <div>
                    <label
                        for="password"
                        class="block text-sm font-medium text-gray-600"
                        >New Password</label
                    >
                    <input
                        id="password"
                        v-model="form.password"
                        type="password"
                        class="mt-1 block w-full border border-gray-300 rounded-md p-3 text-lg"
                        placeholder="Enter new password"
                    />
                </div>

                <!-- Confirm Password field -->
                <div>
                    <label
                        for="password_confirmation"
                        class="block text-sm font-medium text-gray-600"
                        >Confirm Password</label
                    >
                    <input
                        id="password_confirmation"
                        v-model="form.password_confirmation"
                        type="password"
                        class="mt-1 block w-full border border-gray-300 rounded-md p-3 text-lg"
                        placeholder="Confirm new password"
                    />
                </div>

                <!-- Submit Button -->
                <button
                    type="submit"
                    class="w-full bg-blue-500 text-white py-3 px-6 rounded-lg hover:bg-blue-600 text-lg"
                >
                    Save Changes
                </button>
            </form>
        </div>

        <!-- Email Update Section -->
        <div
            class="email-update p-6 bg-gray-50 border border-gray-200 rounded-lg"
        >
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">
                Update Email
            </h2>
            <form @submit.prevent="updateSettings" class="space-y-6">
                <!-- Email field -->
                <div>
                    <label
                        for="email"
                        class="block text-sm font-medium text-gray-600"
                        >New Email</label
                    >
                    <input
                        id="email"
                        v-model="form.email"
                        type="email"
                        class="mt-1 block w-full border border-gray-300 rounded-md p-3 text-lg"
                        placeholder="Enter new email address"
                    />
                </div>

                <!-- Submit Button -->
                <button
                    type="submit"
                    class="w-full bg-green-500 text-white py-3 px-6 rounded-lg hover:bg-green-600 text-lg"
                >
                    Update Email
                </button>
            </form>
        </div>
    </div>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3"; // Inertia's form helper
import { defineProps } from "vue";
import { useToast } from "vue-toastification";

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
    // Post form data to the backend via Inertia
    form.post(route("settings.update"), {
        preserveScroll: true, // Preserve scroll position after form submission
        onSuccess: () => {
            toast.success("Information Updated succesfully");
        },
        onError: () => {
            alert("There was an error updating your settings.");
        },
    });
};
</script>

<style scoped>
/* You can add custom styles here if needed */
</style>
