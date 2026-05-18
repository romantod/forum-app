<script setup lang="ts">
import { Link, router, Head } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const props = defineProps({
    posts: Object,
    search: String,
});

const searchQuery = ref(props.search ?? '');

let timeout: ReturnType<typeof setTimeout>;
watch(searchQuery, (value) => {
    clearTimeout(timeout);
    timeout = setTimeout(() => {
        router.get('/posts', { search: value }, {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        });
    }, 300);
});

</script>

<template>
    <Head title="Посты" />

    <input
        v-model="searchQuery"
        type="text"
        placeholder="Поиск..."
        class="w-full p-2 mb-4 rounded bg-gray-700 text-white"
    />

    <div class="max-w-3xl mx-auto p-6 space-y-6">
        <div v-for="(post, index) in posts.data" :key="post.id" class="bg-white rounded-lg shadow p-4 dark:bg-green-800">
            <span>{{ posts.from + index }}</span>
            <h2 class="text-xl font-semibold mb-2">{{ post.title }}</h2> 
            <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ post.body }}</p>
        </div>
    </div>

    <div class="flex gap-2 mt-6">
        <Link
            v-for="link in posts.links"
            :key="link.label"
            :href="link.url || '#'"
            v-html="link.label"
            :class="[
                'px-3 py-1 rounded',
                link.active ? 'bg-blue-600 text-white' : 'bg-gray-700 text-gray-200',
                !link.url ? 'opacity-50 pointer-events-none' : 'hover:bg-blue-500' 
            ]"
        />
    </div>
    
</template>