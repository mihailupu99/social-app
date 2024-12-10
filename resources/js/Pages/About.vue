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
            <h2>About page</h2>
        </div>
    </app-layout>
</template>

<script setup>
import FrontPageLayout from "../Layouts/FrontPageLayout.vue";

defineOptions({
    layout: FrontPageLayout,
});
</script>
