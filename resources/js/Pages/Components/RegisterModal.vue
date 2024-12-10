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
                            <div class="flex justify-between items-center mb-4">
                                <DialogTitle
                                    as="h3"
                                    class="text-lg font-medium text-gray-900"
                                >
                                    Register
                                </DialogTitle>
                                <button
                                    @click="closeModal"
                                    class="text-gray-400 hover:text-gray-500"
                                >
                                    <XMarkIcon class="h-6 w-6" />
                                </button>
                            </div>

                            <form @submit.prevent="handleSubmit">
                                <div class="space-y-4">
                                    <div>
                                        <label
                                            for="username"
                                            class="block text-sm font-medium text-gray-700"
                                        >
                                            Your username
                                        </label>
                                        <input
                                            id="username"
                                            type="text"
                                            v-model="form.username"
                                            class="mt-1 p-2 block w-full rounded-md border-teal-300 focus:border-teal-500 focus:ring-teal-500 focus:ring-2 focus:ring-offset-0 focus:outline-none transition duration-150 ease-in-out"
                                            required
                                        />
                                        <div
                                            v-if="form.errors.username"
                                            class="mt-1 text-sm text-red-600"
                                        >
                                            {{ form.errors.username }}
                                        </div>
                                    </div>

                                    <div>
                                        <label
                                            for="email"
                                            class="block text-sm font-medium text-gray-700"
                                        >
                                            Email
                                        </label>
                                        <input
                                            id="email"
                                            type="email"
                                            v-model="form.email"
                                            class="mt-1 p-2 block w-full rounded-md border-teal-300 focus:border-teal-500 focus:ring-teal-500 focus:ring-2 focus:ring-offset-0 focus:outline-none transition duration-150 ease-in-out"
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
                                            class="block text-sm font-medium text-gray-700"
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

                                    <div>
                                        <label
                                            for="password_confirmation"
                                            class="block text-sm font-medium text-gray-700"
                                        >
                                            Confirm Password
                                        </label>
                                        <input
                                            id="password_confirmation"
                                            type="password"
                                            v-model="form.password_confirmation"
                                            class="mt-1 p-2 block w-full rounded-md border-teal-300 focus:border-teal-500 focus:ring-teal-500 focus:ring-2 focus:ring-offset-0 focus:outline-none transition duration-150 ease-in-out"
                                            required
                                        />
                                    </div>

                                    <div>
                                        <button
                                            type="submit"
                                            :disabled="form.processing"
                                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 disabled:opacity-50 transition duration-150 ease-in-out"
                                        >
                                            {{
                                                form.processing
                                                    ? "Creating account..."
                                                    : "Register"
                                            }}
                                        </button>
                                    </div>

                                    <div
                                        class="text-center text-sm text-gray-600"
                                    >
                                        Already have an account?
                                        <button
                                            type="button"
                                            @click="switchToLogin"
                                            class="text-teal-600 hover:text-teal-500 font-medium ml-1"
                                        >
                                            Login here
                                        </button>
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
import { useForm } from "@inertiajs/vue3";
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogTitle,
} from "@headlessui/vue";
import { XMarkIcon } from "@heroicons/vue/24/outline";
import { useToast } from "vue-toastification";

const toast = useToast();

const form = useForm({
    username: "",
    email: "",
    password: "",
    password_confirmation: "",
});

const isOpen = ref(false);

const emit = defineEmits(["switch-to-login"]);

const closeModal = () => {
    isOpen.value = false;
    form.reset();
};

const openModal = () => {
    isOpen.value = true;
};

const handleSubmit = () => {
    form.post("/register", {
        onSuccess: () => {
            closeModal();
            toast.success("User created successfully!");
        },
        onError: () => {
            form.reset("password", "password_confirmation");
            toast.error("Something went wrong!");
        },
    });
};

const switchToLogin = () => {
    closeModal();
    emit("switch-to-login");
};

defineExpose({ openModal, closeModal });
</script>
