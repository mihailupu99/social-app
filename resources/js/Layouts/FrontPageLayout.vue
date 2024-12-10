<template>
    <div>
        <!-- Include the Header Component -->
        <Header @login="openLoginModal" @register="openRegisterModal" />
        <!-- Page Content -->
        <main class="container mx-auto mt-8"><slot></slot></main>
    </div>

    <LoginModal ref="loginModal" @switch-to-register="openRegisterModal" />
    <RegisterModal ref="registerModal" @switch-to-login="openLoginModal" />
</template>

<script setup>
import { ref } from "vue";
import Header from "../Pages/Components/Header.vue";
import LoginModal from "../Pages/Components/LoginModal.vue";
import RegisterModal from "../Pages/Components/RegisterModal.vue";

const loginModal = ref(null);
const registerModal = ref(null);

const openLoginModal = () => {
    registerModal.value?.closeModal();
    loginModal.value?.openModal();
};

const openRegisterModal = () => {
    loginModal.value?.closeModal();
    registerModal.value?.openModal();
};
</script>
