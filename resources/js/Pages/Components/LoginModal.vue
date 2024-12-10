<template>
    <TransitionRoot appear :show="isOpen" as="template">
        <Dialog as="div" @close="closeModal" class="relative z-50">
            <TransitionChild
                as="template"
                enter="duration-300 ease-out"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="duration-200 ease-in"
                leave-from="opacity-100"
                leave-to="opacity-0"
            >
                <div class="fixed inset-0 bg-black/25" />
            </TransitionChild>

            <div class="fixed inset-0 overflow-y-auto">
                <div class="flex min-h-full items-center justify-center p-4">
                    <TransitionChild
                        as="template"
                        enter="duration-300 ease-out"
                        enter-from="opacity-0 scale-95"
                        enter-to="opacity-100 scale-100"
                        leave="duration-200 ease-in"
                        leave-from="opacity-100 scale-100"
                        leave-to="opacity-0 scale-95"
                    >
                        <DialogPanel
                            class="w-full max-w-md transform overflow-hidden rounded-lg bg-white p-6 shadow-xl transition-all"
                        >
                            <DialogTitle
                                as="h3"
                                class="text-2xl font-semibold leading-6 text-gray-700"
                            >
                                Login
                            </DialogTitle>

                            <form @submit.prevent="handleSubmit" class="mt-4">
                                <div class="space-y-4">
                                    <div>
                                        <label
                                            for="email"
                                            class="block text-base font-semibold text-gray-700"
                                        >
                                            Email
                                        </label>
                                        <input
                                            id="email"
                                            type="email"
                                            v-model="form.email"
                                            class="mt-1 p-2 block w-full rounded-md border-teal-300 focus:border-teal-500 focus:ring-teal-500 focus:ring-2 focus:ring-offset-0 focus:outline-none transition duration-150 ease-in-out bg-rose-50"
                                            required
                                        />
                                        <div
                                            v-if="form.errors.email"
                                            class="mt-1 text-sm text-red-600"
                                        >
                                            {{ form.errors.email }}
                                        </div>
                                    </div>

                                    <div>
                                        <label
                                            for="password"
                                            class="block text-base font-semibold text-gray-700"
                                        >
                                            Password
                                        </label>
                                        <input
                                            id="password"
                                            type="password"
                                            v-model="form.password"
                                            class="mt-1 p-2 block w-full rounded-md border-teal-300 focus:border-teal-500 focus:ring-teal-500 focus:ring-2 focus:ring-offset-0 focus:outline-none transition duration-150 ease-in-out"
                                            required
                                        />
                                        <div
                                            v-if="form.errors.password"
                                            class="mt-1 text-sm text-red-600"
                                        >
                                            {{ form.errors.password }}
                                        </div>
                                    </div>

                                    <div
                                        class="flex items-center justify-between"
                                    >
                                        <div class="flex items-center">
                                            <input
                                                id="remember"
                                                type="checkbox"
                                                v-model="form.remember"
                                                class="h-4 w-4 rounded border-gray-300 focus:ring-indigo-500 accent-teal-500"
                                            />
                                            <label
                                                for="remember"
                                                class="ml-2 block text-sm text-gray-900"
                                            >
                                                Remember me
                                            </label>
                                        </div>

                                        <Link
                                            href="/forgot-password"
                                            class="text-sm font-medium text-cyan-600 hover:text-cyan-800"
                                        >
                                            Forgot password?
                                        </Link>
                                    </div>

                                    <div>
                                        <button
                                            type="submit"
                                            :disabled="form.processing"
                                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-teal-600 hover:bg-teal-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50"
                                        >
                                            {{
                                                form.processing
                                                    ? "Logging in..."
                                                    : "Login"
                                            }}
                                        </button>
                                        <div
                                            class="text-center text-sm text-gray-600"
                                        >
                                            Do not have an account yet?
                                            <button
                                                type="button"
                                                @click="switchToRegister"
                                                class="text-teal-600 hover:text-teal-500 font-medium ml-1"
                                            >
                                                Register here
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script setup>
import { ref } from "vue";
import { useForm, Link } from "@inertiajs/vue3";
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogTitle,
} from "@headlessui/vue";

const form = useForm({
    email: "",
    password: "",
    remember: false,
});

const isOpen = ref(false);

const emit = defineEmits(["switch-to-register"]);

const closeModal = () => {
    isOpen.value = false;
};

const openModal = () => {
    isOpen.value = true;
};

const handleSubmit = () => {
    form.post("/login", {
        onSuccess: () => {
            closeModal();
            form.reset();
        },
    });
};

const switchToRegister = () => {
    closeModal();
    emit("switch-to-register");
};

defineExpose({ openModal, closeModal });
</script>
