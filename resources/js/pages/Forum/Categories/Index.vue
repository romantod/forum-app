<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { Bookmark } from 'lucide-vue-next';

defineProps({ categories: Array, isAdmin: Boolean });

</script>

<template>

    <Head title="Форум" />

    <div class="w-full max-w-2xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6 text-white">Форум</h1>

        <div class="flex justify-between justify-end">
            <Link v-if="isAdmin" href="/admin/categories" class="bg-purple-700 hover:bg-purple-600 
                text-white px-3 py-1.5 rounded mb-4">⚙️ Админка</Link>
        </div>

        <h2 class="text-gray-400 font-semibold mb-4">Всего разделов: {{ categories.length }}</h2>
        
        <div class="space-y-4">
            <Link v-for="category in categories" :key="category.id" :href="'/forum/' + category.slug"
                class="group rounded-lg border border-gray-700 bg-gray-800 p-5 
                    hover:border-blue-500 transition flex items-start justify-between">
                    
                <div class="flex items-start gap-3">
                    <div class="p-2 rounded-lg bg-gray-700 group-hover:bg-blue-500/20 transition">
                        <Bookmark class="w-5 h-5 text-gray-300 group-hover:text-blue-400 transition" /> 
                    </div>
                        
                    <div>
                        <h2 class="text-lg font-semibold mb-2">{{ category.name }}</h2>
                        <p class="text-gray-300">{{ category.description }}</p>
                        <p v-if="category.threads.length" class="text-xs text-gray-400 mt-2">
                            Последняя: <span class="text-gray-200">{{ category.threads[0].title }}</span>
                            . {{ category.threads[0].user.name }}
                        </p>
                    </div>
                </div>

                <span class="text-xs">Тем: {{ category.threads_count }}</span>
            </Link>
        </div>
    </div>
    
</template>