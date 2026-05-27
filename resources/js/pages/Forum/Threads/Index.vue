<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { LayersPlus, MessageCircle, MoveLeft } from '@lucide/vue';
import { ref, watch } from 'vue';

const props = defineProps({ category: Object, threads: Object, search: String, sort: String });

const searchQuery = ref(props.search ?? '');
const currentSort = ref(props.sort ?? 'latest');

let timeout: ReturnType<typeof setTimeout>;
watch(searchQuery, (value) => {
    clearTimeout(timeout);
    timeout = setTimeout(() => {
        router.get('/forum/' + props.category.slug, { search: value, sort: currentSort.value }, {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        });
    }, 300);
});

const setSort = (sort: string) => {
    currentSort.value = sort;
    router.get('/forum/' + props.category.slug, { search: searchQuery.value, sort }, {
        preserveState: true,
        preserveScroll: true,
        replace: true,
    });
};

</script>

<template>    
    <Head :title="category.name" />

    <div class="max-w-3xl mx-auto p-6 space-y-4">
        <div class="flex items-center justify-between mb-6">
            <Link :href="'/forum'" class="bg-green-800 hover:bg-green-600 text-white px-4 py-2 rounded">
                <MoveLeft class="w-5 h-5 inline-block" />&nbsp;&nbsp;&nbsp;К разделам
            </Link>

            <input v-model="searchQuery" type="text" placeholder="Поиск тем..." 
                class="w-64 p-2 rounded bg-gray-700 text-white placeholder-gray-400"/>

            
        </div>

        <div class="font-bold border border-yellow-500 bg-gray-700 rounded-lg p-3">
            <h1 class="text-white mb-2">{{ category.name }}</h1>
            <p class="text-white">{{ category.description }}</p>
        </div>

        <div class="flex justify-between py-5">

            <div>
                <button @click="setSort('latest')" :class="currentSort === 'latest' ? 'bg-blue-600 text-white' : 
                    'bg-gray-700 text-gray-300'" class="px-4 py-2 rounded">
                    Новые
                </button>

                <button @click="setSort('popular')" :class="currentSort === 'popular' ? 'bg-blue-600 text-white' : 
                    'bg-gray-700 text-gray-300'" class="px-4 py-2 rounded ml-4">
                    Популярные
                </button>
            </div>

            <div>
                <Link :href="'/forum/' + category.slug + '/create'" class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded">
                    <LayersPlus class="w-5 h-5 inline-block" /> Создать тему                
                </Link>
            </div>
        </div>        

        <Link v-for="thread in threads.data" :key="thread.id"
            :href="'/forum/' + category.slug + '/' + thread.slug"
            class="group rounded-lg border border-gray-700 bg-gray-800 p-5 
                hover:border-blue-500 transition flex justify-between items-center">

            <div class="flex items-center gap-3">

                <div class="p-2 rounded-lg bg-gray-700 group-hover:bg-blue-500/20 transition">
                    <MessageCircle class="w-5 h-5 text-gray-300 group-hover:text-blue-400 transition" /> 
                </div>
    
                <h2 class="text-white font-semibold">
                    {{ thread.title }}
                </h2>            

            </div>
            
            <div class="text-right shrink-0 ml-4">
                <p class="text-gray-300">{{ thread.user.name }}</p>
                <p class="text-gray-400 text-xs">{{ new Date(thread.created_at).toLocaleString('ru-RU') }}</p>
                <p class="text-gray-400 text-xs">Ответов: {{ thread.replies_count }}</p>
            </div>
        </Link>

        <div class="flex gap-2 mt-8 justify-center">
            <a v-for="link in threads.links"
                :key="link.label"
                :href="link.url || '#'"
                v-html="link.label"
                :class="[
                    'px-3 py-1 rounded text-sm',
                    link.active ? 'bg-blue-600 text-white' : 'bg-gray-700 text-gray-300',
                    !link.url ? 'opacity-40 pointer-events-none' : 'hover:bg-blue-500 hover:text-white',
                ]"
            />
        </div>
    </div>

</template>