<template>
    <header class="text-teal-900">
        <nav class="container mx-auto flex items-center justify-between p-4">
            <!-- Logo -->
            <a href="/" class="text-2xl font-bold tracking-widest"> SOCIARI </a>

            <!-- Navigation Links -->
            <div
                class="flex flex-row justify-center items-center rounded-2xl bg-gray-300"
            >
                <div class="flex space-x-4">
                    <Link
                        :href="route('home')"
                        class="text-base font-semibold hover:text-gray-400 hover:underline pl-4 transition"
                        >Home</Link
                    >
                    <Link
                        :href="route('about')"
                        class="text-base font-semibold hover:text-gray-400 pr-4 hover:underline transition"
                        >About</Link
                    >
                </div>

                <!-- User Actions -->
                <div
                    v-if="$page.props.auth.user"
                    class="space-x-6 flex flex-row justify-center items-center"
                >
                    <Link
                        :href="route('feed')"
                        class="text-base font-semibold hover:text-gray-400 hover:underline transition"
                        >My feed</Link
                    >
                    <Link
                        :href="route('settings')"
                        class="text-base font-semibold hover:text-gray-400 hover:underline transition"
                        >Profile</Link
                    >
                    <Link
                        :href="route('logout')"
                        method="post"
                        as="button"
                        type="button"
                        class="bg-teal-600 text-white px-3 py-1 rounded-2xl hover:bg-teal-900 transition"
                        >Logout</Link
                    >
                </div>

                <div v-else class="flex items-center space-x-4">
                    <button
                        @click="$emit('login')"
                        class="bg-teal-600 text-white px-3 py-1 rounded-2xl hover:bg-teal-900 transition"
                    >
                        Login / Register
                    </button>
                    <!-- <button
                    @click="$emit('register')"
                    class="bg-teal-600 text-white px-3 py-1 rounded-2xl hover:bg-teal-900 transition"
                >
                    Register
                </button> -->
                </div>
            </div>
        </nav>
    </header>
</template>

<script setup>
import { route } from "../../../../vendor/tightenco/ziggy/src/js";

defineEmits(["login", "register"]);
</script>
