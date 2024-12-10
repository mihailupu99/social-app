<template>
    <div class="w-full max-w-sm p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-gray-800 text-center">Login</h2>
        <form class="mt-6">
            <!-- Email/Username Field -->
            <div class="mb-4">
                <label
                    for="email"
                    class="block text-sm font-medium text-gray-600"
                    >Email</label
                >
                <input
                    type="email"
                    id="email"
                    placeholder="Enter your email"
                    class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none"
                    required
                />
            </div>

            <!-- Password Field -->
            <div class="mb-4">
                <label
                    for="password"
                    class="block text-sm font-medium text-gray-600"
                    >Password</label
                >
                <input
                    type="password"
                    id="password"
                    placeholder="Enter your password"
                    class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none"
                    required
                />
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between mb-6">
                <label class="flex items-center text-sm text-gray-600">
                    <input
                        type="checkbox"
                        class="mr-2 rounded border-gray-300 focus:ring-blue-400"
                    />
                    Remember Me
                </label>
                <a href="#" class="text-sm text-blue-500 hover:underline">
                    Forgot Password?
                </a>
            </div>

            <!-- Submit Button -->
            <button
                type="submit"
                class="w-full px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400"
            >
                Login
            </button>
        </form>
    </div>
</template>
