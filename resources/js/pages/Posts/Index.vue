<script setup lang="ts">
import { router, Head, Link } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import { toast } from 'vue-sonner';

const props = defineProps({
    posts: Object,
    search: String,
});

const deletePost = (id: number) => {
    if (!confirm('Удалить пост?')) return;
    router.delete('/posts/' + id, {
        onSuccess: () => toast.success('Пост удалён!'),
    });
};

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

    <div class="max-w-3xl mx-auto p-6">
        <div class="flex items-center justify-between mb-6">
            <input
                v-model="searchQuery"
                type="text"
                placeholder="Поиск..."
                class="w-64 p-2 rounded bg-gray-700 text-white placeholder-gray-400"
            />
            <Link
                href="/posts/create"
                class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded text-sm"
            >
                + Создать пост
            </Link>
        </div>

        <div class="space-y-4">
            <div
                v-for="post in posts.data"
                :key="post.id"
                class="rounded-lg border border-gray-700 bg-gray-800 p-5"
            >
                <div class="flex items-start justify-between mb-3">
                    <h2 class="text-lg font-semibold text-white">
                        <Link :href="'/posts/' + post.id">{{ post.title }}</Link>
                    </h2>
                    <div class="flex gap-2 shrink-0 ml-4">
                        <a
                            :href="'/posts/' + post.id + '/edit'"
                            class="text-xs px-3 py-1.5 rounded bg-gray-700 text-blue-300 
                                hover:bg-blue-600 hover:text-white transition cursor-pointer"
                        >
                            ✏️ Изменить
                        </a>
                        <button
                            @click="deletePost(post.id)"
                            class="text-xs px-3 py-1.5 rounded bg-gray-700 text-red-300 
                                hover:bg-red-600 hover:text-white transition cursor-pointer"
                        >
                            🗑️ Удалить
                        </button>
                    </div>
                </div>
                <p class="text-gray-300 whitespace-pre-line leading-relaxed">{{ post.body }}</p>
            </div>
        </div>
            
        <div class="flex gap-2 mt-8 justify-center">
            <a
                v-for="link in posts.links"
                :key="link.label"
                :href="link.url || '#'"
                v-html="link.label"
                :class="[
                    'px-3 py-1 rounded text-sm',
                    link.active ? 'bg-blue-600 text-white' : 'bg-gray-700 text-gray-300',
                    !link.url ? 'opacity-40 pointer-events-none' : 'hover:bg-blue-500 hover:text-white']">
            </a>
        </div>
    </div>    
</template>
