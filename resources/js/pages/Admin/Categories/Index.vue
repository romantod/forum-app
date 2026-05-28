<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { MoveLeft, LayersPlus } from '@lucide/vue';


defineProps({ categories: Array });

const deleteCategory = (id: number) => {
    if (!confirm('Удалить категорию?')) return;
    router.delete('/admin/categories/' + id);
};
</script>

<template>
    <Head title="Admin page" />

    <div class="w-full max-w-2xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6 text-white">Admin page</h1>

        <div class="space-y-4">

            <div class="mb-6 flex justify-between">
                <Link :href="'/forum/'" class="bg-red-800 hover:bg-red-600 text-white px-3 py-2 rounded">
                    <MoveLeft class="w-6 h-6 inline-block" />&nbsp;&nbsp;&nbsp;Выйти из админки
                </Link>

                <Link :href="'/admin/categories/create'" class="bg-green-800 hover:bg-green-600 text-white px-3 py-2 rounded">
                    <LayersPlus class="w-6 h-6 inline-block" />&nbsp;&nbsp;&nbsp;Создать раздел
                </Link>
            </div>

            
            <h2 class="text-gray-400 font-semibold">Всего разделов: {{ categories.length }}</h2>

            <div v-for="category in categories" :key="category.id" :href="'/admin/' + category.slug" 
                class="w-full group rounded-lg border border-gray-700 bg-gray-900 p-5 
                    hover:border-blue-500 transition flex justify-between items-start">
                    
                <div class="flex items-start gap-3">

                    <div>
                        <h2 class="text-white text-lg font-semibold">{{ category.name }}</h2>
                        <p class="text-gray-300">{{ category.description }}</p>
                        <p class="text-gray-500">{{ category.threads_count }}</p>
                
                        <Link :href="'/admin/categories/' + category.id + '/edit'"
                            class="px-3 py-1.5 rounded bg-gray-700 text-sm text-blue-300 hover:bg-blue-600 
                                hover:text-white transition cursor-pointer">
                            ✏️ Редактировать
                        </Link>
                
                        <button
                            @click="deleteCategory(category.id)"
                            class="px-3 py-1.5 rounded bg-gray-700 text-sm text-red-300 
                                hover:bg-red-600 hover:text-white transition cursor-pointer m-2">
                            🗑️ Удалить
                        </button>   
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>