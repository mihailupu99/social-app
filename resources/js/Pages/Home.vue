<template>
    <app-layout>
        <Head :title="` | ${$page.component}`" />

        <!-- <div>Hello {{ $page.props.auth.user.name }}</div>
        <div>Your email: {{ $page.props.auth.user.email }}</div> -->
        <!-- <div v-if="$page.props.auth.user">
            Hello {{ $page.props.auth.user.name }}
        </div>
        <div v-else>Hello unlogged user</div> -->
        <div>
            <h2 class="text-teal-700 text-6xl font-semibold">
                Welcome to the social internet.
            </h2>
            <img :src="bannerImage" alt="" class="" />
        </div>
    </app-layout>
</template>

<script setup>
import FrontPageLayout from "../Layouts/FrontPageLayout.vue";
import bannerImage from "@/assets/images/main-banner.png";

defineOptions({
    layout: FrontPageLayout,
});
</script>
