<script setup lang="ts">
import { Head, Form } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';


</script>

<template>
    <Head title="Создание поста" />

    <Form
        action="/posts"
        method="post"
        v-slot="{ errors, processing }"
        class="max-w-md"
    >
        <div>
            <label>Заголовок</label>
            <input type="text" name="title" 
            class="w-full p-2 bg-gray-700 text-white rounded" />
            <InputError :message="errors.title" />            
        </div>

        <div>
            <label>Содержание</label>
            <textarea name="body" rows="6"
                class="w-full p-2 bg-gray-700 text-white rounded rows-8"></textarea>
            <InputError :message="errors.body" />
        </div>        
        
        <button 
            type="submit" 
            :disabled="processing"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 disabled:opacity-50">
            Создать
        </button>
    </Form> 

  
</template>