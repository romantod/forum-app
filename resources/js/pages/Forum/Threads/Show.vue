<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { MoveLeft } from '@lucide/vue';

const props = defineProps({ thread: Object })

const deleteThread = () => {
    if (!confirm('Удалить тему?')) return;
    router.delete('/forum/' + props.thread.category.slug + '/' + props.thread.slug);
};

</script>

<template>
    <Head :title="thread.title" />

    <div class="max-w-3xl mx-auto p-6">
        <div class="mb-6">
            <Link :href="'/forum/' + thread.category.slug" class="bg-green-800 hover:bg-green-600 text-white px-4 py-2 rounded">
                <MoveLeft class="w-5 h-5 inline-block" />&nbsp;&nbsp;&nbsp;К темам
            </Link>
        </div>

        <div class="space-y-6 select-none">
            <p class="font-bold text-2xl text-white">{{ thread.title }}</p>
            <p class="text-gray-400 text-sm mb-2 mt-2">{{ thread.user.name }} · 
                {{ new Date(thread.created_at).toLocaleString('ru-RU') }}</p>
            
            <p class="mt-4 text-gray-200 leading-relaxed">{{ thread.body }}</p>

            <Link :href="'/forum/' + thread.category.slug + '/' + thread.slug + '/edit'"
                class="px-3 py-1.5 rounded bg-gray-700 text-blue-300 hover:bg-blue-600 
                    hover:text-white transition cursor-pointer">
                ✏️ Редактировать
            </Link>

            <button
                @click="deleteThread()"
                class="px-3 py-1.5 rounded bg-gray-700 text-red-300 
                    hover:bg-red-600 hover:text-white transition cursor-pointer m-2">
                🗑️ Удалить
            </button>
            
            <hr class="border-gray-700 my-6">
 
            <p class="font-semibold text-lg">Ответов: {{ thread.replies.length }}</p>

            <div v-for="reply in thread.replies" :key="reply.id"
                class="rounded-lg border border-gray-700 bg-gray-800 p-5 
                    hover:border-blue-500 transition">

                <p class="text-sm mb-2 font-semibold text-white">{{ reply.user.name }}</p>                
                <p class="text-gray-400 text-xs mb-2">{{ new Date(reply.created_at).toLocaleString('ru-RU') }}</p>
                <p class="text-gray-300 mb-4">{{ reply.body }}</p>
                               
            </div>

            <hr class="border-gray-700 my-6">

            <div>
                <p class="font-semibold text-lg mb-4">Написать ответ</p>
                <textarea rows="4" placeholder="Ваш ответ..." class="w-full p-3 rounded bg-gray-700 text-white 
                    placeholder-gray-400 border border-gray-600"></textarea>
                <button class="mt-2 bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded">
                    Отправить
                </button>
            </div>

        </div>
    </div>
</template>