<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({ category: Object });
const form = useForm({ title: '', body: '' });
const submit = () => form.post('/forum/' + props.category.slug);

</script>

<template>
    <Head title="Создать тему" />    

    <div class="max-w-3xl p-6">
        <div class="mb-6">
            <Link :href="'/forum/' + category.slug" class="bg-green-800 hover:bg-green-600 text-white px-4 py-2 rounded">
                ← Назад к темам
            </Link>   
        </div>
    
        <div class="max-w-3xl mx-auto p-6 space-y-6">
            <h1 class="text-xl font-bold text-white mb-6">Создать тему в:
            <span class="text-2xl font-bold text-blue-400">{{ category.name }}</span></h1>

            <input v-model="form.title" class="w-full p-2 bg-gray-700 text-white rounded" placeholder="Заголовок темы">
            <textarea v-model="form.body" rows="8" class="w-full p-2 bg-gray-700 text-white rounded"></textarea>
            
            <p v-if="form.errors.title" class="text-red-400 text-sm">{{ form.errors.title }}</p>
            <p v-if="form.errors.body" class="text-red-400 text-sm">{{ form.errors.body }}</p>

            <button @click="submit" :disabled="form.processing" class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded">
                Создать
            </button>
        </div>
    </div>
</template>