<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    post: Object,
});

</script>

<template>
    <Head :title="post.title" />

    <div class="max-w-3xl mx-auto p-6">
        <Link href="/posts" class="text-sm text-blue-300 hover:underline">← К списку</Link>

        <article class="mt-4 rounded-lg p-6 dark:bg-gray-800">
            <h1 class="text-2xl font-bold mb-4">{{ post.title }}</h1>
            <p class="text-gray-300 whitespace-pre-line">{{ post.body }}</p>
        </article>

        <Link :href="'/posts/' + post.id + '/edit'" class="inline-block mt-4 bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded">
            Редактировать
        </Link>
    </div>

</template>