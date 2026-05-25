<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({ category: Object });
const form = useForm({ title: thread.title, body: thread.body });
const submit = () => form.put('/forum/' + category.slug + '/' + thread.slug);

</script>

<template>
    <Head title="Сохранить тему" />
    <Link href="'/forum/' + thread.category.slug">← Назад к темам</Link>
    <p> Создать тему в: {{ category.name }}</p>
    <div class="max-w-3xl mx-auto p-6">
        <input v-model="form.title" >
        <textarea v-model="form.body" rows="8"></textarea>
        
        <p v-if="form.errors.title">{{ form.errors.title }}</p>
        <p v-if="form.errors.body">{{ form.errors.body }}</p>

        <button @click="submit" :disabled="form.processing">Сохранить</button>
    </div>
</template>